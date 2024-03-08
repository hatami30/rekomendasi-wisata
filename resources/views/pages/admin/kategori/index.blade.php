@extends('pages.admin.components.main')

@section('heading')
    <h3>Data Kategori</h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Data Kategori
                </h5>
                <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
            </div>

            <div class="card-body table-responsive">
                <table id="kategoriTable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>{{ $kategori->slug }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                        class="btn icon btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.kategori.delete', $kategori->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn icon btn-secondary btn-sm"
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
            new DataTable('#kategoriTable');
        });
    </script>
@endsection
