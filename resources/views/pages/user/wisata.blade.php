@extends('pages.user.components.main')

@section('title', 'Wisata')

@include('pages.user.components.category')

@section('content')
    <section class="rekomendasi">
        <div class="header-section text-center">
            <h3>Rekomendasi Wisata</h3>
        </div>
        <div class="container my-4">
            <div class="row">
                @foreach ($wisatas as $wisata)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $wisata->gambar_wisata) }}" class="card-img-top img-fluid"
                                style="object-fit: cover; width: 100%; height: 200px;" alt="{{ $wisata->nama_wisata }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $wisata->nama_wisata }}</h5>
                                @php
                                    $averageRating = $wisata->rating()->avg('average');
                                @endphp
                                <div class="d-flex flex-column mb-5">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-star-fill text-warning me-1 mt-3" style="font-size: 1rem;"></i>
                                        <div class="me-1 mt-3">{{ number_format($averageRating, 1) }}</div>
                                    </div>
                                    <div class="card-text d-inline-block py-2 px-4 rounded-pill mt-4"
                                        style="background-color: #e6e6e6; width: fit-content;">
                                        {{ $wisata->kategori->nama_kategori }}</div>
                                </div>
                                <a href="{{ route('wisata.detail', $wisata->id) }}" class="btn btn-primary">Detail <i
                                        data-feather="arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-center">
                    <nav aria-label="Pagination Navigation">
                        <ul class="pagination">
                            @if ($wisatas->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                    <span class="page-link" aria-hidden="true">&lsaquo; Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $wisatas->previousPageUrl() }}" rel="prev"
                                        aria-label="@lang('pagination.previous')">&lsaquo; Previous</a>
                                </li>
                            @endif

                            @if ($wisatas->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $wisatas->nextPageUrl() }}" rel="next"
                                        aria-label="@lang('pagination.next')">Next &rsaquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                    <span class="page-link" aria-hidden="true">Next &rsaquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-center">
                    <p>Page {{ $wisatas->currentPage() }} of {{ $wisatas->lastPage() }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
