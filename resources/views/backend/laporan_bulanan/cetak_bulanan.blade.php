@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Bulanan</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Layout</a></li>
                    <li class="breadcrumb-item active">Cetak Laporan Bulanan</li>
                    </ol> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title"> Cetak Laporan Bulanan </h2>
                            <div class="card-tools">
                                {{-- <a href="{{ route('harian.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Data
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('bulanan.cetak') }}" method="GET">
                                <div class="row pb-3">
                                    <div class="col-md-5">
                                        <label for="startDate">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="endDate">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-block btn-info" style="margin-top:30px">Cetak Laporan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <script>
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        </script> --}}
</div>
@endsection