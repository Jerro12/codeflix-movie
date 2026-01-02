<x-mail::message>
# Welcome, {{ $user->name }}!

Thank you for joining **Codeflix**. We're excited to have you on board.

Get ready to explore our vast library of movies and series.

<x-mail::button :url="route('home')">
Start Watching
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
