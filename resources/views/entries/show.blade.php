<x-layout :title="$entry->title . ' — Catatku'">

    <div class="mb-6">
        <a href="/entries" class="text-sm text-gray-400 hover:text-gray-700">
            ← Back to list
        </a>
    </div>

    <article class="bg-white rounded-xl border border-gray-200 p-6">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                {{ $entry->title }}
            </h1>
            <p class="text-sm text-gray-400">
                Written on {{ $entry->created_at->isoFormat('D MMMM Y') }}
                @if ($entry->updated_at->ne($entry->created_at))
                    · Updated {{ $entry->updated_at->diffForHumans() }}
                @endif
            </p>
        </div>

        {{-- Entry content --}}
        <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $entry->content }}
        </div>

    </article>

    {{-- Action buttons --}}
    <div class="flex items-center gap-3 mt-4">
        <a href="/entries/{{ $entry->id }}/edit"
           class="text-sm bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            Edit Entry
        </a>
        <form method="POST" action="/entries/{{ $entry->id }}"
              onsubmit="return confirm('Delete this entry?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="text-sm text-red-500 hover:text-red-700 transition-colors">
                Delete
            </button>
        </form>
    </div>

</x-layout>
