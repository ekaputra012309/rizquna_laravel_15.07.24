@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Paket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('paket.index') }}">Paket</a></li>
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
                            <h3 class="card-title">Edit Paket</h3>
                        </div>
                        <form action="{{ route('paket.update', $paket->id) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="kode-paket-column" class="form-label">Kode Paket</label>
                                        <input type="text" id="kode_paket" class="form-control" placeholder="Kode Paket" name="kode_paket" value="{{ old('kode_paket', $paket->kode_paket) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama-paket-column" class="form-label">Nama Paket</label>
                                        <input type="text" id="nama_paket" class="form-control" placeholder="Nama Paket" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="harga-paket-column" class="form-label">Harga Paket</label>
                                        <input type="number" id="harga_paket" class="form-control" name="harga_paket" placeholder="Harga Paket" value="{{ old('harga_paket', $paket->harga_paket) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('paket.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </section>
</div>
@endsection