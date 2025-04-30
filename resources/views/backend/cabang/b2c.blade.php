@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data B2C</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li> -->
                        {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                        <li class="breadcrumb-item active">Data B2C</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        @foreach ($datacabang as $cabang)
                            <div class="col-12 col-sm-6 col-md-3">
                                <a href="{{ route('bcabang') }}?cabang={{ $cabang->id }}" class="text-decoration-none text-dark">
                                    <div class="info-box">
                                    <span class="info-box-icon elevation-1">
                                        <i class="fas fa-users"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $cabang->nama_cabang }}</span>
                                        <span class="info-box-number">
                                        {{ $cabang->jamaah_count }} Data
                                        </span>
                                    </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            const colors = [
                'bg-primary',
                'bg-success',
                'bg-info',
                'bg-warning',
                'bg-danger',
                'bg-secondary',
                'bg-dark'
            ];

            $('.info-box-icon').each(function() {
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                // Remove existing bg-* classes (optional if you know it's only bg-primary)
                $(this).removeClass(function(index, className) {
                    return (className.match(/bg-\S+/g) || []).join(' ');
                });
                $(this).addClass(randomColor);
            });
        });
    </script>

</div>
@endsection