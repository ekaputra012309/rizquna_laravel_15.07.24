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
                        <li class="breadcrumb-item"><a href="{{ route('booking.index') }}">Booking</a></li>
                        <li class="breadcrumb-item active">Add</li>
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
                            <h3 class="card-title">Tambah Pemesanan Hotel</h3>

                        </div>
                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="booking_id" class="form-label">Kode Pemesanan</label>
                                            <input type="text" id="booking_id" class="form-control" placeholder="Kode Pemesanan" name="booking_id" value="{{ $autoId }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tgl_booking" class="form-label">Tanggal Pemesanan</label>
                                            <input type="date" id="tgl_booking" class="form-control" placeholder="Tanggal Pemesanan" name="tgl_booking" value="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="agent_nama" class="form-label">Customer/Agen</label>
                                            <div class="input-group">
                                                <input type="hidden" id="agent_id" class="form-control" placeholder="Customer/Agen" name="agent_id" readonly />
                                                <input type="text" id="agent_nama" class="form-control" placeholder="Customer/Agen" readonly />
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#agentModal">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="hotel_nama" class="form-label">Hotel</label>
                                            <div class="input-group">
                                                <input type="hidden" id="hotel_id" class="form-control" placeholder="Hotel" name="hotel_id" readonly />
                                                <input type="text" id="hotel_nama" class="form-control" placeholder="Hotel" readonly />
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#hotelSearchModal">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="mata_uang" class="form-label">Mata Uang</label>
                                            <select id="mata_uang" name="mata_uang" class="form-control">
                                                <option value="SAR">SAR</option>
                                                <option value="USD">USD</option>
                                                <option value="IDR">IDR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="check_in" class="form-label">Check In</label>
                                            <input type="date" id="check_in" class="form-control" placeholder="Check In" name="check_in" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="check_out" class="form-label">Check Out</label>
                                            <input type="date" id="check_out" class="form-control" placeholder="Check Out" name="check_out" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="malam" class="form-label">Malam</label>
                                            <input type="number" id="malam" class="form-control" placeholder="0" name="malam" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <button type="button" id="detailPemesananBtn" data-toggle="modal" data-target="#detailPemesananModal" class="btn btn-primary" disabled>
                                                <i class="bi bi-plus-circle"></i> Detail Pemesanan
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="table-responsive">
                                            <table class="table" id="detailPesananTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tipe Kamar</th>
                                                        <th>Qty</th>
                                                        <th>Durasi</th>
                                                        <th>Tarif</th>
                                                        <th>Diskon</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($booking_d->isEmpty())
                                                    <tr>
                                                        <td colspan="7" class="text-center">No data available in table</td>
                                                    </tr>
                                                    @else
                                                    @php
                                                    $total_discount = 0;
                                                    $total_subtotal = 0;
                                                    @endphp

                                                    @foreach ($booking_d as $detail)
                                                    @php
                                                    $total_discount += $detail->discount;
                                                    $total_subtotal += $detail->subtotal;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a class="btn btn-danger btn-sm deleteBookingDetail" data-id="{{ $detail->id_booking_detail }}" href="#" data-confirm-delete="true">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </a>
                                                        </td>
                                                        <td>{{ $detail->room->keterangan }}</td>
                                                        <td>{{ $detail->qty }}</td>
                                                        <td>{{ $detail->malam }}</td>
                                                        <td>{{ $detail->tarif }}</td>
                                                        <td>{{ $detail->discount }}</td>
                                                        <td>{{ $detail->subtotal }}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5" style="text-align: right">Total</th>
                                                        <th><input id="total_discount" name="total_discount" type="text" placeholder="0.00" class="form-control" value="{{ $total_discount ?? '0' }}" readonly></th>
                                                        <th><input id="total_subtotal" name="total_subtotal" type="text" placeholder="0.00" class="form-control" value="{{ $total_subtotal ?? '0'}}" readonly></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan"></textarea>
                                            <input type="hidden" id="user_id" class="form-control" name="user_id" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('booking.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->
            @include('backend.booking.modals.modal_agent')
            @include('backend.booking.modals.modal_detail_pemesanan')
            @include('backend.booking.modals.modal_hotel_search')
    </section>
</div>
<!-- script -->
@include('backend.booking.scripts.script_agent_modal')
@include('backend.booking.scripts.script_hotel_search_modal')
@include('backend.booking.scripts.script_detail_pemesanan')
@include('backend.booking.scripts.script_booking_d')

@endsection