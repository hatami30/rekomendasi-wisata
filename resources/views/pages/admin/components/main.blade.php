<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>
    @include('layouts.app')
</head>

<body>
    <div id="app">
        @include('pages.admin.components.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                @yield('heading')
            </div>

            <div class="page-content">
                @yield('content')
            </div>

            @include('pages.admin.components.footer')
        </div>
    </div>

    @include('includes.script')
    @yield('script')

</body>

</html>
