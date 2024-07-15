<!DOCTYPE html>
<html>

<head>
    <title>Laporan {{config('app.name')}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table {
            width: 96%;
            font-size: small;
        }

        table td,
        table th {
            padding: 5px;
        }

        .btn-xs {
            padding: 0.25rem 0.25rem;
            font-size: 0.75rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <center>
            <h4>Laporan {{config('app.name')}}</h4>
        </center>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-end">
                    <p class="mb-2">Laporan Tanggal : {{ $date }}</p>
                </div>
            </div>
        </div>
        <table class=' table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Lantai</th>
                    <th>No</th>
                    <th style="width: 150px;">Nama Pedagang</th>
                    <th>Bayar</th>
                    <th>Iuran</th>
                    <th>Keterangan</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datalaporan as $key => $laporan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $laporan->Pedagang->Layanan->layanan }}</td>
                    <td>{{ $laporan->Pedagang->lantai }}</td>
                    <td>{{ $laporan->Pedagang->nomor }}</td>
                    <td>{{ $laporan->Pedagang->pedagang }}</td>
                    <td>
                        @if ($laporan->bayar == 'Ya')
                        <a href="#" class="btn btn-success btn-xs">Ya</a>
                        @else
                        <a href="#" class="btn btn-danger btn-xs">Tidak</a>
                        @endif
                    </td>
                    <td>{{ number_format($laporan->iuran,0,',','.') }}</td>
                    <td>{{ $laporan->keterangan }}</td>
                    <td>{{ $laporan->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table>
            <tr style="vertical-align: top;">
                <td>Tanggal cetak : {{ $today }}</td>
                <td>
                    Total Bayar: {{$totalBayar}} <br>
                    Total Tidak Bayar: {{$totalTidakBayar}}
                </td>
                <td>Pendapatan: Rp. {{ number_format($totalIuran,0,',','.') }}</td>
            </tr>
        </table>


        </p>
    </div>

</body>

</html>