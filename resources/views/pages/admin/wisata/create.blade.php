@extends('pages.admin.components.main')

@section('heading')
    <h3>Tambah Wisata</h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Tambah Wisata
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_wisata" class="form-label">Nama Wisata</label>
                        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi_wisata" class="form-label">Lokasi Wisata</label>
                        <input type="text" class="form-control" id="lokasi_wisata" name="lokasi_wisata" required>
                    </div>
                    <div class="mb-3">
                        <label for="desk_wisata" class="form-label">Deskripsi Wisata</label>
                        <textarea class="form-control" id="desk_wisata" name="desk_wisata" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="id_kategori" name="id_kategori" required>
                            <option value="" selected disabled>Pilih kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_wisata" class="form-label">Gambar Wisata</label>
                        <input type="file" class="form-control" id="gambar_wisata" name="gambar_wisata" accept="image/*"
                            required>
                    </div>
                    <a href="{{ route('admin.wisata.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    <button type="submit" class="btn btn-sm btn-secondary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
@endsection
