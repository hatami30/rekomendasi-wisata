@extends('pages.admin.components.main')

@section('title', 'Perizinan Image')

@section('heading')
    <h3>Perizinan Image</h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Image yang Perlu Disetujui</h5>
            </div>
            <div class="card-body table-responsive">
                @if (session('success_image'))
                    <div class="alert alert-success mt-2">
                        {{ session('success_image') }}
                    </div>
                @endif
                @if ($fotoPending->count() > 0)
                    <table id="imageTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Wisata</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fotoPending as $index => $foto)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $foto->user->name }}</td>
                                    <td>{{ $foto->wisata->nama_wisata }}</td>
                                    <td>
                                        <img src="{{ asset('storage/user/wisata_photos/' . $foto->image_path) }}"
                                            alt="{{ $foto->image_path }}" style="max-height: 100px;">
                                    </td>
                                    <td>{{ ucfirst($foto->status) }}</td>
                                    <td>
                                        <form action="{{ route('admin.perizinan.update.image', $foto->id) }}"
                                            method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success" name="status"
                                                    value="approved">Setujui</button>
                                                <button type="submit" class="btn btn-danger" name="status"
                                                    value="rejected">Tolak</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada image yang perlu disetujui saat ini.</p>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            new DataTable('#imageTable');
        });
    </script>
@endsection
