<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <!-- Load CSS -->
    @vite(['resources/css/app.css'])
    @filamentStyles
</head>
<body class="font-sans antialiased bg-gray-100">
<!-- Slot konten dari halaman -->
{{ $slot }}

<!-- Load JS -->
@vite(['resources/js/app.js'])
@filamentScripts

@stack('scripts')
</body>
</html>
