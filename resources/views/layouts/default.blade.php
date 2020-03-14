<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 CRUD Example</title>
    @include('layouts.include.css')
    @stack('css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
    @include('layouts.include.js')
    @stack('js')

</body>

</html>