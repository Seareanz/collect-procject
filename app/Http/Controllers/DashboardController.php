<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Status;
use App\Models\Technology;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProjects = Project::count();
        $completedProjects = Project::whereHas('status', fn ($q) => $q->where('slug', 'completed'))->count();
        $inProgressProjects = Project::whereHas('status', fn ($q) => $q->where('slug', 'in-progress'))->count();
        $totalCategories = Category::count();

        $recentProjects = Project::with(['category', 'status', 'technologies'])
            ->latest()
            ->take(5)
            ->get();

        $statusSummary = Status::withCount('projects')->get();

        $technologyUsage = Technology::withCount('projects')
            ->orderByDesc('projects_count')
            ->take(8)
            ->get();

        return view('dashboard', compact(
            'totalProjects',
            'completedProjects',
            'inProgressProjects',
            'totalCategories',
            'recentProjects',
            'statusSummary',
            'technologyUsage',
        ));
    }
}
