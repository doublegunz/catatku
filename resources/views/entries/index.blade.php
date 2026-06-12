<x-layout title="My Entries — Catatku">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">My Entries</h2>
        <a href="{{ route('entries.create') }}"
            class="bg-gray-900 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            + Write New Entry
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($entries as $entry)
            <x-entry-card :entry="$entry" />
        @empty
            <div class="text-center py-16">
                <p class="text-5xl mb-4">📓</p>
                <p class="font-medium text-gray-600">No entries yet</p>
                <p class="text-sm text-gray-400 mt-1">Start writing your first entry!</p>
                <a href="{{ route('entries.create') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">
                    Write now →
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $entries->links() }}
    </div>

</x-layout>
