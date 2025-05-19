@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Jamaah</h1>
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
                            <h3 class="card-title">Edit Jamaah</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('jamaah.update', $jm->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Use PUT method for updates -->
                                @auth
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="cabang_id" value="{{ $cabangId }}">
                                @endauth
                                <div class="row">
                                    {{-- NIK --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nik" class="form-label">NIK</label>
                                            <!--<input type="number" id="nik" class="form-control" name="nik" required placeholder="Nomor Induk Kependudukan">-->
                                            <input type="tel" id="nik" class="form-control" value="{{ $jm->nik }}" name="nik" maxlength="16" required placeholder="Nomor Induk Kependudukan" title="Masukkan 16 digit angka">
                                        </div>
                                    </div>

                                    {{-- Nama --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nama" class="form-label">Nama Lengkap</label>
                                            <input type="text" id="nama" class="form-control" value="{{ $jm->nama }}" name="nama" required placeholder="Nama Jamaah">
                                            <small id="nama-error" class="text-danger d-none"></small>
                                        </div>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" id="alamat" class="form-control" value="{{ $jm->alamat }}" name="alamat" required placeholder="Alamat Lengkap">
                                        </div>
                                    </div>

                                    {{-- No. HP --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="phone" class="form-label">No. HP</label>
                                            <input type="tel" id="phone" class="form-control" value="{{ $jm->phone }}" name="phone" required placeholder="08xxxxxxxxxx" pattern="08[0-9]{8,11}" title="Masukkan nomor HP yang valid (08xxxxxxxx)">
                                        </div>
                                    </div>

                                    {{-- Nomor Passport --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="passpor" class="form-label">No. Passport</label>
                                            <input type="text" id="passpor" class="form-control" value="{{ $jm->passpor }}" name="passpor" required placeholder="Nomor Passport">
                                        </div>
                                    </div>

                                    {{-- DP (optional) --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="dp" class="form-label">DP (Uang Muka) Rp</label>
                                            <input type="number" id="dp" class="form-control" value="{{ $jm->dp }}" name="dp" placeholder="DP jika ada">
                                        </div>
                                    </div>

                                    {{-- Tanggal Berangkat --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="tgl_berangkat" class="form-label">Tanggal Berangkat</label>
                                            <input type="date" id="tgl_berangkat" class="form-control" value="{{ $jm->tgl_berangkat }}" name="tgl_berangkat" required placeholder="Pilih Tanggal">
                                        </div>
                                    </div>

                                    {{-- Agent --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="agent-id-column" class="form-label">Pilih Agent</label>
                                            <select name="agent_id" id="agent_id" class="form-control select2bs4" required>
                                                <option value="">Pilih</option>
                                                @foreach ($dataagent as $rl)
                                                <option value="{{ $rl->id_agent }}" {{ $rl->id_agent == $jm->agent_id ? 'selected' : '' }}>{{ $rl->nama_agent }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Paket --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="paket-id-column" class="form-label">Pilih Paket</label>
                                            <select name="paket_id" id="paket_id" class="form-control select2bs4" required>
                                                <option value="">Pilih</option>
                                                @foreach ($datapaket as $rl)
                                                    <option value="{{ $rl->id }}" {{ $rl->id == $jm->paket_id ? 'selected' : '' }}>{{ $rl->nama_paket }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- hidden Inputs --}}
                                    <input type="hidden" name="status" id="status" value="Sudah DP">
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="form-submit-btn" class="btn btn-primary mb-1 mr-2">Update</button>
                                        <a href="{{ route('bcabang') }}?cabang={{ $cabangId }}" class="btn btn-secondary mb-1">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection