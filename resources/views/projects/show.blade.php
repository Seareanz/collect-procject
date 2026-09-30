@extends('layouts.app')

@section('title', $project->title)
@section('page-title', $project->title)

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('projects.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Projects
    </a>

    <!-- Project Header -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Thumbnail -->
        <div class="aspect-video bg-gray-100">
            @if($project->thumbnail)
                <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-6 sm:p-8">
            <!-- Title & Status -->
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $project->title }}</h1>
                    <div class="flex items-center space-x-3 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $project->status->slug === 'completed' ? 'bg-green-100 text-green-800' : ($project->status->slug === 'in-progress' ? 'bg-blue-100 text-blue-800' : ($project->status->slug === 'planning' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ $project->status->name }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $project->category->name }}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <button onclick="openDeleteModal()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div class="prose max-w-none mb-8">
                <p class="text-gray-600 leading-relaxed">{{ $project->description }}</p>
            </div>

            <!-- Meta Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @if($project->role)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Role</p>
                        <p class="text-sm font-medium text-gray-900">{{ $project->role }}</p>
                    </div>
                @endif
                @if($project->start_date)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Start Date</p>
                        <p class="text-sm font-medium text-gray-900">{{ $project->start_date->format('M d, Y') }}</p>
                    </div>
                @endif
                @if($project->end_date)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">End Date</p>
                        <p class="text-sm font-medium text-gray-900">{{ $project->end_date->format('M d, Y') }}</p>
                    </div>
                @endif
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Category</p>
                    <p class="text-sm font-medium text-gray-900">{{ $project->category->name }}</p>
                </div>
            </div>

            <!-- Technologies -->
            @if($project->technologies->count() > 0)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">Technologies</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700">
                                {{ $tech->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Features -->
            @if($project->features->count() > 0)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">Features</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($project->features as $feature)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $feature->name }}</h4>
                                @if($feature->description)
                                    <p class="text-sm text-gray-500">{{ $feature->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Links -->
            @if($project->github_url || $project->demo_url)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">Links</h3>
                    <div class="flex flex-wrap gap-4">
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                GitHub
                            </a>
                        @endif
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Live Demo
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($project->notes)
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">Notes</h3>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700">{{ $project->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Delete Project?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete "{{ $project->title }}"? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete Project</button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
