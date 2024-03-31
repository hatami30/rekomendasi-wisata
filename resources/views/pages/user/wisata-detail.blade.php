@extends('pages.user.components.main')

@section('content')
    <section class="wisata-detail">
        <div class="container">
            <div class="image-container text-center">
                <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" alt="Gambar" class="img-fluid rounded mx-auto d-block">
            </div>
            <div class="row mt-4">
                <div class="col-lg-8">
                    <h2>Nama Wisata</h2>
                    <p class="lead">Deskripsi wisata akan ditampilkan di sini. Anda dapat menambahkan deskripsi wisata
                        sesuai kebutuhan.</p>
                    <div id="ratingHarga"></div>
                    <div id="ratingFasilitas"></div>
                    <div id="ratingKeamanan"></div>
                    <div id="ratingKenyamanan"></div>
                    <div id="ratingKebersihan"></div>
                    <div id="ratingKeindahan"></div>
                    <div id="ratingPelayanan"></div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Lokasi</h5>
                            <p class="card-text">Lokasi wisata akan ditampilkan di sini.</p>
                            <a href="#" class="btn btn-primary">Lihat Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container mt-4">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card">
                                <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card">
                                <img src="https://i.ibb.co/gSDP1Cp/noko-selayar.jpg" class="card-img-top" alt="Image 1">
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(function() {
            $("#ratingHarga").rateYo({
                rating: 0,
                fullStar: true
            });

            $("#ratingFasilitas").rateYo({
                rating: 0,
                fullStar: true
            });

            $("#ratingKeamanan").rateYo({
                rating: 0,
                fullStar: true
            });

            $("#ratingKenyamanan").rateYo({
                rating: 0,
                fullStar: true
            });

            $("#ratingKebersihan").rateYo({
                rating: 0,
                fullStar: true
            });

            $("#ratingKeindahan").rateYo({
                rating: 0,
                fullStar: true
            });

            $("#ratingPelayanan").rateYo({
                rating: 0,
                fullStar: true
            });
        });
    </script>
@endsection
