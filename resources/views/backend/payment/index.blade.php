@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Payment Hotel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                        <li class="breadcrumb-item active">Data Payment Hotel</li>
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
                            <!-- <form id="paymentForm" class="form" method="POST" action="#" data-parsley-validate> -->
                            <form action="{{ route('payment.store') }}" method="POST" id="paymentForm">
                                @csrf
                                @auth
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @endauth
                                <h5>Conversion</h5>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="sar_idr" class="form-label">1 SAR IDR</label>
                                            <input type="number" id="sar_idr" name="sar_idr" class="form-control" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="sar_usd" class="form-label">1 SAR USD</label>
                                            <input type="number" id="sar_usd" name="sar_usd" class="form-control" step="0.01" required value="3.74">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="usd_idr" class="form-label">1 USD IDR</label>
                                            <input type="number" id="usd_idr" name="usd_idr" class="form-control" step="0.01" required>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mandatory">
                                            <label for="inv_number" class="form-label">Invoice Number</label>
                                            <div class="input-group">
                                                <input type="hidden" id="id_booking" class="form-control" name="id_booking" required readonly />
                                                <input type="text" id="inv_number" class="form-control" placeholder="Invoice Number" readonly />
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#invoiceModal">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="mata_uang" class="form-label">From</label>
                                            <select id="mata_uang" class="form-control" disabled>
                                                <option value="">Pilih</option>
                                                <option value="SAR">SAR</option>
                                                <option value="USD">USD</option>
                                                <!-- <option value="IDR">IDR</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group mandatory">
                                            <label for="pilih_konversi" class="form-label">To</label>
                                            <select id="pilih_konversi" name="pilih_konversi" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="SAR">SAR</option>
                                                <option value="USD">USD</option>
                                                <option value="IDR">IDR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="subtotal" class="form-label">Sub Total <span id="dari"></span></label>
                                            <input type="hidden" id="subtotal" class="form-control">
                                            <input type="text" id="subtotal1" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="hasil_konversi" class="form-label">Sub Total <span id="hasil"></span></label>
                                            <input type="hidden" id="hasil_konversi" name="hasil_konversi" class="form-control">
                                            <input type="text" id="hasil_konversi1" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Add Payment
                                        </button>
                                        &nbsp;
                                        <button type="reset" class="btn btn-danger me-1 mb-1">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pemesanan</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th>Agen</th>
                                        <th>Total Subtotal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datapayment as $payment)
                                    <tr>
                                        <td>
                                            <a class="btn btn-secondary btn-sm" href="{{ route('payment.show', $payment->id_payment) }}">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                        <td>{{ $payment->booking->booking_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->booking->tgl_booking)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $payment->booking->agent->nama_agent }}</td>
                                        <td>
                                            <span style="float: left;">{{ $payment->pilih_konversi == 'USD' ? '$ ' . $payment->hasil_konversi : $payment->hasil_konversi }}</span>
                                            <span style="float: right;">{{ $payment->pilih_konversi }}</span>
                                        </td>
                                        @php
                                        $statusClasses = [
                                        'Piutang' => 'btn btn-danger btn-sm',
                                        'DP' => 'btn btn-warning btn-sm',
                                        'Lunas' => 'btn btn-success btn-sm'
                                        ];
                                        $statusClass = $statusClasses[$payment->booking->status] ?? 'btn btn-secondary btn-sm';
                                        @endphp

                                        <td>
                                            <span class="{{ $statusClass }}">{{ $payment->booking->status }}</span>
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
        <!-- modal -->
        @include('backend.payment.modals.modal_invoice')
    </section>

</div>
<!-- Scripts -->
@include('backend.payment.scripts.script_payment')
@include('backend.payment.scripts.script_invoice_modal')
<script>
    $("#example1, #invoiceTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
@endsection