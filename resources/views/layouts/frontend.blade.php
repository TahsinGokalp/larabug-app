<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/frontend.css') }}">
    @include('frontend.partials.meta')
</head>
<body class="flex flex-col w-full min-h-screen font-sans antialiased text-gray-900">
<main class="flex-grow">
    @yield('content')
</main>
<script src="{{ mix('js/frontend.js') }}"></script>
@stack('scripts')
</body>
</html>
