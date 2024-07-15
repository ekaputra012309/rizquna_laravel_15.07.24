@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Rekening</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('rekening.index') }}">Rekening</a></li>
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
                            <h3 class="card-title">Edit Rekening</h3>
                        </div>
                        <form action="{{ route('rekening.update', $rekening->id_rekening) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="rekening-id-column" class="form-label">Rekening ID</label>
                                        <input type="text" id="rekening_id" class="form-control" placeholder="Rekening ID" name="rekening_id" value="{{ old('rekening_id', $rekening->rekening_id) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="norek-id-column" class="form-label">No Rekening</label>
                                        <input type="text" id="no_rek" class="form-control" placeholder="No Rekening" name="no_rek" value="{{ old('no_rek', $rekening->no_rek) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="keterangan-column" class="form-label">Keterangan</label>
                                        <input type="text" id="keterangan" class="form-control" placeholder="Keterangan" name="keterangan" value="{{ old('keterangan', $rekening->keterangan) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('rekening.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </section>
</div>
@endsection