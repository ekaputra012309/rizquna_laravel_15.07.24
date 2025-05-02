@php
    $idFormatted = str_pad($jamaah->id, 3, '0', STR_PAD_LEFT); // Pad ID to 3 digits
    $monthCode = chr(64 + \Carbon\Carbon::parse($jamaah->created_at)->format('n')); // A=Jan, B=Feb, ...
    $yearShort = \Carbon\Carbon::parse($jamaah->created_at)->format('y'); // '25'
    $noKwitansi = "{$idFormatted}/{$monthCode}{$yearShort}/KWT";
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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 40px;
            font-size: 11pt;
        }

        table {
            width: 100%;
        }

        span.header {
            font-size: 24pt;
        }

        span.subheader {
            font-size: 14pt;
        }

        .horizontal-rule {
            margin: 5px 0;
            margin-left: -40px;
            margin-right: -40px;
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

        .content td {
            padding: 5px;
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

        .footer-note {
            width: 70%;
            font-size: 10pt;
            line-height: 1.5;
        }

        footer {
            font-size: 8pt;
            /* border-top: 2px solid #000; */
            padding-top: 10px;
            margin-top: 40px;
            text-align: center;
        }

        .footer-addresses {
            display: flex;
            justify-content: space-between;
        }

        /* .footer-addresses div {
            width: 32%;
        } */

        @media print {
            @page {
                /* size: A4; */
                margin: 0.15in 0.5in;
            }

            html, body {
                height: 100%;
            }

            footer {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
            }

            .header-wrapper {
                text-align: center;
                margin-bottom: 10px;
            }

            .header-text {
                display: inline-block;
            }

        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <!-- Header -->
            <!-- Centered Header -->
            <div class="header-wrapper">
                <img src="{{ asset('img/png/logo.png') }}" alt="logo" width="120px" style="border-radius: 50%; margin-bottom: 10px;">
                <div class="header-text">
                    <span class="header">PT RIZQUNA MEKKAH MADINAH</span> <br>
                    <span style="font-size: 10pt">
                        <img src="{{ asset('img/png/email.png') }}" alt="email" width="15px"> rizqunamekkahmadinahjkt@gmail.com
                        <img src="{{ asset('img/png/wa.png') }}" alt="email" width="15px"> 081999940934
                    </span> <br><br>
                    <span class="subheader">PPIU 02350009222460004 &nbsp;&nbsp; PIHK 02350009222460005</span>
                </div>
            </div>


            <div class="horizontal-rule red"></div>
            <div class="horizontal-rule black"></div>

            <!-- Title -->
            <div class="kwitansi-title">KWITANSI PEMBAYARAN</div>

            <!-- Content -->
            <div class="content">
                <table style="border-collapse: collapse;" border="0">
                    <tr>
                        <td>Sudah terima dari</td>
                        <td>: <b>{{ $jamaah->nama }}</b></td>
                        <td colspan="5"></td>
                        <td>No. Kwitansi</td>
                        <td>: {{ $noKwitansi }}</td>
                    </tr>
                    <tr>
                        <td>Uang sejumlah</td>
                        <td>: <b>Rp {{ number_format($jamaah->dp, 0, ',', '.') }}</b></td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td colspan="8">: <i>{{ ucwords(terbilang($jamaah->dp)) }} rupiah</i></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pembayaran</td>
                        <td>: {{ \Carbon\Carbon::parse($jamaah->created_at)->translatedFormat('d F Y') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Signature -->
            <div class="signature-footer">
                <div class="footer-note">
                    <strong>Catatan:</strong> Simpan kwitansi ini sebagai bukti pembayaran yang sah. <br>
                    DP bersifat tidak dapat dikembalikan kecuali sesuai dengan kebijakan yang berlaku.
                </div>

                <div class="ttd">
                    <div>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div><br>
                    <div>Hormat Kami,</div>
                    <img src="{{ asset('img/png/logo.png') }}" alt="logo" width="120px" style="border-radius: 50%;"><br>
                    <div><strong><u>{{ auth()->user()->name }}</u></strong></div>
                    <div>Finance</div>
                </div>
            </div>
        </div>

        <!-- Footer Section (Bottom of Page) -->
        <footer>
            <div class="horizontal-rule black"></div>
            <div class="horizontal-rule red"></div>            
            <div class="footer-addresses">
                <div style="width: 35%;">
                    <span style="font-size: 16pt"><strong>Makassar</strong></span><br>
                    Jl. Sirajuddin Rani No. 49 RT/RW 001/001<br>
                    Kel. Bonto Bontoa, Kec. Tebet, Jakarta Selatan
                </div>
                <div style="width: 20%;">
                    <span style="font-size: 16pt"><strong>Balikpapan</strong></span><br>
                    Jl. Syarifuddin Yoes No. 10<br>
                    Kota Balikpapan
                </div>
                <div style="width: 45%;">
                    <span style="font-size: 16pt"><strong>Jakarta</strong></span><br>
                    Ruko Graha Aziz, Unit B 
                    JL. KH. Abdullah Syafei No.12,<br>
                    RT/RW 012/009 Kel. Bukit Duri,
                    Kec. Tebet, Jakarta Selatan
                </div>
            </div>
        </footer>

    </div>
</body>

</html>
