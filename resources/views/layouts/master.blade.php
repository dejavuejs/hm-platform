<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @yield('head')

    @yield('seo')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div id="app" class="container">
        @yield('body')
    </div>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    @stack('js')
</body>
</html>