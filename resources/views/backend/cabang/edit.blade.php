@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Cabang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('cabang.index') }}">Cabang</a></li>
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
                            <h3 class="card-title">Edit Cabang</h3>
                        </div>
                        <form action="{{ route('cabang.update', $cabang->id_cabang) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama-cabang-column" class="form-label">Nama Cabang</label>
                                        <input type="text" id="nama_cabang" class="form-control" placeholder="Nama Cabang" name="nama_cabang" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('cabang.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </section>
</div>
@endsection