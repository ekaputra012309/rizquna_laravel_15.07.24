@extends('backend/template/app')

@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Visa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('visa.index') }}">Payment Visa</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit Payment Visa</h3>
                        </div>
                        <form action="{{ route('visa.update', $visa->id_visa) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="visa_id" class="form-label">Invoice No</label>
                                            <input type="text" id="visa_id" class="form-control" placeholder="Invoice No" name="visa_id" data-parsley-required="true" value="{{ $visa->visa_id }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="tgl_visa" class="form-label">Tanggal Invoice</label>
                                            <input type="date" id="tgl_visa" class="form-control" placeholder="Tanggal Invoice" name="tgl_visa" data-parsley-required="true" value="{{ Carbon::parse($visa->tgl_visa)->format('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="agent_nama" class="form-label">Customer/Agen</label>
                                            <div class="input-group">
                                                <input type="hidden" id="agent_id" class="form-control" placeholder="Customer/Agen" name="agent_id" data-parsley-required="true" value="{{ $visa->agent_id }}" readonly />
                                                <input type="text" id="agent_nama" class="form-control" placeholder="Customer/Agen" value="{{ $visa->agent->nama_agent .' - '.$visa->agent->contact_person }}" readonly />
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#agentModal">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="tgl_keberangkatan" class="form-label">Tanggal Keberangkatan</label>
                                            <input type="date" id="tgl_keberangkatan" class="form-control" placeholder="Tanggal Invoice" name="tgl_keberangkatan" data-parsley-required="true" value="{{ Carbon::parse($visa->tgl_keberangkatan)->format('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="jumlah_pax" class="form-label">Jumlah Pax</label>
                                            <input type="number" id="jumlah_pax" class="form-control" placeholder="0" name="jumlah_pax" data-parsley-required="true" value="{{ $visa->jumlah_pax }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="harga_pax" class="form-label">Harga / Pax</label>
                                            <input type="number" id="harga_pax" class="form-control" placeholder="0" name="harga_pax" data-parsley-required="true" value="{{ $visa->harga_pax }}" />
                                            <input type="hidden" id="total" class="form-control" placeholder="0" name="total" value="{{ $visa->total }}" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('visa.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->
            @include('backend.visa.modals.modal_agent')
    </section>
</div>
<!-- script -->
@include('backend.visa.scripts.script_agent_modal')
@include('backend.visa.scripts.script_visa')
@endsection