@extends('backend/template/app')

@section('content')
@php 
    $userRole = \App\Models\Privilage::getRoleKodeForAuthenticatedUser();
    use Carbon\Carbon; 
@endphp

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cabang {{ $namacabang }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                        <li class="breadcrumb-item active">Cabang</li>
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
                        <div class="card-body">
                            <form action="{{ route('jamaah.store') }}" method="POST">
                                @csrf
                                @auth
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="cabang_id" value="{{ $cabangId }}">
                                @endauth
                                <div class="row">
                                    {{-- NIK --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nik" class="form-label">NIK</label>
                                            <input type="number" id="nik" class="form-control" name="nik" required placeholder="Nomor Induk Kependudukan">
                                            @if(isset($jamaah))
                                                <input type="hidden" name="jamaah_id" value="{{ $jamaah->id }}">
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Nama --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nama" class="form-label">Nama Lengkap</label>
                                            <input type="text" id="nama" class="form-control" name="nama" required placeholder="Nama Jamaah">
                                        </div>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="col-12">
                                        <div class="form-group mandatory">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" id="alamat" class="form-control" name="alamat" required placeholder="Alamat Lengkap">
                                        </div>
                                    </div>

                                    {{-- No. HP --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="phone" class="form-label">No. HP</label>
                                            <input type="tel" id="phone" class="form-control" name="phone" required placeholder="08xxxxxxxxxx" pattern="08[0-9]{8,11}" title="Masukkan nomor HP yang valid (08xxxxxxxx)">
                                        </div>
                                    </div>

                                    {{-- Nomor Passport --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="passpor" class="form-label">No. Passport</label>
                                            <input type="number" id="passpor" class="form-control" name="passpor" required placeholder="Nomor Passport">
                                        </div>
                                    </div>

                                    {{-- DP (optional) --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="dp" class="form-label">DP (Uang Muka) Rp</label>
                                            <input type="number" id="dp" class="form-control" name="dp" placeholder="DP jika ada">
                                        </div>
                                    </div>

                                    {{-- Tanggal Berangkat --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="tgl_berangkat" class="form-label">Tanggal Berangkat</label>
                                            <input type="date" id="tgl_berangkat" class="form-control" name="tgl_berangkat" required placeholder="Pilih Tanggal">
                                        </div>
                                    </div>

                                    {{-- Agent --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group mandatory">
                                            <label for="agent-id-column" class="form-label">Pilih Agent</label>
                                            <select name="agent_id" id="agent_id" class="form-control select2bs4" required>
                                                <option value="">Pilih</option>
                                                @foreach ($dataagent as $rl)
                                                <option value="{{ $rl->id_agent }}">{{ $rl->nama_agent }}</option>
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
                                                <option value="{{ $rl->id }}">{{ $rl->nama_paket }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- hidden Inputs --}}
                                    <input type="hidden" name="status" id="status" value="Sudah DP">
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" id="form-submit-btn" class="btn btn-primary mb-1 mr-2">Submit</button>
                                        <button type="reset" class="btn btn-secondary mb-1">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> </h3>
                            <div class="card-tools">
                                <a href="{{ route('cabang.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jamaah</th>
                                        <th>Alamat</th>
                                        <th>Phone</th>
                                        <th>DP</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Agent</th>
                                        <th>Created by</th>
                                        <th>Actions &nbsp; &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datacabang as $jamaah)
                                    @php
                                        $isOwner = $jamaah->user_id === Auth::id();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jamaah->nama }}</td>
                                        <td>{{ $jamaah->alamat }}</td>
                                        <td>{{ $jamaah->phone }}</td>
                                        <td>{{ $jamaah->dp ? 'Rp ' . number_format($jamaah->dp, 0, ',', '.') : '-' }}</td>
                                        <td>
                                            {{ $jamaah->tgl_berangkat 
                                                ? Carbon::parse($jamaah->tgl_berangkat)->translatedFormat('d F Y') 
                                                : '-' 
                                            }}
                                        </td>
                                        <td>{{ $jamaah->agent->nama_agent ?? '-' }}</td>
                                        <td>{{ $jamaah->user->name ?? '-' }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('jamaah.show', $jamaah->id) }}">
                                                <i class="fas fa-search"></i> Detail
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-edit" data-id="{{ $jamaah->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @php
                                                $canDelete = $isOwner || $userRole === 'admin';
                                            @endphp
                                            <a 
                                                href="{{ $canDelete ? route('jamaah.destroy', $jamaah->id) : '#' }}" 
                                                class="btn btn-sm btn-danger {{ !$canDelete ? 'disabled-link' : '' }}" 
                                                {{ !$canDelete ? 'onclick=return false;' : 'data-confirm-delete=true' }}>
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                            @if ($userRole !== 'cabang')
                                            <button class="btn btn-sm btn-secondary" data-id="{{ $jamaah->id }}" onclick="kwitansiBtn(this)">
                                                <i class="fas fa-print"></i> Kwitansi
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $.ajax({
                url: `/jamaah/${id}/edit`,
                method: 'GET',
                success: function (response) {
                    const data = response.data;
                    $('#nik').val(data.nik);
                    $('#nama').val(data.nama);
                    $('#alamat').val(data.alamat);
                    $('#phone').val(data.phone);
                    $('#passpor').val(data.passpor);
                    $('#dp').val(data.dp);
                    $('#tgl_berangkat').val(data.tgl_berangkat);
                    $('#agent_id').val(data.agent_id).trigger('change');
                    $('#paket_id').val(data.paket_id).trigger('change');
                    $('#status').val(data.status);
                    $('#jamaah_id').val(data.id);

                    $('#form-submit-btn').text('Update');
                    
                    if ($('#jamaah_id').length === 0) {
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'jamaah_id',
                            name: 'jamaah_id',
                            value: data.id
                        }).appendTo('form');
                    } else {
                        $('#jamaah_id').val(data.id);
                    }
                }
            });
        });

        function kwitansiBtn(button){
            var jamaahId = $(button).data('id');                
            var editHref = "{{ route('kwitansi.cetak', ['id' => ':id']) }}";
            editHref = editHref.replace(':id', jamaahId);
            window.open(editHref, '_blank');
        }
    </script>
</div>
@endsection