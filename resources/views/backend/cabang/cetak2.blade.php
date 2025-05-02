@php
    $idFormatted = str_pad($cicilan->id, 3, '0', STR_PAD_LEFT); // Pad ID to 3 digits
    $monthCode = chr(64 + \Carbon\Carbon::parse($cicilan->created_at)->format('n')); // A=Jan, B=Feb, ..., D=Apr
    $yearShort = \Carbon\Carbon::parse($cicilan->created_at)->format('y'); // '25'
    $noKwitansi = "{$idFormatted}/{$monthCode}{$yearShort}/CLN";
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.print();
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
        }

        span.header {
            font-size: 24pt;
        }

        span.subheader {
            font-size: 16pt;
        }

        .horizontal-rule {
            background-color: transparent;
            margin: 5px 0;
        }

        .horizontal-rule.black {
            border-top: 4px solid black;
        }

        .horizontal-rule.red {
            border-top: 4px solid #fdd911;
        }

        .kwitansi-title {
        font-size: 18pt;
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        text-decoration: underline;
        }

        .content {
        margin-top: 30px;
        }

        .content table {
        width: 100%;
        }

        .content td {
        padding: 5px;
        }

        .terbilang {
        font-style: italic;
        margin-top: 10px;
        }

        .signature-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .ttd {
            text-align: center;
            width: 30%;
        }

        .footer {
            width: 70%;
            font-size: 10pt;
            line-height: 1.5;
        }


        @media print {
            @page {
                size: auto;
                margin: 0.15in 0.5in;
                header,
                footer {
                    display: none;
                }
            }
        }
    </style>
</head>

<body>
    <div style="font-size: 11pt">
        <table border="0">
            <thead>
                <tr>
                    <th>
                    <img src="{{ asset('img/png/logo.png') }}" alt="logo" width="120px"
                    style="border-radius: 50%;">
                    </th>
                    <th>
                        <span class="header">PT RIZQUNA MEKKAH MADINAH</span> <br>
                        <span class="subheader">IZIN : 02350009222460004</span> <br>
                        <span style="font-size: 11pt">Ruko Graha Aziz, Unit B. Jl.KH. Abdullah Syafei No. 12, RT/TW 012/009, <br>Kel.Bukit Duri, Kec.Tebet Jakarta Selatan</span> <br>
                        <span style="font-size: 10pt"><img src="{{ asset('img/png/email.png') }}"
                                alt="email" width="15px"> rizqunamekkahmadinahjkt@gmail.com , <img
                                src="{{ asset('img/png/wa.png') }}" alt="email" width="15px">
                            081999940934</span>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="horizontal-rule red"></div>
        <div class="horizontal-rule black"></div>

        <div class="kwitansi-title">KWITANSI PEMBAYARAN</div>

        <div class="content">
            <table style="border-collapse: collapse" border="0">
                <thead>
                    <tr>
                    <td>Sudah terima dari</td>
                    <td>: <b>{{ $cicilan->jamaah->nama }}</b></td>
                    <td colspan="5"></td>
                    <td>No. Kwitansi</td>
                    <td>: {{ $noKwitansi }}</td>
                    </tr>
                    <tr>
                    <td>Uang sejumlah</td>
                    <td>: <b>Rp {{ number_format($cicilan->deposit, 0, ',', '.') }}</b></td>
                    </tr>
                    <tr>
                    <td>Terbilang</td>
                    <td colspan="8">: <i>{{ ucwords(terbilang($cicilan->deposit)) }} rupiah</i></td>
                    </tr>
                    <tr>
                    <td>Tanggal Pembayaran</td>
                    <td>: {{ \Carbon\Carbon::parse($cicilan->created_at)->translatedFormat('d F Y') }}</td>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="signature-footer">
            <div class="footer">
                <strong>Catatan:</strong> Simpan kwitansi ini sebagai bukti pembayaran yang sah. <br>
                DP bersifat tidak dapat dikembalikan kecuali sesuai dengan kebijakan yang berlaku.
            </div>

            <div class="ttd">
                <div>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <br>
                <div>Hormat Kami,</div>
                <img src="{{ asset('img/png/logo.png') }}" alt="logo" width="120px"
                    style="border-radius: 50%;">
                <div><strong><u>{{ $cicilan->user->name }}</u></strong></div>
                <div>Finance</div>
            </div>
        </div>

    </div>
</body>

</html>
