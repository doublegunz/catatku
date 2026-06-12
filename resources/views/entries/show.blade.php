<x-layout>
    <div style="max-width: 700px; margin: 0 auto;">

        @if($entry->cover_image)
            <img src="{{ asset('storage/' . $entry->cover_image) }}"
                 alt="{{ $entry->title }}"
                 style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px; margin-bottom: 16px;">
        @endif

        {{-- Entry content --}}
        <h1 style="font-size: 1.5em; color: #1e293b; margin-bottom: 8px;">{{ $entry->title }}</h1>
        <p style="color: #888; font-size: 0.85em; margin-bottom: 16px;">
            Written {{ $entry->created_at->diffForHumans() }}
        </p>
        <div style="line-height: 1.7; color: #333; margin-bottom: 30px;">
            {{ $entry->content }}
        </div>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

        {{-- Comments section --}}
        <h2 style="font-size: 1.2em; color: #1e293b; margin-bottom: 16px;">
            Comments ({{ $entry->comments->count() }})
        </h2>

        @forelse ($entry->comments as $comment)
            <div style="padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <strong style="color: #1e293b;">{{ $comment->user->name }}</strong>
                    <span style="color: #9ca3af; font-size: 0.8em;">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p style="color: #4b5563; margin: 0;">{{ $comment->body }}</p>
            </div>
        @empty
            <p style="color: #9ca3af; text-align: center; padding: 20px 0;">
                No comments yet. Be the first to comment!
            </p>
        @endforelse

        {{-- Comment form --}}
        <div style="margin-top: 20px; background: #f9fafb; padding: 16px; border-radius: 8px;">
            <h3 style="font-size: 1em; margin-bottom: 10px; color: #1e293b;">Write a Comment</h3>

            <form method="POST" action="{{ route('comments.store', $entry) }}">
                @csrf

                <textarea
                    name="body"
                    rows="3"
                    placeholder="Write your comment..."
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; resize: vertical; box-sizing: border-box; font-family: inherit;"
                >{{ old('body') }}</textarea>

                @error('body')
                    <p style="color: #dc2626; font-size: 0.85em; margin: 4px 0 0;">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    style="margin-top: 10px; background: #2563eb; color: white; padding: 8px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;"
                >
                    Post Comment
                </button>
            </form>
        </div>

        <a href="{{ route('entries.index') }}" style="display: inline-block; margin-top: 20px; color: #2563eb; text-decoration: none;">
            &larr; Back to entries
        </a>
    </div>
</x-layout>
