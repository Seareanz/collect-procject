@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Projects -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Projects</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProjects }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Completed</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $completedProjects }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">In Progress</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $inProgressProjects }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Categories</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCategories }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Projects -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Projects</h2>
                <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View all</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentProjects as $project)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center space-x-4 min-w-0">
                            @if($project->thumbnail)
                                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $project->title }}</p>
                                <p class="text-xs text-gray-500">{{ $project->category->name }} · {{ $project->status->name }}</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.show', $project) }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex-shrink-0">View</a>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                        <p class="text-gray-500">No projects yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Status Summary -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Status Summary</h2>
            </div>
            <div class="p-6 space-y-4">
                @foreach($statusSummary as $status)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $status->name }}</span>
                            <span class="text-sm text-gray-500">{{ $status->projects_count }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            @php
                                $percentage = $totalProjects > 0 ? ($status->projects_count / $totalProjects) * 100 : 0;
                                $color = match($status->slug) {
                                    'completed' => 'bg-green-500',
                                    'in-progress' => 'bg-blue-500',
                                    'planning' => 'bg-yellow-500',
                                    'archived' => 'bg-gray-400',
                                    default => 'bg-gray-400',
                                };
                            @endphp
                            <div class="{{ $color }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Technology Usage -->
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Technology Usage</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($technologyUsage as $tech)
                    <div class="text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <span class="text-lg font-bold text-gray-600">{{ substr($tech->name, 0, 2) }}</span>
                        </div>
                        <p class="text-sm font-medium text-gray-900">{{ $tech->name }}</p>
                        <p class="text-xs text-gray-500">{{ $tech->projects_count }} projects</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
