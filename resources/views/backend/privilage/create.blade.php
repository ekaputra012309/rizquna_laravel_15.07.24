@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Privilage</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        <li class="breadcrumb-item"><a href="{{ route('privilage.index') }}">Privilage</a></li>
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
                            <h3 class="card-title">Tambah Privilage</h3>

                        </div>
                        <form action="{{ route('privilage.store') }}" method="POST">
                            @csrf
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nama-user-column" class="form-label">Nama User</label>
                                            <select name="user_id" id="user_id" class="form-control select2bs4">
                                                <option value="">Pilih</option>
                                                @foreach ($datauser as $usr)
                                                <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="role-id-column" class="form-label">Role</label>
                                            <select name="role_id" id="role_id" class="form-control select2bs4">
                                                <option value="">Pilih</option>
                                                @foreach ($datarole as $rl)
                                                <option value="{{ $rl->id }}">{{ $rl->nama_role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="cabang-id-column" class="form-label">Cabang</label>
                                            <select name="cabang_id" id="cabang_id" class="form-control select2bs4">
                                                <option value="">Pilih</option>
                                                @foreach ($datacabang as $rl)
                                                <option value="{{ $rl->id }}">{{ $rl->nama_cabang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('privilage.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
</div>
@endsection