@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Laporan Harian</h1>
                </div>
                <div class="col-sm-6">
                    {{-- Breadcrumbs (if needed) --}}
                    {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('harian.index') }}">Harian</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                    </ol> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ asset('img/'.$harian->foto) }}" alt="image" class="img-fluid thumbail" style="max-height: 400px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Layanan Harian:</strong> {{ $harian->Pedagang->Layanan->layanan }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Lantai:</strong> {{ $harian->Pedagang->lantai }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Blok:</strong> {{ $harian->Pedagang->blok }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Nomor:</strong> {{ $harian->Pedagang->nomor }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Nama Pedagang:</strong> {{ $harian->Pedagang->pedagang }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Bayar:</strong> {{ $harian->bayar }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Keterangan:</strong> {{ $harian->keterangan }}</p>
                            <hr> {{-- Divider --}}
                            <p><strong>Tanggal Input:</strong> {{ $harian->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('harian.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection