@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report Agent</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Report Agent</li>
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
                            <h5>Pilih Range Tanggal Transaksi</h5>
                            <form id="filterForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tgl_from" class="form-label">Tanggal Dari</label>
                                            <input type="date" id="tgl_from" class="form-control" name="tgl_from" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tgl_to" class="form-label">Tanggal Ke</label>
                                            <input type="date" id="tgl_to" class="form-control" name="tgl_to" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="agent_nama" class="form-label">Customer/Agen</label>
                                            <div class="input-group">
                                                <select name="agent_id" id="agent_id" class="form-control select2bs4">
                                                    <option value="">Pilih</option>
                                                    <option value="">Pilih Semua</option>
                                                    @foreach ($dataagent as $rl)
                                                    <option value="{{ $rl->id_agent }}">{{ $rl->nama_agent }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="button" id="filterButton" class="btn btn-primary">Filter Data</button>
                                            <input type="reset" class="btn btn-secondary" value="Reset" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Agent</th>
                                        <th>Invoice</th>
                                        <th>Tgl Pemesanan</th>
                                        <th>Sub Total</th>
                                        <th>Status</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "searching": false,
            "buttons": [{
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    action: function(e, dt, button, config) {
                        exportData('excel');
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    action: function(e, dt, button, config) {
                        exportData('pdf');
                    }
                }
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#filterButton').on('click', function(e) {
            e.preventDefault();

            let tglFrom = $('#tgl_from').val();
            let tglTo = $('#tgl_to').val();

            if (!tglFrom || !tglTo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tanggal Dari dan Tanggal Ke tidak boleh kosong.',
                });
                return;
            }

            $.ajax({
                url: '{{ route("agents.report") }}',
                method: 'GET',
                data: $('#filterForm').serialize(),
                success: function(response) {
                    // Process the response and update the table
                    let tbody = $('#example1 tbody');
                    tbody.empty();

                    if (response.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="5" class="text-center">No data available</td>
                            </tr>
                        `);
                    } else {
                        response.forEach(function(booking) {
                            let statusClasses = {
                                'Piutang': 'btn btn-danger btn-sm',
                                'DP': 'btn btn-warning btn-sm',
                                'Lunas': 'btn btn-success btn-sm'
                            };

                            let statusClass = statusClasses[booking.status] || 'btn btn-secondary btn-sm';

                            tbody.append(`
                                <tr>
                                    <td>${booking.agent.nama_agent}</td>
                                    <td>${booking.booking_id}</td>
                                    <td>${new Date(booking.tgl_booking).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</td>
                                    <td>${booking.total_subtotal}</td>
                                    <td><span class="${statusClass}">${booking.status}</span></td>
                                    <td>${booking.user.name}</td>
                                </tr>
                            `);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        function exportData(type) {
            let tglFrom = $('#tgl_from').val();
            let tglTo = $('#tgl_to').val();
            let agentId = $('#agent_id').val();

            if (!tglFrom || !tglTo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Tanggal Dari dan Tanggal Ke tidak boleh kosong.',
                });
                return;
            }

            let exportUrl = "{{ route('agents.export') }}" + "?type=" + type + "&tgl_from=" + tglFrom + "&tgl_to=" + tglTo + "&agent_id=" + agentId;
            window.location.href = exportUrl;
        }
    });
</script>
@endsection