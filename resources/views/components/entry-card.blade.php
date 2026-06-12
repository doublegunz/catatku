@props(['entry'])

<div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-gray-300 transition-colors">

    {{-- Header: title and date --}}
    <div class="flex items-start justify-between gap-3 mb-3">
        <a href="/entries/{{ $entry->id }}"
           class="font-semibold text-gray-900 hover:text-gray-600 leading-snug">
            {{ $entry->title }}
        </a>
        <span class="text-xs text-gray-400 whitespace-nowrap mt-0.5">
            {{ $entry->created_at->format('d M Y') }}
        </span>
    </div>

    {{-- Content snippet --}}
    <p class="text-sm text-gray-500 line-clamp-2 mb-2">
        {{ $entry->excerpt }}
    </p>
    <span style="color: #9ca3af; font-size: 0.8em;">
        {{ $entry->reading_time }} min read · {{ $entry->created_at_human }}
    </span>

    {{-- Tags --}}
    @if($entry->tags->isNotEmpty())
        <div style="margin-top: 8px; display: flex; flex-wrap: wrap; gap: 4px;">
            @foreach ($entry->tags as $tag)
                <span style="background: #dbeafe; color: #1e40af; padding: 2px 10px; border-radius: 12px; font-size: 0.75em; font-weight: 600;">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    @endif

    {{-- Action buttons --}}
    <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
        <a href="/entries/{{ $entry->id }}"
           class="text-xs text-blue-600 hover:text-blue-800">
            Read
        </a>
        <a href="/entries/{{ $entry->id }}/edit"
           class="text-xs text-gray-500 hover:text-gray-800">
            Edit
        </a>
        <form method="POST" action="/entries/{{ $entry->id }}"
              onsubmit="return confirm('Delete this entry?')"
              class="ml-auto">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs text-red-400 hover:text-red-600">
                Delete
            </button>
        </form>
    </div>

</div>
