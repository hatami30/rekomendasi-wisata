@extends('pages.admin.components.main')

@section('title', 'Kategori')

@section('heading')
    <h3>Data Perhitungan</h3>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Data Similarity
                        <a href="{{ route('admin.perhitungan.export.similarity.csv') }}" class="btn btn-primary btn-sm">Export
                            CSV</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Wisata 1</th>
                                        <th>Wisata 2</th>
                                        <th>Similarity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($similarities as $similarity)
                                        <tr>
                                            <td>{{ $similarity->id }}</td>
                                            <td>{{ $similarity->id_wisata1 }}</td>
                                            <td>{{ $similarity->id_wisata2 }}</td>
                                            <td>{{ $similarity->similarity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Data Prediksi
                        <a href="{{ route('admin.perhitungan.export.prediction.csv') }}"
                            class="btn btn-primary btn-sm">Export CSV</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User ID</th>
                                        <th>Wisata ID</th>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($predictions as $prediction)
                                        <tr>
                                            <td>{{ $prediction->id }}</td>
                                            <td>{{ $prediction->id_user }}</td>
                                            <td>{{ $prediction->id_wisata }}</td>
                                            <td>{{ $prediction->predicted }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#table1').DataTable();
            $('#table2').DataTable();
        });
    </script>
@endsection
