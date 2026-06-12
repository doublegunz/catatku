<x-layout title="Tags — Catatku">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Tags</h2>
        <a href="{{ route('entries.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Back to Entries
        </a>
    </div>

    <div class="space-y-2">
        @forelse ($tags as $tag)
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center justify-between">
                <a href="{{ route('tags.show', $tag) }}" style="font-weight: bold;" class="text-blue-700 hover:underline">
                    {{ $tag->name }}
                </a>
                <span style="color: #888;">({{ $tag->entries_count }} entries)</span>
            </div>
        @empty
            <p class="text-gray-400">No tags yet.</p>
        @endforelse
    </div>

</x-layout>
