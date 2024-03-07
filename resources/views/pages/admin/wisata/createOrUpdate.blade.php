@extends('pages.admin.components.main')

@section('heading')
    <h3>
        @isset($wisata)
            Edit Wisata
        @else
            Tambah Wisata
        @endisset
    </h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    @isset($wisata)
                        Edit Wisata
                    @else
                        Tambah Wisata
                    @endisset
                </h5>
            </div>

            <div class="card-body">
                @isset($wisata)
                    <form action="{{ route('admin.wisata.update', $wisata->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data">
                        @endisset
                        @csrf
                        <div class="mb-3">
                            <label for="nama_wisata" class="form-label">Nama Wisata</label>
                            <input type="text" class="form-control" id="nama_wisata" name="nama_wisata"
                                value="{{ isset($wisata) ? $wisata->nama_wisata : old('nama_wisata') }}" required
                                placeholder="Masukkan Nama Wisata">
                            @error('nama_wisata')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lokasi_wisata" class="form-label">Lokasi Wisata</label>
                            <input type="text" class="form-control" id="lokasi_wisata" name="lokasi_wisata"
                                value="{{ isset($wisata) ? $wisata->lokasi_wisata : old('lokasi_wisata') }}" required
                                placeholder="Masukkan Lokasi Wisata">
                            @error('lokasi_wisata')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="desk_wisata" class="form-label">Deskripsi Wisata</label>
                            <textarea class="form-control" id="desk_wisata" name="desk_wisata" rows="3" required
                                placeholder="Masukkan Deskripsi Wisata">{{ isset($wisata) ? $wisata->desk_wisata : old('desk_wisata') }}</textarea>
                            @error('desk_wisata')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-select selectpicker" id="id_kategori" name="id_kategori" required
                                data-live-search="true">
                                <option value="" selected disabled>Pilih kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        @isset($wisata) @if ($kategori->id == $wisata->id_kategori) selected @endif @endisset>
                                        {{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gambar_wisata" class="form-label">Gambar Wisata</label>
                            <input type="file" class="form-control" id="gambar_wisata" name="gambar_wisata">
                        </div>
                        <a href="{{ route('admin.wisata.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-secondary">
                            @isset($wisata)
                                Simpan
                            @else
                                Tambah
                            @endisset
                        </button>
                    </form>
            </div>
        </div>
    </section>
@endsection
