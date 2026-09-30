<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TechnologyController extends Controller
{
    public function index(): View
    {
        $technologies = Technology::withCount('projects')->orderBy('name')->paginate(10);

        return view('technologies.index', compact('technologies'));
    }

    public function create(): View
    {
        return view('technologies.create');
    }

    public function store(StoreTechnologyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        Technology::create($data);

        return redirect()->route('technologies.index')->with('success', 'Technology created successfully.');
    }

    public function edit(Technology $technology): View
    {
        return view('technologies.edit', compact('technology'));
    }

    public function update(UpdateTechnologyRequest $request, Technology $technology): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $technology->update($data);

        return redirect()->route('technologies.index')->with('success', 'Technology updated successfully.');
    }

    public function destroy(Technology $technology): RedirectResponse
    {
        if ($technology->projects()->count() > 0) {
            return redirect()->route('technologies.index')->with('error', 'Cannot delete technology with existing projects.');
        }

        $technology->delete();

        return redirect()->route('technologies.index')->with('success', 'Technology deleted successfully.');
    }
}
