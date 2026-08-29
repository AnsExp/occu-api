<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ public_path('css/document.css') }}" />
    <title>@yield('title', config('app.name', 'Laravel'))</title>
</head>

<body>
    @yield('content')
    {{-- Sign section --}}
    <p style="display: none;">{{ bin2hex(random_bytes(16)) }}</p>
    <p style="display: none;">{{ time() }}</p>
</body>

</html>