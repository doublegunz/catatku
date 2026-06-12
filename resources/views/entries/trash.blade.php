<x-layout title="Trash — Catatku">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Trash</h2>
        <a href="{{ route('entries.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Back to Entries
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($entries as $entry)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="font-semibold text-gray-900">{{ $entry->title }}</p>
                    <p style="color: #9ca3af; font-size: 0.8em; margin-top: 4px;">
                        Deleted {{ $entry->deleted_at->diffForHumans() }}
                    </p>
                </div>
                <form method="POST" action="{{ route('entries.restore', $entry) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                        Restore
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <p class="text-5xl mb-4">🗑️</p>
            <p class="font-medium text-gray-600">Trash is empty</p>
            <p class="text-sm text-gray-400 mt-1">Deleted entries will appear here.</p>
        </div>
        @endforelse
    </div>

    <div style="margin-top: 20px;">
        {{ $entries->links() }}
    </div>

</x-layout>
