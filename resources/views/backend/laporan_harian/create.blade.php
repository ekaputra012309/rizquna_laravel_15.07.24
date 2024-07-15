@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Harian</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('harian.index') }}">Harian</a></li>
                    <li class="breadcrumb-item active">Add</li>
                    </ol> --}}
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
                            <h3 class="card-title">Tambah Laporan Harian</h3>
                        </div>
                        <form action="{{ route('harian.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- @auth
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pedagang">Nama Pedagang</label>
                                            <select name="pedagang[]" class="form-control select2bs4" multiple="multiple" required>
                                                <option value="">Pilih Blok/Nomor | Nama Pedagang</option>
                                                @foreach ($datapedagang as $pedagang)
                                                <option value="{{ $pedagang->id }}">{{ $pedagang->blok . '/'.$pedagang->nomor.' | ' . $pedagang->pedagang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bayar">Bayar</label>
                                            <select id="bayar" name="bayar" class="form-control" style="width: 100%" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" required>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-md-4">
                                            <label for="imageName">Upload Foto</label>
                                            <input type="file" name="imageName" class="form-control" id="imageName">
                                        </div> --}}
                                    <div class="form-group col-md-4">
                                        <label for="imageName">Upload Foto</label>
                                        <input type="file" name="imageName" capture="user" accept="image/*" class="form-control" id="imageName">
                                    </div>

                                    {{-- <div class="form-group col-md-2">
                                            <div class="controls">
                                                <img id="showImage" src="{{ url('img/no_image.jpg') }}"
                                    style="height: 100%; width: 100px; border: 1px solid #000000;">
                                </div>
                            </div> --}}
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        {{-- <button type="reset" class="btn btn-danger">Reset</button> --}}
                        <a href="{{ route('harian.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
</div>
</section>

<script>
    $(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    })
</script>
{{-- <script>
            $(document).ready(function() {
                $('#imageName').change(function(e) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });
        </script> --}}

</div>
@endsection