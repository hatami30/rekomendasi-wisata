@extends('pages.admin.components.main')

@section('title', 'Perizinan Komentar')

@section('heading')
    <h3>Perizinan Komentar</h3>
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Komentar yang Perlu Disetujui</h5>
            </div>
            <div class="card-body table-responsive">
                @if (session('success_komentar'))
                    <div class="alert alert-success mt-2">
                        {{ session('success_komentar') }}
                    </div>
                @endif
                @if ($komentars->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Wisata</th>
                                <th>Komentar</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($komentars as $index => $komentar)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $komentar->user->name }}</td>
                                    <td>{{ $komentar->wisata->nama_wisata }}</td>
                                    <td>{{ $komentar->comment }}</td>
                                    <td>{{ ucfirst($komentar->status) }}</td>
                                    <td>
                                        <form action="{{ route('admin.perizinan.update.komentar', $komentar->id) }}"
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
                    <p>Tidak ada komentar yang perlu disetujui saat ini.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
