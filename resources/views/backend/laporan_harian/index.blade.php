@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Harian</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Layout</a></li>
                    <li class="breadcrumb-item active">Laporan Harian</li>
                    </ol> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('harian.filter') }}" method="GET">
                        <div class="row pb-3">
                            <div class="col-md-3">
                                <label for="startDate">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="endDate">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" style="margin-top:30px">Filter</button>
                                <a href="{{ route('harian.index') }}" class="btn btn-danger" style="margin-top:30px">Reset</a>
                            </div>

                        </div>
                    </form>
                    <div class="card">
                        <div class="card-header">
                            {{-- <h3 class="card-title"> </h3> --}}
                            <div class="card-tools">
                                <a href="{{ route('harian.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pedagang</th>
                                        <th>Kios</th>
                                        <th>Blok</th>
                                        <th>Nomor</th>
                                        <th>Bayar</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Input</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datalaporan as $key => $laporan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $laporan->Pedagang->pedagang }}</td>
                                        <td>{{ $laporan->Pedagang->Layanan->layanan }}</td>
                                        <td>{{ $laporan->Pedagang->blok }}</td>
                                        <td>{{ $laporan->Pedagang->nomor }}</td>
                                        <td><span class="btn btn-sm btn-{{ $laporan->bayar == 'Ya' ? 'success' : 'danger' }}">{{ $laporan->bayar }}</span>
                                        </td>
                                        <td>{{ $laporan->keterangan }}</td>
                                        <td>{{ $laporan->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('harian.edit', $laporan->id) }}" class="btn btn-sm btn-primary rounded-2 me-1"><i class="fas fa-edit"></i></a>

                                            <a href="{{ route('harian.lihat', $laporan->id) }}" class="btn btn-sm btn-success rounded-2 me-1"><i class="fas fa-eye"></i></a>

                                            <a class="btn btn-sm btn-danger rounded-2 proses-delete {{ auth()->user()->role == 'Petugas' ? 'd-none' : '' }}" href="javascript:void(0);" data-id="{{ $laporan->id }}" data-status="{{ $laporan->status }}"><i class="fas fa-trash"></i></a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('.proses-delete').on('click', function(event) {
            // alert('tes');
            event.preventDefault();
            var id = $(this).data('id');
            console.log(id);
            var currentStatus = $(this).data('status');
            console.log(currentStatus);
            var newStatus = currentStatus === 0 ? 1 : 0;
            console.log(newStatus);
            var url = "{{ route('harian.updateStatus', ['id' => ':id', 'status' => ':status']) }}";
            url = url.replace(':id', id).replace(':status', newStatus);

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Apakah anda yakin untuk menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with form submission
                    $('<form>', {
                        "method": "POST",
                        "action": url
                    }).append($('<input>', {
                        "type": "hidden",
                        "name": "_token",
                        "value": "{{ csrf_token() }}"
                    })).appendTo('body').submit();
                }
            });
        });
    </script>
</div>
@endsection