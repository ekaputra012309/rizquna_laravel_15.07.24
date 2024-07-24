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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <form class="d-flex" action="{{ route('cetak.rizquna') }}" method="GET" target="_blank">
                                        <input type="hidden" name="idbooking" value="{{ $datapayment->booking->id_booking }}">
                                        <select class="form-control me-2" id="bank" name="bank" style="width: 150px;">
                                            <option value="MANDIRI">MANDIRI</option>
                                            <option value="BSI">BSI</option>
                                        </select> &nbsp;
                                        <button type="submit" class="btn btn-danger" style="min-width: 100px;">
                                            <i class="fas fa-print"></i> Cetak
                                        </button> &nbsp;
                                    </form>
                                    <a href="{{route('cetak.alrayah')}}" class="btn btn-info" style="min-width: 100px;">
                                        <i class="far fa-file-powerpoint"></i> Cetak
                                    </a>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary button-bayar" data-toggle="modal" data-target="#detailPembayaranModal">
                                        <i class="bi bi-wallet2"></i> Add Pembayaran
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="booking_id" class="form-label">Kode Pemesanan</label>
                                        <input type="text" id="booking_id" class="form-control" placeholder="Kode Pemesanan" value="{{ $datapayment->booking->booking_id }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="tgl_booking" class="form-label">Tgl Pemesanan</label>
                                        <input type="text" id="tgl_booking" class="form-control" placeholder="Tanggal Pemesanan" value="{{ \Carbon\Carbon::parse($datapayment->booking->tgl_booking)->locale('id')->translatedFormat('d F Y') }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group ">
                                        <label for="agent_nama" class="form-label">Customer/Agen</label>
                                        <div class="input-group">
                                            <input type="hidden" id="agent_id" class="form-control" placeholder="Customer/Agen" value="{{ $datapayment->booking->agent->id_agent }}" readonly />
                                            <input type="text" id="agent_nama" class="form-control" placeholder="Customer/Agen" value="{{ $datapayment->booking->agent->nama_agent .' - '.$datapayment->booking->agent->contact_person }}" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Tagihan</h5>
                            <p id="atas">{{ $datapayment->pilih_konversi }}</p>
                            <p style="font-size: 30pt; text-align:right">
                                <span id="kiri">{{ $datapayment->pilih_konversi == 'USD' ? '$' : '' }}</span>
                                <span id="bawah1" class="d-none">{{ $datapayment->hasil_konversi }}</span>
                                <span id="bawah"></span>
                            </p>
                            <input type="hidden" id="kanan">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 col-12">
                                <h3>Rincian Pemesanan</h3>
                                <div class="table-responsive">
                                    <table class="table w-100">
                                        <thead>
                                            <tr>
                                                <td><b>Nama Hotel</b></td>
                                                <td>: {{ $datapayment->booking->hotel->nama_hotel }}</td>
                                                <td><b>Check In</b></td>
                                                <td>: {{ \Carbon\Carbon::parse($datapayment->booking->check_in)->locale('id')->translatedFormat('d F Y') }}</td>
                                                <td><b>Check Out</b></td>
                                                <td>: {{ \Carbon\Carbon::parse($datapayment->booking->check_out)->locale('id')->translatedFormat('d F Y') }}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="table-responsive">
                                    <table class="table w-100" id="detailPesananTable">
                                        <thead>
                                            <tr>
                                                <th>Tipe Kamar</th>
                                                <th>Qty</th>
                                                <th>Durasi</th>
                                                <th>Tarif</th>
                                                <th>Diskon</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($booking_d as $detail)
                                            <tr>
                                                <td>{{ $detail->room->keterangan }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td>{{ $detail->malam }}</td>
                                                <td>{{ $detail->tarif }}</td>
                                                <td>{{ $detail->discount }}</td>
                                                <td>{{ $detail->subtotal }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align: right">Total</th>
                                                <th style="vertical-align: top">
                                                    <span>{{ $datapayment->booking->total_discount }}</span>
                                                </th>
                                                <th style="vertical-align: top">
                                                    <span>{{ $datapayment->booking->total_subtotal }}</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div>
                                        <label for=""><b>Keterangan</b></label>
                                        <textarea class="form-control w-100" id="keterangan" rows="2" placeholder="Keterangan" readonly>{{ $datapayment->booking->keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <br>
                                <h3>List Pembayaran</h3>
                                <div class="table-responsive">
                                    <table class="table" id="listPembayaran">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tgl Pembayaran</th>
                                                <th>Jumlah Deposit</th>
                                                <th>Metode Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals -->
        @include('backend.payment.modals.modal_detail_pembayaran')
    </section>
</div>

<!-- Scripts -->
@include('backend.payment.scripts.script_payment_d')
@endsection