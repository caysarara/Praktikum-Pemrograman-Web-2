<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::orderBy('id');

        if ($request->query('status') === 'published') {
            $query->published();
        }

        $projects = $query->get();
        $trashedCount = Project::onlyTrashed()->count();

        return view('projects.index', compact('projects', 'trashedCount'));
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => 'required|string|min:5|max:255',
            'deskripsi' => 'required|string|min:10',
            'stack'     => 'nullable|string',
            'status'    => 'required|in:draft,published',
        ], [
            'nama.required'      => 'Nama project wajib diisi.',
            'nama.min'           => 'Nama project minimal 5 karakter.',
            'nama.max'           => 'Nama project maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min'      => 'Deskripsi minimal 10 karakter.',
            'status.required'    => 'Status wajib dipilih.',
            'status.in'          => 'Status harus draft atau published.',
        ]);
        
        $stack = collect(explode(',', $validated['stack'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        Project::create([
            'nama'      => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'stack'     => $stack,
            'status'    => $validated['status'],
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(Project $project): View
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', compact('project'));
    }

        public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => 'required|string|min:5|max:255',
            'deskripsi' => 'required|string|min:10',
            'stack'     => 'nullable|string',
            'status'    => 'required|in:draft,published',
        ], [
            'nama.required'      => 'Nama project wajib diisi.',
            'nama.min'           => 'Nama project minimal 5 karakter.',
            'nama.max'           => 'Nama project maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min'      => 'Deskripsi minimal 10 karakter.',
            'status.required'    => 'Status wajib dipilih.',
            'status.in'          => 'Status harus draft atau published.',
        ]);

        $stack = collect(explode(',', $validated['stack'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $project->update([
            'nama'      => $validated['nama'],
            'deskripsi' => $validated['deskripsi'],
            'stack'     => $stack,
            'status'    => $validated['status'],
        ]);

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
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()
            ->route('projects.trash')
            ->with('success', 'Project dihapus permanen.');
    }
}
