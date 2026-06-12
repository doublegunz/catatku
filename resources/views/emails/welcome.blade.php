<x-mail::message>
# Welcome to Catatku, {{ $user->name }}!

Thank you for joining Catatku. Your personal journal is ready.

Start capturing your thoughts, memories, and ideas. Every entry is private and only visible to you.

<x-mail::button :url="route('entries.create')">
Write Your First Entry
</x-mail::button>

Happy journaling!<br>
{{ config('app.name') }}
</x-mail::message>
