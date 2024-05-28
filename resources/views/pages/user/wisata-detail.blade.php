@extends('pages.user.components.main')

@section('title', $wisata->nama_wisata)

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
                        @foreach ($images as $image)
                            <div class="swiper-slide">
                                <div class="card">
                                    <img src="{{ asset('storage/user/wisata_photos/' . $image->image_path) }}"
                                        class="card-img-top" alt="Image">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-8">
                    <h2 class="mb-4 fw-normal">{{ $wisata->nama_wisata }}</h2>
                    <p class="fs-6 lead" style="max-width: 700px; text-align: justify;">
                        <span style="font-weight: 600;">Deskripsi wisata:</span> {{ $wisata->desk_wisata }}
                    </p>
                    <p class="fs-6 lead" style="max-width: 700px; text-align: justify;">
                        <span style="font-weight: 600;">Fasilitas:</span> {{ $wisata->fasilitas }}
                    </p>
                    <div class="mb-3" id="ratingContainer">
                        <div id="rating" data-rating="{{ $averageRating }}"></div>
                        <span id="ratingText">{{ number_format($averageRating, 1) }}</span>
                    </div>
                    <div class="dropdown" style="position: relative;">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Rating
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="ratingDropdown"
                            style="position: absolute; max-height: 80px; overflow-y: auto; z-index: 1000;">
                            <form action="{{ route('perhitungan.store') }}" method="post">
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
                                <input type="hidden" name="average" id="inputAverage">
                                <button type="submit" class="btn btn-primary mt-2">Simpan Rating</button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5 class="mb-3">Komentar</h5>
                        <form action="{{ route('komentar.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                            <input type="hidden" name="id_wisata" value="{{ $wisata->id }}">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Tulis komentar Anda di sini" required></textarea>
                            </div>
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                        </form>
                    </div>
                    @if ($komentars->isNotEmpty())
                        <div class="mt-4">
                            <h6>Komentar Pengguna</h6>
                            <ul class="list-group">
                                @foreach ($komentars as $komentar)
                                    <li class="list-group-item">
                                        <div class="mb-2">
                                            <strong>{{ $komentar->user->name }}</strong> -
                                            {{ $komentar->created_at->diffForHumans() }}
                                        </div>
                                        <p>{{ $komentar->comment }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Unggah Gambar</h5>
                            <p class="card-text">Unggah gambar untuk menambahkan foto-foto wisata.</p>
                            <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="text-center mt-3">
                                    <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                                    <input type="hidden" name="id_wisata" value="{{ $wisata->id }}">
                                    <input type="file" name="images[]" id="images" multiple accept="image/*">
                                    <input type="hidden" name="status" value="pending">
                                    @error('images')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Lokasi</h5>
                            <p class="card-text">{{ $wisata->lokasi_wisata }}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $wisata->latitude }},{{ $wisata->longitude }}"
                                target="_blank" class="btn btn-primary">Lihat Lokasi
                                <i class="bi bi-geo-fill"></i>
                            </a>
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
                        @if ($predictions && $predictions->isNotEmpty())
                            @foreach ($predictions as $prediction)
                                <div class="swiper-slide">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $prediction->wisata->gambar_wisata) }}"
                                            class="card-img-top img-fluid"
                                            style="object-fit: cover; width: 100%; height: 200px;"
                                            alt="{{ $prediction->wisata->nama_wisata }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $prediction->wisata->nama_wisata }}</h5>
                                            <div class="d-flex flex-column mb-5">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-star-fill text-warning me-1 mt-1"
                                                        style="font-size: 1rem;"></i>
                                                    <div class="me-1 mt-3">
                                                        {{ number_format($prediction->wisata->rating->avg('average'), 1) }}
                                                    </div>
                                                </div>
                                                <div class="card-text d-inline-block py-2 px-4 rounded-pill mt-4"
                                                    style="background-color: #e6e6e6; width: fit-content;">
                                                    {{ $prediction->wisata->kategori->nama_kategori }}
                                                </div>
                                            </div>
                                            <a href="{{ route('wisata.detail', ['id' => $prediction->wisata->id]) }}"
                                                class="btn btn-primary">Detail <i data-feather="arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Tidak ada rekomendasi yang tersedia</p>
                        @endif
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="text-center mb-4">
                    <p>Mean Absolute Error (MAE): {{ $mae }}</p>
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

            $(document).ready(function() {
                var averageRating = $('#rating').data('rating');

                $("#rating").rateYo({
                    rating: averageRating,
                    readOnly: true
                });
            });
        });
    </script>
@endsection
