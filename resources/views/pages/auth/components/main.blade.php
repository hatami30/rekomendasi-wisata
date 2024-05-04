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
    @yield('content')

    @include('includes.script')

    @yield('script')
</body>

</html>
