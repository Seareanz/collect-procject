@extends('layouts.app')

@section('title', 'Create Project')
@section('page-title', 'Create Project')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Add New Project</h2>
            <p class="text-sm text-gray-500 mt-1">Fill in the details to add a new project to your collection</p>
        </div>

        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Basic Info -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Project Name <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @endif" placeholder="Enter project name">
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @endif" placeholder="Describe your project...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @endif">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status_id" id="status_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status_id') border-red-500 @endif">
                            <option value="">Select a status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('status_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <input type="text" name="role" id="role" value="{{ old('role') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('role') border-red-500 @endif" placeholder="e.g. Lead Developer">
                        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @endif">
                        @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @endif">
                        @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Thumbnail -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Thumbnail</h3>
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Project Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('thumbnail') border-red-500 @endif">
                    <p class="mt-1 text-xs text-gray-500">JPEG, PNG, or WebP. Max 5MB.</p>
                    @error('thumbnail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Technologies -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Technologies</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Technologies</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @foreach($technologies as $tech)
                            <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="technologies[]" value="{{ $tech->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">{{ $tech->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('technologies') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- URLs -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Links</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="github_url" class="block text-sm font-medium text-gray-700 mb-1">GitHub URL</label>
                        <input type="url" name="github_url" id="github_url" value="{{ old('github_url') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('github_url') border-red-500 @endif" placeholder="https://github.com/...">
                        @error('github_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="demo_url" class="block text-sm font-medium text-gray-700 mb-1">Demo URL</label>
                        <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('demo_url') border-red-500 @endif" placeholder="https://...">
                        @error('demo_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Features (Dynamic) -->
            <div class="space-y-4" x-data="{ features: [{ name: '', description: '' }] }">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Features</h3>
                    <button type="button" @click="features.push({ name: '', description: '' })" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">+ Add Feature</button>
                </div>

                <template x-for="(feature, index) in features" :key="index">
                    <div class="flex items-start space-x-2 p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1 space-y-2">
                            <input type="text" name="features[][name]" x-model="feature.name" placeholder="Feature name" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <textarea name="features[][description]" x-model="feature.description" placeholder="Feature description (optional)" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        <button type="button" @click="features.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Notes -->
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Additional Notes</h3>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @endif" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                    @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">Create Project</button>
            </div>
        </form>
    </div>
</div>
