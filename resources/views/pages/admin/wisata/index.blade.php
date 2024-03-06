@extends('pages.admin.components.main')

@section('heading')
    <h3>Data Wisata</h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.wisata.create') }}" class="btn btn-primary float-end">Tambah Wisata</a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="wisataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Wisata</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wisatas as $wisata)
                            <tr>
                                <td>{{ $wisata->id }}</td>
                                <td>{{ $wisata->nama_wisata }}</td>
                                <td>{{ $wisata->lokasi_wisata }}</td>
                                <td>{{ $wisata->desk_wisata }}</td>
                                <td>{{ $wisata->gambar_wisata }}</td>
                                <td>
                                    <a href="{{ route('admin.wisata.edit', $wisata->id ) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.wisata.delete', $wisata->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
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
            $('#wisataTable').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "paging": true,
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 10
            });
        });
    </script>
@endsection
