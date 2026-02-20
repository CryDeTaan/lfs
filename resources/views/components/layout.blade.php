@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
            {{ $title ? $title.' - ' : '' }}{{ config('app.name', 'Laravel') }}
        </title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="min-h-screen bg-gradient-to-br from-violet-600 via-purple-500 to-indigo-600 text-white antialiased"
    >
        {{ $slot }}
    </body>
</html>
