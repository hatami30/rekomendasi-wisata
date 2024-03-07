@extends('pages.admin.components.main')

@section('heading')
    <h3>Data Wisata</h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Data Wisata
                </h5>
                <a href="{{ route('admin.wisata.create') }}" class="btn btn-primary btn-sm">Tambah Wisata</a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" id="wisataTable" data-toggle="dataTable">
                    <thead>
                        <tr>
                            <th>Nama Wisata</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wisatas as $wisata)
                            <tr>
                                <td class="text-nowrap">{{ $wisata->nama_wisata }}</td>
                                <td>{{ $wisata->lokasi_wisata }}</td>
                                <td>{{ $wisata->desk_wisata }}</td>
                                <td>{{ $wisata->kategori->nama_kategori }}</td>
                                <td class="w-auto">
                                    <img src="{{ asset('storage/' . $wisata->gambar_wisata) }}"
                                        alt="Foto {{ $wisata->nama_wisata }}" class="img-fluid rounded w-50 h-auto">
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.wisata.edit', $wisata->id) }}"
                                        class="btn icon btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.wisata.delete', $wisata->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            new DataTable('#wisataTable');
        });
    </script>
@endsection