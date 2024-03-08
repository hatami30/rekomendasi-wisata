@extends('pages.admin.components.main')

@section('heading')
    <h3>
        @isset($kategori)
            Edit Kategori
        @else
            Tambah Kategori
        @endisset
    </h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @isset($kategori)
                        Edit Kategori
                    @else
                        Tambah Kategori
                    @endisset
                </h3>
            </div>

            <div class="card-body">
                <form
                    action="{{ isset($kategori) ? route('admin.kategori.update', $kategori->id) : route('admin.kategori.store') }}"
                    method="POST">
                    @csrf
                    @isset($kategori)
                        @method('PUT')
                    @endisset

                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                            value="{{ isset($kategori) ? $kategori->nama_kategori : old('nama_kategori') }}" required>
                        @error('nama_kategori')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                    <button type="submit" class="btn btn-sm btn-secondary">
                        @isset($kategori)
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
