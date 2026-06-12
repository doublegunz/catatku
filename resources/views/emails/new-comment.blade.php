<x-mail::message>
# New Comment on "{{ $entry->title }}"

**{{ $comment->user->name }}** commented on your journal entry:

<x-mail::panel>
{{ $comment->body }}
</x-mail::panel>

<x-mail::button :url="route('entries.show', $entry)">
View Entry
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
