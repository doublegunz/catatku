<x-layout :title="$tag->name . ' — Catatku'">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Tag: {{ $tag->name }}</h2>
        <a href="{{ route('tags.index') }}" class="text-sm text-blue-600 hover:underline">
            ← All Tags
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($entries as $entry)
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <a href="{{ route('entries.show', $entry) }}" class="font-semibold text-gray-900 hover:text-gray-600">
                    {{ $entry->title }}
                </a>
                <p class="text-xs text-gray-400 mt-1">by {{ $entry->user->name }}</p>
            </div>
        @empty
            <p class="text-gray-400">No entries with this tag.</p>
        @endforelse
    </div>

    <div style="margin-top: 20px;">
        {{ $entries->links() }}
    </div>

</x-layout>
