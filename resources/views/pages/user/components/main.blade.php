<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wisata Bawean - @yield('title')</title>
    @include('layouts.app')
</head>

<body>
    @include('pages.user.components.header')

    <main>
        @yield('content')
    </main>

    @include('pages.user.components.footer')

    @include('includes.script')
    <script>
        $(document).ready(function() {
            $(".navbar-toggler").on("click", function() {
                $(".navbar-collapse").slideToggle();
            });
        });
    </script>
    @yield('script')
</body>

</html>
