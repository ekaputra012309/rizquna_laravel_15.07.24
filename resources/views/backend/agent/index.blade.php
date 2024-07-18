@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Agent</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                        <li class="breadcrumb-item active">Agent</li>
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
                                <a href="{{ route('agents.export.excel') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                                <a href="{{ route('agents.export.pdf') }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                            <div class="card-tools">
                                <a href="{{ route('agent.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Agent</th>
                                        <th>Kontak Person</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataagent as $agent)
                                    <tr>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ route('agent.edit', $agent->id_agent) }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('agent.destroy', $agent->id_agent) }}" data-confirm-delete="true">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                        <td>{{ $agent->nama_agent }}</td>
                                        <td>{{ $agent->contact_person }}</td>
                                        <td>{{ $agent->telepon }}</td>
                                        <td>{{ $agent->alamat }}</td>
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
    </script>
</div>
@endsection