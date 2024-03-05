<header>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class='navbar-brand' href='/'>
                <div class="logo">
                    <a href="{{ url('/') }}" id="logo">Wisata Bawean</a>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 96 960 960" width="32">
                    <path
                        d="M190 546q-12.75 0-21.375-8.675-8.625-8.676-8.625-21.5 0-12.825 8.625-21.325T190 486h580q12.75 0 21.375 8.675 8.625 8.676 8.625 21.5 0 12.825-8.625 21.325T770 546H190Zm0 120q-12.75 0-21.375-8.675-8.625-8.676-8.625-21.5 0-12.825 8.625-21.325T190 606h580q12.75 0 21.375 8.675 8.625 8.676 8.625 21.5 0 12.825-8.625 21.325T770 666H190Z" />
                </svg>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class='nav-link' href='{{ url('/') }}'>Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class='nav-link' href='{{ url('/') }}'>Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class='nav-link' href='{{ url('/') }}'>Rekomendasi</a>
                    </li>
                </ul>
                <div class="ml-auto">
                    <a class='btn btn-primary d-block d-md-inline-block shadow-none' href='{{ url('/login') }}'>Memulai</a>
                </div>
            </div>
        </div>
    </nav>
    </header>