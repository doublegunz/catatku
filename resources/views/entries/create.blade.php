<x-layout title="Write Entry — Catatku">

    <div class="mb-6">
        <a href="/entries" class="text-sm text-gray-400 hover:text-gray-700">
            ← Back to list
        </a>
    </div>

    <h2 class="text-lg font-semibold text-gray-900 mb-4">Write New Entry</h2>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="/entries" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-5">
                <label for="title"
                       class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Entry title..."
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none
                           focus:ring-2 focus:ring-gray-900 focus:border-transparent
                           {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    autofocus
                >
                @error('title')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div class="mb-6">
                <label for="content"
                       class="block text-sm font-medium text-gray-700 mb-1">
                    Content
                </label>
                <textarea
                    id="content"
                    name="content"
                    rows="12"
                    placeholder="Write your entry here..."
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none
                           focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-y
                           {{ $errors->has('content') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cover image --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #1e293b;">
                    Cover Image (optional)
                </label>
                <input type="file" name="cover_image" accept="image/*"
                       style="border: 1px solid #d1d5db; border-radius: 6px; padding: 8px; width: 100%; box-sizing: border-box;">
                <p style="color: #9ca3af; font-size: 0.8em; margin-top: 4px;">
                    JPG, PNG, or WebP. Max 2MB.
                </p>
                @error('cover_image')
                    <p style="color: #dc2626; font-size: 0.85em; margin-top: 4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tag selection --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #1e293b;">Tags</label>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @foreach ($tags as $tag)
                        <label style="display: flex; align-items: center; gap: 4px; cursor: pointer;">
                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                @checked(is_array(old('tags')) && in_array($tag->id, old('tags')))
                            >
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-between">
                <a href="/entries"
                   class="text-sm text-gray-500 hover:text-gray-900">
                    Cancel
                </a>
                <x-button type="submit" variant="primary">
                    Save Entry
                </x-button>
            </div>

        </form>
    </div>

</x-layout>
