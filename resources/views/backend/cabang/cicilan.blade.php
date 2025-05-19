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
                    <h1>Detail Cicilan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Cicilan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Jamaah Profile Table -->
                <div class="col-12 col-md-9">
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-header bg-primary text-white text-center rounded-top">
                            <h4 class="m-0">Jamaah Profile</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $datajamaah->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $datajamaah->nik }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $datajamaah->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Passport</th>
                                    <td>{{ $datajamaah->passpor }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $datajamaah->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Berangkat</th>
                                    <td>{{ \Carbon\Carbon::parse($datajamaah->tgl_berangkat)->translatedFormat('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Paket Details Table -->
                <div class="col-12 col-md-3">
                    <!-- First Card: Paket Details -->
                    <div class="card shadow-sm border-0 rounded mb-3">
                        <div class="card-header bg-success text-white text-center rounded-top">
                            <h4 class="m-0">Paket Details</h4>
                        </div>
                        <div class="card-body">
                            @if($datajamaah->paket)
                                <table class="table table-bordered table-responsive">
                                    <!-- <tr>
                                        <th>Kode Paket</th>
                                        <td>{{ $datajamaah->paket->kode_paket }}</td>
                                    </tr> -->
                                    <tr>
                                        <th>Nama Paket</th>
                                        <td>{{ $datajamaah->paket->nama_paket }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga Paket</th>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <span style="font-size: 1.2rem;">Rp</span>
                                                <span style="font-size: 2rem; font-weight: bold;">{{ number_format($datajamaah->paket->harga_paket, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <p>No Paket Assigned</p>
                            @endif
                        </div>
                    </div>

                    <!-- Second Card: Example (e.g. Agent Details) -->
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-header bg-info text-white text-center rounded-top">
                            <h4 class="m-0">Sisa Cicilan</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 1.2rem;">Rp</span>
                                <span style="font-size: 2rem; font-weight: bold;">{{ number_format($sisaCicilan, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Rincian Cicilan</h3>
                            <div class="card-tools">
                                <a href="{{ route('bcabang') }}?cabang={{ $datajamaah->cabang_id }}" class="btn btn-sm btn-secondary mb-1 mr-2"><i class="fas fa-arrow-left"></i> Back</a>

                                <button 
                                    class="btn btn-primary btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#addCicilanModal"
                                    @if($datacicilan->count() >= $maxCicilan || $isFinished) 
                                        disabled 
                                    @endif>
                                        <i class="fas fa-plus"></i> Add Cicilan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Cicil</th>
                                        <th>Jumlah</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#</td>
                                        <td>{{ Carbon::parse($datajamaah->created_at)->translatedFormat('d F Y') }}</td>
                                        <td class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ $datajamaah->dp ? number_format($datajamaah->dp, 0, ',', '.') : '-' }}</span>
                                        </td>
                                        <td>{{ $datajamaah->user->name }}</td>
                                        <td>Deposit</td>
                                    </tr>
                                    @foreach ($datacicilan as $cicilan)
                                    @php
                                        $isOwner = $cicilan->user_id === Auth::id();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $cicilan->tgl_cicil 
                                                ? Carbon::parse($cicilan->tgl_cicil)->translatedFormat('d F Y') 
                                                : '-' 
                                            }}
                                        </td>
                                        <td class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ $cicilan->deposit ? number_format($cicilan->deposit, 0, ',', '.') : '-' }}</span>
                                        </td>
                                        <td>{{ $cicilan->user->name }}</td>
                                        <td>
                                            <a 
                                                href="{{ $isOwner ? route('cicilan.hapus', $cicilan->id) : '#' }}" 
                                                class="btn btn-sm btn-danger {{ !$isOwner ? 'disabled-link' : '' }}" 
                                                {{ !$isOwner ? 'onclick=return false;' : 'data-confirm-delete=true' }}>
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                            @if ($userRole !== 'cabang')
                                            <button class="btn btn-sm btn-secondary" data-id="{{ $cicilan->id }}" onclick="kwitansiBtn(this)">
                                                <i class="fas fa-print"></i> Kwitansi
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Sisa Cicilan</th>
                                        <th class="d-flex justify-content-between">
                                            <span>Rp</span>
                                            <span>{{ number_format($sisaCicilan, 0, ',', '.') }}</span>
                                        </th>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>                
            </div>            
        </div>
        <!-- Add Cicilan Modal -->
        <div class="modal fade" id="addCicilanModal" tabindex="-1" aria-labelledby="addCicilanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('cicilan.tambah') }}" method="POST">
                @csrf
                <input type="hidden" name="id_jamaah" value="{{ $datajamaah->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addCicilanLabel">Tambah Cicilan</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
                        <label for="tgl_cicil" class="form-label">Tanggal Cicil</label>
                        <input type="date" class="form-control" name="tgl_cicil" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="deposit" class="form-label">Jumlah Deposit</label>
                        <input type="number" class="form-control" name="deposit" id="deposit" required>
                        <div class="invalid-feedback" id="invalid-deposit">
                            Deposit cannot be greater than the remaining balance (Rp {{ number_format($sisaCicilan, 0, ',', '.') }})
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
                </form>
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

        $(document).ready(function() {
            // Get the sisaCicilan value from the backend
            const sisaCicilan = @json($sisaCicilan);

            // Form submission event
            $("#addCicilanForm").on("submit", function(event) {
                var deposit = $("#deposit").val();

                // Check if the deposit exceeds sisaCicilan
                if (parseFloat(deposit) > sisaCicilan) {
                    event.preventDefault(); // Prevent form submission
                    $("#invalid-deposit").show(); // Show the error message
                    $("#deposit").addClass("is-invalid"); // Add Bootstrap invalid class
                    $("#submit-btn").prop("disabled", true); // Disable submit button
                } else {
                    // If valid, allow form submission
                    $("#invalid-deposit").hide(); // Hide error message
                    $("#deposit").removeClass("is-invalid"); // Remove invalid class
                    $("#submit-btn").prop("disabled", false); // Enable submit button
                }
            });

            // Input change event (for immediate feedback)
            $("#deposit").on("input", function() {
                var deposit = $(this).val();

                if (parseFloat(deposit) <= sisaCicilan) {
                    $("#invalid-deposit").hide(); // Hide error message
                    $(this).removeClass("is-invalid"); // Remove invalid class
                    $("#submit-btn").prop("disabled", false); // Enable submit button
                } else {
                    $("#invalid-deposit").show(); // Show error message
                    $(this).addClass("is-invalid"); // Add invalid class
                    $("#submit-btn").prop("disabled", true); // Disable submit button
                }
            });
        });

        function kwitansiBtn(button){
            var jamaahId = $(button).data('id');                
            var editHref = "{{ route('kwitansi.cetak2', ['id' => ':id']) }}";
            editHref = editHref.replace(':id', jamaahId);
            window.open(editHref, '_blank');
        }

    </script>
</div>
@endsection
