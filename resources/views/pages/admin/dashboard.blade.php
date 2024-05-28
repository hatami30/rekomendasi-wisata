@extends('pages.admin.components.main')

@section('title', 'Home')

@section('heading')
    <h3>Dashboard</h3>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon purple me-3">
                                    <i class="iconly-boldHome"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted font-semibold">Total Wisata</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalWisatas }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($wisatas as $wisata)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon blue me-3">
                                        <i class="iconly-boldLocation"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted font-semibold">Wisata {{ $wisata->kategori }}</h6>
                                        <h6 class="font-extrabold mb-0">{{ $wisata->jumlah }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4>Ranking Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('./assets/compiled/jpg/1.jpg') }}" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">Pengelola</h5>
                            <h6 class="text-muted mb-0">{{ Auth::user()->name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
