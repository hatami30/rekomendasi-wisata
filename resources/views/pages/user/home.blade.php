@extends('pages.user.components.main')

@section('content')
    <!-- hero section -->
    <section class="jumbotron jumbotron-fluid">
        <div class="home d-flex align-items-center">
            <div class="container">
                <div class="home-text">
                    <h1>Selamat datang di Pulau Bawean</h1>
                </div>
                <div class="cta-home text-center">
                    <a class='btn btn-primary shadow-none d-block d-md-inline-block' href='{{ url('/login') }}'>Memulai
                        &nbsp; <i data-feather="arrow-right"></i></a>
                    <a class='btn btn-secondary shadow-none d-block d-md-inline-block' href='{{ url('/about') }}'>Tentang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- jumlah card section -->
    <section class="card-count container nt5">
        <div class="card mb-4 text-center">
            <div class="row justify-content-center">

                <div class="col-lg-3 col-md-6">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h3 class="mb-0">{{ $totalWisatas }}</h3>
                        <div class="d-flex justify-content-center align-items-center mt-2">
                            <p class="mb-0">Total Wisata</p>
                            <i class='bx bx-registered ml-2'></i>
                        </div>
                    </div>
                </div>

                @foreach ($wisatas as $wisata)
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card-body d-flex flex-column align-items-center">
                            <h3 class="mb-0">{{ $wisata->jumlah }}</h3>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <p class="mb-0">Wisata {{ $wisata->kategori }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- video section -->
    <section class="text-center" style="margin-top: 100px">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe width="900" height ="520" class="embed-responsive-item rounded-3"
                src="https://www.youtube.com/embed/I7GgQAa5Lq4?si=wpCjLv6AxDGYEXox" allowfullscreen></iframe>
        </div>
    </section>

    <!-- list wisata section -->
    <section class="container wisata">
        <div class="header-section text-center">
            <h3>Wisata Populer</h3>
        </div>
        <div class="row-container">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card">
                            <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                    Some quick example text.
                                </p>
                                <a href="#" class="btn btn-primary">Detail <i data-feather="arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                    Some quick example text.
                                </p>
                                <a href="#" class="btn btn-primary">Detail <i data-feather="arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                    Some quick example text.
                                </p>
                                <a href="#" class="btn btn-primary">Detail <i data-feather="arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                    Some quick example text.
                                </p>
                                <a href="#" class="btn btn-primary">Detail <i data-feather="arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card">
                            <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">
                                    Some quick example text.
                                </p>
                                <a href="#" class="btn btn-primary">Detail <i data-feather="arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- maps section -->
    <section class="text-center">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item rounded-3"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127022.04822709865!2d112.57308349361179!3d-5.793498174247495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2ddf5782884529d1%3A0x52621acdfb67b026!2sPulau%20Bawean!5e0!3m2!1sid!2sid!4v1709549448740!5m2!1sid!2sid"
                width="900" height="520" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
@endsection
