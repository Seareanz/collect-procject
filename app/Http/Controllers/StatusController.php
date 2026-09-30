<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StatusController extends Controller
{
    public function index(): View
    {
        $statuses = Status::withCount('projects')->orderBy('name')->paginate(10);

        return view('statuses.index', compact('statuses'));
    }

    public function create(): View
    {
        return view('statuses.create');
    }

    public function store(StoreStatusRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        Status::create($data);

        return redirect()->route('statuses.index')->with('success', 'Status created successfully.');
    }

    public function edit(Status $status): View
    {
        return view('statuses.edit', compact('status'));
    }

    public function update(UpdateStatusRequest $request, Status $status): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $status->update($data);

        return redirect()->route('statuses.index')->with('success', 'Status updated successfully.');
    }

    public function destroy(Status $status): RedirectResponse
    {
        if ($status->projects()->count() > 0) {
            return redirect()->route('statuses.index')->with('error', 'Cannot delete status with existing projects.');
        }

        $status->delete();

        return redirect()->route('statuses.index')->with('success', 'Status deleted successfully.');
    }
}
