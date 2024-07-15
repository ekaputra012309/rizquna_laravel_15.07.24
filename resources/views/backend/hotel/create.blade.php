@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hotel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        <li class="breadcrumb-item"><a href="{{ route('hotel.index') }}">Hotel</a></li>
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
                            <h3 class="card-title">Tambah Hotel</h3>

                        </div>
                        <form action="{{ route('hotel.store') }}" method="POST">
                            @csrf
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama-hotel-column" class="form-label">Nama Hotel</label>
                                        <input type="text" id="nama_hotel" class="form-control" placeholder="Nama hotel" name="nama_hotel" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="alamat-column" class="form-label">Alamat</label>
                                        <input type="text" id="alamat" class="form-control" placeholder="Alamat" name="alamat" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="contact-person-column" class="form-label">Contact Person</label>
                                        <input type="text" id="contact_person" class="form-control" name="contact_person" placeholder="Contact Person" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="telepon-column" class="form-label">Telepon</label>
                                        <input type="number" id="telepon" class="form-control" name="telepon" placeholder="Telepon" required>
                                        <input type="hidden" id="hotel_id" class="form-control" name="hotel_id" />
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('hotel.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection