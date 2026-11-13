<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    private const SORTS = ['terbaru', 'terlama', 'judul', 'tanggal_terbaru', 'tanggal_terlama'];

    public function projects(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $category = $request->query('category', '');
        $technology = $request->query('technology', '');
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
                ->whereHas('category', fn ($w) => $w->where('slug', $category)))
            ->when(filled($technology), fn ($q) => $q
                ->whereHas('technologies', fn ($w) => $w->where('slug', $technology)));

        switch ($sort) {
            case 'terlama':
                $query->oldest()->orderBy('id');
                break;
            case 'judul':
                $query->orderBy('nama')->orderBy('id');
                break;
            case 'tanggal_terbaru':
                $query->orderByRaw('project_date is null')->orderByDesc('project_date')->orderByDesc('id');
                break;
            case 'tanggal_terlama':
                $query->orderByRaw('project_date is not null')->orderBy('project_date')->orderBy('id');
                break;
            default:
                $query->latest()->orderByDesc('id');
        }

        $projects = $query->paginate(9)->withQueryString();

        return view('projects', [
            'projects'   => $projects,
            'categories' => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
            'search'     => $search,
            'category'   => $category,
            'technology' => $technology,
            'sort'       => $sort,
            'isFiltered' => $search !== '' || filled($category) || filled($technology) || $sort !== 'terbaru',
        ]);
    }

    public function show(Project $project): View
    {
        abort_if($project->status !== 'published', 404);

        $project->load(['category', 'technologies', 'images']);

        return view('portofolio.project', compact('project'));
    }
}
