<div style="border: 1px solid #e5e7eb; padding: 16px; margin-bottom: 12px; border-radius: 8px;">
    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 8px;">
        <a href="{{ route('entries.show', $entry) }}"
           style="color: #1e293b; text-decoration: none; font-weight: 600; line-height: 1.4;">
            {{ $truncatedTitle() }}
        </a>
        <span style="font-size: 0.75em; color: #9ca3af; white-space: nowrap; margin-top: 2px;">
            {{ $entry->created_at->format('d M Y') }}
        </span>
    </div>

    <p style="color: #6b7280; margin: 0 0 8px; font-size: 0.9em; line-height: 1.5;">
        {{ $entry->excerpt }}
    </p>

    <span style="color: #9ca3af; font-size: 0.8em;">
        {{ $entry->reading_time }} min read
    </span>

    @if($entry->tags->isNotEmpty())
        <div style="margin-top: 8px;">
            @foreach($entry->tags as $tag)
                <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 12px; font-size: 0.75em;">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    @endif

    <div style="display: flex; align-items: center; gap: 12px; padding-top: 12px; border-top: 1px solid #f3f4f6; margin-top: 12px;">
        <a href="{{ route('entries.show', $entry) }}" style="font-size: 0.75em; color: #2563eb;">
            Read
        </a>
        @can('update', $entry)
            <a href="{{ route('entries.edit', $entry) }}" style="font-size: 0.75em; color: #d97706; text-decoration: none;">
                Edit
            </a>
        @endcan
        @can('delete', $entry)
            <form method="POST" action="{{ route('entries.destroy', $entry) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this entry?')"
                    style="font-size: 0.75em; color: #dc2626; background: none; border: none; cursor: pointer; padding: 0;">
                    Delete
                </button>
            </form>
        @endcan
    </div>
</div>
