@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Payment Visa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        <!-- {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}} -->
                        <li class="breadcrumb-item active">Data Payment Visa</li>
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
                                        <input type="hidden" name="idbooking" value="{{ $datavisa->visa_id }}">
                                        <select class="form-control me-2" id="bank" name="bank" style="width: 150px;">
                                            <option value="MANDIRI">MANDIRI</option>
                                            <option value="BSI">BSI</option>
                                        </select> &nbsp;
                                        <button type="submit" class="btn btn-danger" style="min-width: 100px;">
                                            <i class="bi bi-printer"></i> Cetak
                                        </button>
                                    </form>
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
                                        <label for="booking_id" class="form-label">Invoice</label>
                                        <input type="text" id="booking_id" class="form-control" placeholder="Invoice" value="{{ $datavisa->visa_id }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="tgl_visa" class="form-label">Tgl Invoice</label>
                                        <input type="text" id="tgl_visa" class="form-control" placeholder="Tanggal Invoice" value="{{ \Carbon\Carbon::parse($datavisa->tgl_visa)->locale('id')->translatedFormat('d F Y') }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group ">
                                        <label for="agent_nama" class="form-label">Customer/Agen</label>
                                        <div class="input-group">
                                            <input type="hidden" id="agent_id" class="form-control" placeholder="Customer/Agen" value="{{ $datavisa->agent->id_agent }}" readonly />
                                            <input type="text" id="agent_nama" class="form-control" placeholder="Customer/Agen" value="{{ $datavisa->agent->nama_agent .' - '.$datavisa->agent->contact_person }}" readonly />
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
                            <p id="atas">{{ $datavisa->kurs->pilih_konversi }}</p>
                            <p style="font-size: 30pt; text-align:right">
                                <span id="kiri">{{ $datavisa->kurs->pilih_konversi == 'USD' ? '$' : '' }}</span>
                                <span id="bawah1" class="d-none">{{ $datavisa->kurs->hasil_konversi }}</span>
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
                                <div class="table-responsive">
                                    <table class="table w-100" id="detailPesananTable">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Keberangkatan</th>
                                                <th>Jumlah Pax</th>
                                                <th>Harga / Pax</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($datavisa)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($datavisa->tgl_keberangkatan)->locale('id')->translatedFormat('d F Y') }}</td>
                                                <td>{{ $datavisa->jumlah_pax }}</td>
                                                <td>{{ $datavisa->harga_pax }}</td>
                                                <td>{{ $datavisa->total }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" style="text-align: right">Total</th>
                                                <th style="vertical-align: top">{{ $datavisa->total }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
        @include('backend.visa.modals.modal_detail_pembayaran')
    </section>
</div>

<!-- Scripts -->
@include('backend.visa.scripts.script_visa_d')
@endsection