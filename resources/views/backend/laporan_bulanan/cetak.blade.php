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
                    <p class="mb-2">Laporan Tanggal : {{ date('d M Y', strtotime($startDate)) }} -
                        {{ date('d M Y', strtotime($endDate)) }}
                    </p>
                </div>
            </div>
        </div>
        <table class=' table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pedagang</th>
                    <th>Lantai</th>
                    <th>Nomor</th>
                    <th>Jumlah Bayar</th>
                    <th>Jumlah Tidak Bayar</th>
                    <th colspan="2">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $ya = 0;
                $tidak = 0;
                $ttl = 0;
                @endphp
                @foreach ($datalaporan as $key => $laporan)
                @php
                $ya += $laporan->bayar_ya_count;
                $tidak += $laporan->bayar_tidak_count;
                $ttl += $laporan->total_iuran_ya;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $laporan->Pedagang->pedagang }}</td>
                    <td>{{ $laporan->Pedagang->lantai }}</td>
                    <td>{{ $laporan->Pedagang->nomor }}</td>
                    <td style="text-align: center;">{{ $laporan->bayar_ya_count }}</td>
                    <td style="text-align: center;">{{ $laporan->bayar_tidak_count }}</td>
                    <td style="border-right: 1px solid white;">Rp </td>
                    <td style="text-align: right;">{{ number_format($laporan->total_iuran_ya,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td style="text-align: center;">{{ $ya }}</td>
                    <td style="text-align: center;">{{ $tidak }}</td>
                    <td style="border-right: 1px solid white;">Rp </td>
                    <td style="text-align: right;">{{ number_format($ttl,0,',','.') }}</td>
                </tr>
            </tfoot>
        </table>
        <table>
            <tr style="vertical-align: top;">
                <td>Tanggal cetak : {{ $today }}</td>
                <td style="text-align: right;">Pendapatan: Rp. {{ number_format($totalIuran,0,',','.') }}</td>
            </tr>
        </table>
    </div>

</body>

</html>