<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {

        $perPage = in_array((int) $request->query('per_page'), [5, 10, 25], true)
            ? (int) $request->query('per_page')
            : 10;

        $search = trim((string) $request->query('search', ''));

        $query = Project::with('category')->orderBy('id');

        if ($request->query('status') === 'published') {
            $query->published();
        }

        if ($search !== '') {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $projects = $query->paginate($perPage)->withQueryString();
        $trashedCount = Project::onlyTrashed()->count();

        return view('projects.index', compact('projects', 'trashedCount', 'search', 'perPage'));
    }

    public function create(): View
    {
        return view('projects.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
       $validated = $request->validate($this->rules(), $this->messages());

        $data = $this->payload($validated);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        Project::create($data);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(Project $project): View
    {
        $project->load(['category', 'images']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $project->load('images');

        return view('projects.edit', [
            'project'    => $project,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $data = $this->payload($validated);

        $oldThumbnail = $project->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $project->update($data);

        if ($request->hasFile('thumbnail') && $oldThumbnail) {
            Storage::disk('public')->delete($oldThumbnail);
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project berhasil diperbarui.');

    }

        public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }


    public function trash(): View
    {
        $projects = Project::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('projects.trash', compact('projects'));
    }

    public function restore(int $id): RedirectResponse
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()
            ->route('projects.trash')
            ->with('success', 'Project berhasil dipulihkan.');
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $project = Project::onlyTrashed()->with('images')->findOrFail($id);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->forceDelete();

        return redirect()
            ->route('projects.trash')
            ->with('success', 'Project dihapus permanen.');
    }

    private function rules(): array
    {
        return [
            'nama'        => 'required|string|min:5|max:255',
            'deskripsi'   => 'required|string|min:10',
            'stack'       => 'nullable|string',
            'status'      => 'required|in:draft,published',
            'category_id' => 'nullable|exists:categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ];
    }

    private function messages(): array
    {
        return [
            'nama.required'        => 'Nama project wajib diisi.',
            'nama.min'             => 'Nama project minimal 5 karakter.',
            'nama.max'             => 'Nama project maksimal 255 karakter.',
            'deskripsi.required'   => 'Deskripsi wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 10 karakter.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status harus draft atau published.',
            'category_id.exists'   => 'Kategori yang dipilih tidak ditemukan.',
            'thumbnail.image'      => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'      => 'Thumbnail harus berformat jpg, jpeg, png, atau webp.',
            'thumbnail.max'        => 'Ukuran thumbnail maksimal 2 MB.',
            'thumbnail.dimensions' => 'Thumbnail minimal 400 x 300 px.',
        ];
    }

    private function payload(array $validated): array
    {
        $stack = collect(explode(',', $validated['stack'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        return [
            'nama'        => $validated['nama'],
            'deskripsi'   => $validated['deskripsi'],
            'stack'       => $stack,
            'status'      => $validated['status'],
            'category_id' => $validated['category_id'] ?? null,
        ];
    }
}
