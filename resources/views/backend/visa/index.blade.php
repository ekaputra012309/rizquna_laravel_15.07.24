@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Payment Visa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        <!-- {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}} -->
                        <li class="breadcrumb-item active">Data Payment Visa</li>
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
                            <div class="card-title">
                                <form action="{{ route('kurs.store') }}" method="POST">
                                    @csrf
                                    @auth
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    @endauth
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="no-inv-column" class="form-label">No Invoice</label>
                                                <input type="text" id="no_inv" class="form-control" placeholder="No Invoice" data-parsley-required="true" readonly />
                                                <input type="hidden" id="id_visa" name="id_visa" placeholder="id visa">
                                                <input type="hidden" id="hasil_konversi" name="hasil_konversi" placeholder="konversi">
                                                <input type="hidden" id="total" placeholder="total">
                                                <input type="hidden" value="1" name="status">
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="kurs-bsi-column" class="form-label">KURS BSI</label>
                                                <input type="text" id="kurs_bsi" class="form-control" placeholder="0.00" step="0.01" name="kurs_bsi" data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="kurs-riyal-column" class="form-label">KURS RIYAL</label>
                                                <input type="text" id="kurs_riyal" class="form-control" placeholder="0.00" step="0.01" name="kurs_riyal" data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label for="pilih_konversi" class="form-label">Pilih</label>
                                                <select id="pilih_konversi" name="pilih_konversi" class="form-control" data-parsley-required="true">
                                                    <option value="">Pilih</option>
                                                    <option value="USD">USD</option>
                                                    <option value="IDR">IDR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <div class="form-group">
                                                <label class="form-label"><span class="text-white">4</span></label>
                                                <br>
                                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                                    <i class="bi bi-save"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-tools">
                                <a href="{{ route('visa.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Tanggal Invoice</th>
                                        <th>Tgl Keberangkatan</th>
                                        <th>Agen</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datavisa as $visa)
                                    <tr>
                                        <td>
                                            @if ($visa->kurs->status ?? 0 == 1)
                                            <a class="btn btn-secondary btn-sm" href="{{ route('visa.show', $visa->id_visa) }}">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            @else
                                            <button class="btn btn-sm btn-success tambah" data-id-visa="{{ $visa->id_visa }}" data-visa-id="{{ $visa->visa_id }}" data-total="{{ $visa->total }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            @endif
                                            @if ($visa->status === 'Lunas')
                                            <button class="btn btn-primary btn-sm" disabled>
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" disabled>
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            @else
                                            <a class="btn btn-sm btn-primary" href="{{ route('visa.edit', $visa->id_visa) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('visa.destroy', $visa->id_visa) }}" data-confirm-delete="true">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                            @endif

                                        </td>
                                        <td>{{ $visa->visa_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visa->tgl_visa)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($visa->tgl_keberangkatan)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $visa->agent->nama_agent }}</td>
                                        <td>$ {{ number_format($visa->total,0,',','.') }}</td>
                                        @php
                                        $statusClasses = [
                                        'Piutang' => 'btn btn-danger btn-sm',
                                        'DP' => 'btn btn-warning btn-sm',
                                        'Lunas' => 'btn btn-success btn-sm'
                                        ];
                                        $statusClass = $statusClasses[$visa->status] ?? 'btn btn-secondary btn-sm';
                                        @endphp

                                        <td>
                                            <span class="{{ $statusClass }}">{{ $visa->status }}</span>
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
        $(document).ready(function() {
            $('.tambah').click(function() {
                var idVisa = $(this).data('id-visa');
                var visaId = $(this).data('visa-id');
                var total = $(this).data('total');

                $('#id_visa').val(idVisa);
                $('#no_inv').val(visaId);
                $('#total').val(total);
            });

            $('#pilih_konversi').on('change', function() {
                var selectedCurrency = $(this).val();
                var tagihan_awal = parseFloat($('#total').val());

                if (selectedCurrency === "USD") {
                    // If USD is selected, set the result equal to the original amount
                    $('#hasil_konversi').val(tagihan_awal);
                } else {
                    // For other currencies, multiply the original amount by the exchange rate
                    var kurs_bsi = parseFloat($('#kurs_bsi').val());
                    var tagihan = tagihan_awal * kurs_bsi;
                    $('#hasil_konversi').val(tagihan);
                }
            });

            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
</div>
@endsection