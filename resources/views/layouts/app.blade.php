<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="version" content="{{config('app.version')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.display_name', 'Модуль') . ' v' . config('app.version') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

</head>
<body>
<div id="app">
    <app/>
</div>
</body>

</html>
