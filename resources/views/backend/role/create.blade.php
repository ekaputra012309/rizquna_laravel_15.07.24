@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
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
                            <h3 class="card-title">Tambah Role</h3>

                        </div>
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="kamar-id-column" class="form-label">Kode Role</label>
                                        <input type="text" id="kode_role" class="form-control" placeholder="Kode Role" name="kode_role" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="nama-role-column" class="form-label">Nama Role</label>
                                        <input type="text" id="nama_role" class="form-control" placeholder="Nama Role" name="nama_role" required>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection