@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Agent</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('agent.index') }}">Agent</a></li>
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
                            <h3 class="card-title">Edit Agent</h3>
                        </div>
                        <form action="{{ route('agent.update', $agent->id_agent) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updates -->
                            @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth

                            <div class="card-body">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama-agent-column" class="form-label">Nama Agent</label>
                                        <input type="text" id="nama_agent" class="form-control" placeholder="Nama Agent" name="nama_agent" value="{{ old('nama_agent', $agent->nama_agent) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="alamat-column" class="form-label">Alamat</label>
                                        <input type="text" id="alamat" class="form-control" placeholder="Alamat" name="alamat" value="{{ old('alamat', $agent->alamat) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="contact-person-column" class="form-label">Contact Person</label>
                                        <input type="text" id="contact_person" class="form-control" name="contact_person" placeholder="Contact Person" value="{{ old('contact_person', $agent->contact_person) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="telepon-column" class="form-label">Telepon</label>
                                        <input type="number" id="telepon" class="form-control" name="telepon" placeholder="Telepon" value="{{ old('telepon', $agent->telepon) }}" required>
                                        <input type="hidden" id="agent_id" class="form-control" name="agent_id" />
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ route('agent.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
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