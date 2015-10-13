<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <!-- Latest compiled and minified CSS & JS -->
        <link rel="stylesheet" media="screen" href="{{ asset('frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Aller">
        <script src="{{ asset('frontend/js/jquery.js') }}"></script>
        <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/js/bootstrap-datepicker.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/animations.css') }}">
        @yield('css')
    </head>
    <body>
        @include('frontend.partials.header')
        @include('frontend.partials.navbar')
        @include('frontend.partials.slider')
        <div id="content" class="container animatedParent">
            @yield('content')
        </div>

        @include('frontend.partials.footer')

    </body>
    @yield('js')
</html>
