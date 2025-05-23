@extends('backend/template/app')

@section('content')
@php use Carbon\Carbon; @endphp

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
                                            <!--<input type="number" id="nik" class="form-control" name="nik" required placeholder="Nomor Induk Kependudukan">-->
                                            <input type="tel" id="nik" class="form-control" name="nik" maxlength="16" required placeholder="Nomor Induk Kependudukan" title="Masukkan 16 digit angka">
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
                                            <small id="nama-error" class="text-danger d-none"></small>
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
                                            <input type="text" id="passpor" class="form-control" name="passpor" required placeholder="Nomor Passport">
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
                                                {{-- Show unavailable paket if editing and paket_id is not in the list --}}
                                                @if(isset($jamaah) && $jamaah->paket_id && !$datapaket->contains('id', $jamaah->paket_id))
                                                    <option value="{{ $jamaah->paket_id }}" selected>(Paket tidak tersedia)</option>
                                                @endif

                                                @foreach ($datapaket as $rl)
                                                    <option value="{{ $rl->id }}"
                                                        {{ old('paket_id', isset($jamaah) ? $jamaah->paket_id : '') == $rl->id ? 'selected' : '' }}>
                                                        {{ $rl->nama_paket }}
                                                    </option>
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
                            <form action="">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label for="tgl_filter" class="form-label">Filter Tanggal Keberangkatan </label>
                                        <input type="date" id="tgl_filter" class="form-control" placeholder="Filter Tanggal Berangkat" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label d-block">&nbsp;</label> <!-- For spacing -->
                                        <button type="submit" id="btnFilter" class="btn btn-success me-2">Filter</button>
                                        <button type="reset" id="btnClear" class="btn btn-secondary">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jamaah</th>
                                        <th>Status</th>
                                        <th>Alamat</th>
                                        <th>Phone</th>
                                        <th>DP</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Agent</th>
                                        <th>Created by</th>
                                        <th>Updated by</th>
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
                                       <td>
                                            <span class="btn btn-xs 
                                                @if ($jamaah->cicilan_status == 'Lunas')
                                                    btn-success
                                                @elseif ($jamaah->cicilan_status == 'Sudah DP')
                                                    btn-warning
                                                @else
                                                    btn-danger
                                                @endif">
                                                {{ $jamaah->cicilan_status }}
                                            </span>
                                        </td>
                                        <td>{{ $jamaah->alamat }}</td>
                                        <td>{{ $jamaah->phone }}</td>
                                        <td>{{ $jamaah->dp ? 'Rp ' . number_format($jamaah->cicilan_status == 'Lunas' ? $jamaah->paket->harga_paket : $jamaah->dp, 0, ',', '.') : '-' }}</td>
                                        <td>
                                            {{ $jamaah->tgl_berangkat 
                                                ? Carbon::parse($jamaah->tgl_berangkat)->translatedFormat('d F Y') 
                                                : '-' 
                                            }}
                                        </td>
                                        <td>{{ $jamaah->agent->nama_agent ?? '-' }}</td>
                                        <td>
                                            {{ $jamaah->user->name ?? '-' }} &nbsp;
                                            {{ $jamaah->created_at 
                                                ? Carbon::parse($jamaah->created_at)->translatedFormat('d F Y H:i')  
                                                : '-' 
                                            }}
                                        </td>
                                        <td>
                                            {{ $jamaah->updatebyuser->name ?? ' ' }} &nbsp;
                                            {{ $jamaah->updatetime 
                                                ? Carbon::parse($jamaah->updatetime)->translatedFormat('d F Y H:i')  
                                                : ' ' 
                                            }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('jamaah.show', $jamaah->id) }}">
                                                <i class="fas fa-search"></i> Detail
                                            </a>
                                            <!-- <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-edit" data-id="{{ $jamaah->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a> -->
                                            <a class="btn btn-sm btn-primary" href="{{ route('jamaah.edit', $jamaah->id) }}?cabang={{ $cabangId }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a 
                                                href="{{ $isOwner ? route('jamaah.destroy', $jamaah->id) : '#' }}" 
                                                class="btn btn-sm btn-danger {{ !$isOwner ? 'disabled-link' : '' }}" 
                                                {{ !$isOwner ? 'onclick=return false;' : 'data-confirm-delete=true' }}>
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                            <button class="btn btn-sm btn-secondary {{ $koderole == 'cabang' ? 'd-none' : '' }}" data-id="{{ $jamaah->id }}" onclick="kwitansiBtn(this)">
                                                <i class="fas fa-print"></i> Kwitansi
                                            </button>
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
            "scrollX": true,
            "scrollCollapse": true,
            "fixedColumns": {
                "leftColumns": 2 // fix the first column
            },
            "responsive": false,
            "lengthChange": true,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        function kwitansiBtn(button){
            var jamaahId = $(button).data('id');                
            var editHref = "{{ route('kwitansi.cetak', ['id' => ':id']) }}";
            editHref = editHref.replace(':id', jamaahId);
            window.open(editHref, '_blank');
        }
        
        $('#btnFilter').on('click', function (e) {
            e.preventDefault(); // prevent the default form submission

            const tglFilter = $('#tgl_filter').val();
            const cabangId = $('#IDcabang').val();

            const url = "{{ route('bcabang') }}" + "?cabang={{$cabangId}}" + "&tgl_berangkat=" + encodeURIComponent(tglFilter);

            // Redirect to filtered URL
            window.location.href = url;
        });

        $('#btnClear').on('click', function (e) {
            const url = "{{ route('bcabang') }}" + "?cabang={{$cabangId}}";
            window.location.href = url;
        });
        
        $('#nama').on('blur', function () {
            const nama = $(this).val();
            const jamaahId = $('#jamaah_id').val() || ''; // use for update cases

            if (nama.trim() === '') {
                $('#nama-error').addClass('d-none').text('');
                return;
            }

            $.ajax({
                url: "{{ route('jamaah.checkNama') }}",
                method: 'GET',
                data: {
                    nama: nama,
                    id: jamaahId
                },
                success: function (res) {
                    if (res.duplicate) {
                        $('#nama-error').removeClass('d-none').text('Nama Jamaah serupa sudah terdaftar hari ini.');
                        $('#form-submit-btn').prop('disabled', true);
                    } else {
                        $('#nama-error').addClass('d-none').text('');
                        $('#form-submit-btn').prop('disabled', false);
                    }
                }
            });
        });
    </script>
</div>
@endsection