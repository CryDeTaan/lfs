@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
            {{ $title ? $title.' - ' : '' }}{{ config('app.name', 'Laravel') }}
        </title>
    </head>
    <body>
        <nav
            class="navbar navbar-expand-lg navbar-light bg-light mb-5 flex flex-col justify-between pt-3 sm:flex-row"
        >
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('contact') }}">Contact Us</a>
            <a href="{{ route('tasks') }}">Tasks</a>
        </nav>
        {{ $slot }}
    </body>
</html>
