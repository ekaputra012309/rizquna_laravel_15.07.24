@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
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
                            <h3 class="card-title"> </h3>
                            <div class="card-tools">
                                <a href="{{ route('booking.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pemesanan</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th>Agen</th>
                                        <th>Total Diskon</th>
                                        <th>Total Subtotal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($databooking as $booking)
                                    <tr>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('booking.edit', $booking->id_booking) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="{{ route('booking.destroy', $booking->id_booking) }}" data-confirm-delete="true">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                        <td>{{ $booking->booking_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->tgl_booking)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $booking->agent->nama_agent }}</td>
                                        <td>{{ $booking->total_discount }}</td>
                                        <td>{{ $booking->total_subtotal }}</td>
                                        @php
                                        $statusClasses = [
                                        'Piutang' => 'btn btn-danger btn-sm',
                                        'DP' => 'btn btn-warning btn-sm',
                                        'Lunas' => 'btn btn-success btn-sm'
                                        ];
                                        $statusClass = $statusClasses[$booking->status] ?? 'btn btn-secondary btn-sm';
                                        @endphp

                                        <td>
                                            <span class="{{ $statusClass }}">{{ $booking->status }}</span>
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
    </script>
</div>
@endsection