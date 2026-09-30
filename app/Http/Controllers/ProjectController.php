<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Status;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::with(['category', 'status', 'technologies']);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($cat) => $cat->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('technologies', fn ($tech) => $tech->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_id', $request->input('status'));
        }

        // Filter by technology
        if ($request->filled('technology')) {
            $query->whereHas('technologies', fn ($q) => $q->where('technologies.id', $request->input('technology')));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->input('date_to'));
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'title' => $query->orderBy('title'),
            'start_date' => $query->orderBy('start_date', 'desc'),
            default => $query->latest(),
        };

        $projects = $query->paginate(9)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.index', compact('projects', 'categories', 'statuses', 'technologies'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.create', compact('categories', 'statuses', 'technologies'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Generate slug if not set
        if (empty($data['slug'])) {
            $data['slug'] = Project::generateSlug($data['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('projects', 'public');
            $data['thumbnail'] = basename($path);
        }

        $project = Project::create($data);

        // Attach technologies
        if (! empty($data['technologies'])) {
            $project->technologies()->attach($data['technologies']);
        }

        // Create features
        if (! empty($data['features'])) {
            foreach ($data['features'] as $feature) {
                $project->features()->create($feature);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project): View
    {
        $project->load(['category', 'status', 'technologies', 'features']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $project->load(['technologies', 'features']);
        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.edit', compact('project', 'categories', 'statuses', 'technologies'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        // Generate slug if not set
        if (empty($data['slug'])) {
            $data['slug'] = Project::generateSlug($data['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($project->thumbnail) {
                Storage::disk('public')->delete('projects/' . $project->thumbnail);
            }
            $path = $request->file('thumbnail')->store('projects', 'public');
            $data['thumbnail'] = basename($path);
        }

        $project->update($data);

        // Sync technologies
        $project->technologies()->sync($data['technologies'] ?? []);

        // Handle features - delete all and recreate
        $project->features()->delete();
        if (! empty($data['features'])) {
            foreach ($data['features'] as $feature) {
                $project->features()->create($feature);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        // Delete thumbnail
        if ($project->thumbnail) {
            Storage::disk('public')->delete('projects/' . $project->thumbnail);
        }

        // Delete features (cascade will handle this, but being explicit)
        $project->features()->delete();

        // Detach technologies
        $project->technologies()->detach();

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
