<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProjectGalleryController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        $request->validate([
            'images'   => 'required|array|max:' . Project::MAX_GALLERY_IMAGES,
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=800',
        ], [
            'images.required' => 'Pilih minimal satu gambar.',
            'images.max'      => 'Maksimal ' . Project::MAX_GALLERY_IMAGES . ' gambar sekali upload.',
            'images.*.image'  => 'File harus berupa gambar.',
            'images.*.mimes'  => 'Gambar harus berformat jpg, jpeg, png, atau webp.',
            'images.*.max'    => 'Ukuran tiap gambar maksimal 4 MB.',
            'images.*.dimensions' => 'Lebar gambar minimal 800 px.',
        ]);

        $files   = $request->file('images');
        $current = $project->images()->count();

        if ($current + count($files) > Project::MAX_GALLERY_IMAGES) {
            $sisa = max(0, Project::MAX_GALLERY_IMAGES - $current);

            throw ValidationException::withMessages([
                'images' => "Gallery maksimal " . Project::MAX_GALLERY_IMAGES
                    . " gambar per project. Saat ini ada {$current}, sisa slot {$sisa}.",
            ]);
        }

        $order = (int) $project->images()->max('sort_order');

        foreach ($files as $file) {
            $project->images()->create([
                'image'      => $file->store('projects/gallery', 'public'),
                'sort_order' => ++$order,
            ]);
        }

        return back()->with('success', count($files) . ' gambar berhasil diunggah.');
    }

    public function update(Request $request, Project $project, ProjectImage $image): RedirectResponse
    {
        abort_if($image->project_id != $project->id, 404);

        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ], [
            'caption.max' => 'Caption maksimal 255 karakter.',
        ]);

        $image->update(['caption' => $validated['caption'] ?? null]);

        return back()->with('success', 'Caption diperbarui.');
    }

    public function destroy(Project $project, ProjectImage $image): RedirectResponse
    {
        abort_if($image->project_id != $project->id, 404);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Gambar dihapus.');
    }
}
