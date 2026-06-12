<div class="bg-white rounded-xl border border-gray-200 p-4 hover:border-gray-300 transition-colors">

    <div class="flex items-start justify-between gap-3 mb-3">
        <a href="{{ route('entries.show', $entry) }}"
            class="font-semibold text-gray-900 hover:text-gray-600 leading-snug">
            {{ $truncatedTitle() }}
        </a>
        <span class="text-xs text-gray-400 whitespace-nowrap mt-0.5">
            {{ $entry->created_at->format('d M Y') }}
        </span>
    </div>

    <p class="text-sm text-gray-500 line-clamp-2 mb-2">
        {{ $entry->excerpt }}
    </p>

    <span class="text-xs text-gray-400">
        {{ $entry->reading_time }} min read
    </span>

    @if($entry->tags->isNotEmpty())
        <div class="mt-2 flex flex-wrap gap-1">
            @foreach($entry->tags as $tag)
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full font-semibold">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    @endif

    <div class="flex items-center gap-3 pt-3 border-t border-gray-100 mt-3">
        <a href="{{ route('entries.show', $entry) }}" class="text-xs text-blue-600 hover:text-blue-800">
            Read
        </a>
        @can('update', $entry)
            <a href="{{ route('entries.edit', $entry) }}" class="text-xs text-amber-500 hover:text-amber-700">
                Edit
            </a>
        @endcan
        @can('delete', $entry)
            <form method="POST" action="{{ route('entries.destroy', $entry) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this entry?')"
                    class="text-xs text-red-600 hover:text-red-800 bg-transparent border-0 cursor-pointer p-0">
                    Delete
                </button>
            </form>
        @endcan
    </div>

</div>
