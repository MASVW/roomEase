<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="{{ asset('/favicon.png') }}" type="image/png">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Room Ease' }}</title>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @vite('resources/css/app.css')
        @filamentStyles
    </head>
    <body>
{{--        <livewire:nav-component />--}}
        @include('navigation-menu')
        {{ $slot }}
        <livewire:footer-component />
        <livewire:notifications />
        @stack('scripts')
        @vite('resources/js/app.js')
        @filamentScripts
    </body>
</html>
