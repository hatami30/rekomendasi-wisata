@extends('pages.user.components.main')

@section('content')
    <section class="wisata-detail">
        <div class="container">
            <div class="image-container text-center">
                <img src="{{ asset('storage/' . $wisata->gambar_wisata) }}" alt="Gambar"
                    class="img-fluid rounded mx-auto d-block">
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
            <div class="row mt-4">
                <div class="col-lg-8">
                    <h2 class="mb-4 fw-normal">{{ $wisata->nama_wisata }}</h2>
                    <p class="fs-6 fw-light lead">Deskripsi wisata: {{ $wisata->desk_wisata }}</p>
                    <p>Rata-rata Rating: {{ $averageRating }}</p>
                    <div class="dropdown" style="position: relative;">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Rating
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="ratingDropdown"
                            style="position: absolute; max-height: 70px; overflow-y: auto; z-index: 1000;">
                            <form action="{{ route('user.wisata.rating.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                                <input type="hidden" name="id_wisata" value="{{ $wisata->id }}">
                                <div class="rating-container">
                                    <div id="ratingHarga" class="rating"></div>
                                    <input type="hidden" name="harga" id="inputHarga">
                                    <span class="rating-label">Harga</span>
                                </div>
                                <div class="rating-container">
                                    <div id="ratingFasilitas" class="rating"></div>
                                    <input type="hidden" name="fasilitas" id="inputFasilitas">
                                    <span class="rating-label">Fasilitas</span>
                                </div>
                                <div class="rating-container">
                                    <div id="ratingKeamanan" class="rating"></div>
                                    <input type="hidden" name="keamanan" id="inputKeamanan">
                                    <span class="rating-label">Keamanan</span>
                                </div>
                                <div class="rating-container">
                                    <div id="ratingKenyamanan" class="rating"></div>
                                    <input type="hidden" name="kenyamanan" id="inputKenyamanan">
                                    <span class="rating-label">Kenyamanan</span>
                                </div>
                                <div class="rating-container">
                                    <div id="ratingKebersihan" class="rating"></div>
                                    <input type="hidden" name="kebersihan" id="inputKebersihan">
                                    <span class="rating-label">Kebersihan</span>
                                </div>
                                <div class="rating-container">
                                    <div id="ratingKeindahan" class="rating"></div>
                                    <input type="hidden" name="keindahan" id="inputKeindahan">
                                    <span class="rating-label">Keindahan</span>
                                </div>
                                <div class="rating-container">
                                    <div id="ratingPelayanan" class="rating"></div>
                                    <input type="hidden" name="pelayanan" id="inputPelayanan">
                                    <span class="rating-label">Pelayanan</span>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Simpan Rating</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Lokasi</h5>
                            <p class="card-text">{{ $wisata->lokasi_wisata }}</p>
                            <a href="#" class="btn btn-primary">Lihat Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container mt-5">
                <h3 class="text-center mb-4" style="color: #445434; font-weight: 600">Rekomendasi Lainnya</h3>
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
        $(document).ready(function() {
            initializeRating("#ratingHarga");
            initializeRating("#ratingFasilitas");
            initializeRating("#ratingKeamanan");
            initializeRating("#ratingKenyamanan");
            initializeRating("#ratingKebersihan");
            initializeRating("#ratingKeindahan");
            initializeRating("#ratingPelayanan");

            function initializeRating(elementId) {
                $(elementId).rateYo({
                    rating: 0,
                    fullStar: true,
                    onSet: function(rating, rateYoInstance) {
                        var inputId = $(elementId).attr('id').replace('rating', 'input');
                        $('#' + inputId).val(rating);
                    }
                });
            }

            $('.dropdown-toggle').on('click', function(e) {
                let $el = $(this).next('.dropdown-menu');
                $('.dropdown-menu').not($el).removeClass('show');
                $el.toggleClass('show');
                e.stopPropagation();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });
        });
    </script>
@endsection
