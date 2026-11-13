<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    private const SORTS = ['terbaru', 'terlama', 'judul'];

    public function projects(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $category = $request->query('category', '');
        $sort = $request->query('sort', 'terbaru');
        if ($sort === 'az') {
            $sort = 'judul';
        }
        if (! in_array($sort, self::SORTS, true)) {
            $sort = 'terbaru';
        }

        $query = Project::published()
            ->with(['category', 'technologies'])
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('nama', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")))
            ->when(filled($category), fn ($q) => $q
                ->whereHas('category', fn ($w) => $w->where('slug', $category)));

        switch ($sort) {
            case 'terlama':
                $query->oldest()->orderBy('id');
                break;
            case 'judul':
                $query->orderBy('nama')->orderBy('id');
                break;
            default:
                $query->latest()->orderByDesc('id');
        }

        $projects = $query->paginate(9)->withQueryString();

        return view('projects', [
            'projects'   => $projects,
            'categories' => Category::orderBy('name')->get(),
            'search'     => $search,
            'category'   => $category,
            'sort'       => $sort,
        ]);
    }

    public function show(Project $project): View
    {
        abort_if($project->status !== 'published', 404);

        $project->load(['category', 'technologies', 'images']);

        return view('portofolio.project', compact('project'));
    }
}
