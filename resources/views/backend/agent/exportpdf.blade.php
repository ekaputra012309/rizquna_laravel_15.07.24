<!DOCTYPE html>
<html>

<head>
    <title>Data Agents</title>
    <link rel="stylesheet" href="{{ asset('backend/css/adminlte.min.css?v=3.2.0') }}">
</head>

<body class="small">
    <p class="text-center font-weight-bold text-lg">Data Agents</p>
    <table class="table table-border w-100">
        <thead>
            <tr>
                <th>Nama Agent</th>
                <th>Alamat</th>
                <th>Contact Person</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $agent)
            <tr>
                <td>{{ $agent->nama_agent }}</td>
                <td>{{ $agent->alamat }}</td>
                <td>{{ $agent->contact_person }}</td>
                <td>{{ $agent->telepon }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>