<?php

namespace App\Http\Controllers;

use App\Models\{Category, Project, Skill, Technology};
use Illuminate\View\View;

class DashboardController extends Controller
{
public function index(): View {

return view('dashboard', [
            'totalProjects'   => Project::count(),
            'publishedCount'  => Project::published()->count(),
            'draftCount'      => Project::draft()->count(),
            'totalCategories' => Category::count(),
            'totalSkills'     => Skill::count(),
             'categories'      => Category::withCount('projects')
                                    ->orderByDesc('projects_count')
                                    ->orderBy('name')
                                    ->get(),
            'totalTechnologies' => Technology::count(),
            'topSkills'       => Skill::orderByDesc('level')->orderBy('name')->take(5)->get(),
            'latestProjects'  => Project::with('category')->latest()->take(5)->get(),
            ]);
}
}
