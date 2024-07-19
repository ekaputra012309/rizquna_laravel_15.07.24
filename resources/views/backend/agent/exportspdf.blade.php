<!DOCTYPE html>
<html>

<head>
    <title>Agent Report</title>
    <link rel="stylesheet" href="{{ asset('backend/css/adminlte.min.css?v=3.2.0') }}">
    <style>
        table,
        td,
        th {
            padding: 5px;
        }
    </style>
</head>

<body>
    <p class="text-center font-weight-bold text-lg">Report Agents</p>
    <p class="text-center">Report dari {{ \Carbon\Carbon::parse($tgl_from)->locale('id')->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tgl_to)->locale('id')->translatedFormat('d F Y') }} </p>
    <table class="table-bordered w-100 text-sm">
        <thead class="text-center">
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
            @foreach ($bookings as $booking)
            <tr>
                <td>{{ $booking->agent->nama_agent }}</td>
                <td>{{ $booking->booking_id }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->tgl_booking)->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ number_format($booking->total_subtotal, 0, ',', '.') }}</td>
                <td>{{ $booking->status }}</td>
                <td>{{ $booking->user->name ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>