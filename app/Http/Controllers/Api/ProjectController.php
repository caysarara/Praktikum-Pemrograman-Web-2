<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search   = trim((string) $request->query('search'));
        $category = $request->query('category', '');

        $projects = Project::with(['category', 'technologies'])
            ->where('status', 'published')
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('nama', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")))
            ->when(filled($category), fn ($q) => $q
                ->whereHas('category', fn ($w) => $w->where('slug', $category)))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        abort_if($project->status !== 'published', 404);

        return new ProjectResource($project->load(['category', 'technologies']));
    }
}

