<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('backend/css/adminlte.min.css?v=3.2.0') }}">
    <style>
        .header,
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }

        .header {
            top: 0px;
        }

        .content {
            padding-top: 150px;
        }

        .footer {
            bottom: 0px;
        }

        .pagenum:before {
            content: counter(page);
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        table {
            width: 100%;
        }

        span.kop {
            font-size: 24pt;
        }

        span.subheader {
            font-size: 13pt;
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

        .no-border {
            border-left: 1px solid rgb(255, 255, 255);
            border-bottom: 1px solid white;
        }

        #headd,
        th,
        td {
            padding: 0px;
        }

        #detailvisa,
        th,
        td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table border="0">
            <thead>
                <tr>
                    <th>
                        <img src="{{ asset('backend/img/logo.png') }}" alt="logo" width="120px"
                            style="border-radius: 50%;">
                    </th>
                    <th style="text-align: center;">
                        <span class="kop">PT RIZQUNA MEKKAH MADINAH</span> <br>
                        <span style="font-size: 10pt">
                            <img src="{{ asset('img/png/email.png') }}" alt="email" width="15px">
                            rizqunamekkahmadinahjkt@gmail.com
                            <img src="{{ asset('img/png/wa.png') }}" alt="email" width="15px"> 081999940934
                        </span> <br><br>
                        <span class="subheader">PPIU 02350009222460004 &nbsp;&nbsp; PIHK 02350009222460005</span>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="horizontal-rule red"></div>
        <div class="horizontal-rule black"></div>
    </div>

    <div class="content">
        <u>
            <h2 style="text-align: center">INVOICE</h2>
        </u>
        <table id="headd">
            <thead>
                <tr>
                    <th style="text-align: left" colspan="8">Customer</th>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>: <b><span id="namaagen">{{ $databooking->agent->nama_agent }} </span></b></td>
                    <td colspan="3" width="20%"></td>
                    <td colspan="2">Number</td>
                    <td>: <span id="noinvoice">{{ $databooking->visa_id }}</span></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">Invoice Date</td>
                    <td>: <span
                            id="tglinvoice">{{ \Carbon\Carbon::parse($databooking->tgl_payment_visa)->locale('id')->translatedFormat('d F Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">Payment Term</td>
                    <td>: <span id="metodebayar">Cash</span> / Transfer</td>
                </tr>
            </thead>
        </table>
        <br>
        <table border="1" style="width: 90%; border-collapse: collapse; border-spacing: 10px;" id="detailvisa">
            <thead class="text-center">
                <tr>
                    <th>Tanggal Keberangkatan</th>
                    <th>Jumlah Pax</th>
                    <th colspan="2">Harga / Pax</th>
                    <th colspan="2">Total</th>
                </tr>
            </thead>
            <tbody style="vertical-align: bottom">
                <tr>
                    <th class="text-center">
                        VISA <br>
                        {{ \Carbon\Carbon::parse($databooking->tgl_keberangkatan)->locale('id')->translatedFormat('d F Y') }}
                    </th>
                    <th class="text-center">{{ number_format($databooking->jumlah_pax, 0, ',', '.') }}</th>
                    <th style="border-right: 1px solid rgba(0, 0, 0, 0)">$</th>
                    <th class="text-right">{{ number_format($databooking->harga_pax, 0, ',', '.') }}</th>
                    <th style="border-right: 1px solid rgba(0, 0, 0, 0)">$</th>
                    <th class="text-right"> {{ number_format($databooking->total, 0, ',', '.') }} </th>
                </tr>
            </tbody>
            <tfoot id="myTfoot">
                <tr>
                    <th colspan="2" rowspan="3" class="no-border"></th>
                    <th colspan="2" class="text-center">Total</th>
                    <th style="text-align: left; border-right: 1px solid rgba(0, 0, 0, 0)">$</th>
                    <th style="text-align: right"><span
                            id="totalusd">{{ number_format($databooking->total, 0, ',', '.') }}</span></th>
                </tr>
                @php
                    $tglpay = [];
                    $konversi = [];
                    $deposits = [];
                    $counter = 1; // Initialize counter
                @endphp

                @foreach ($databooking->details as $pay)
                    @php
                        $tglpay[] =
                            "Deposit {$counter} " .
                            \Carbon\Carbon::parse($pay->tgl_payment_visa)->locale('id')->translatedFormat('d F Y');
                        $konversi[] =
                            $databooking->kurs->pilih_konversi == 'USD' ? '$' : $databooking->kurs->pilih_konversi; // Store konversi for each deposit
                        $deposits[] = number_format($pay->deposit, 0, ',', '.'); // Format each deposit individually
                        $counter++; // Increment counter
                    @endphp
                @endforeach

                <tr>
                    <th colspan="2" class="text-center">{!! implode('<br>', $tglpay) !!}</th> <!-- Deposit dates -->
                    <th class="text-left" style="border-right: 1px solid rgba(0, 0, 0, 0)">{!! implode('<br>', $konversi) !!}</th>
                    <!-- Each conversion type on a new line -->
                    <th class="text-right">{!! implode('<br>', $deposits) !!}</th> <!-- Each deposit amount on a new line -->
                </tr>
                @php
                    $totalDeposit = array_sum(array_column($databooking->details->toArray(), 'deposit'));
                    $sisadeposit = $databooking->kurs->hasil_konversi - $totalDeposit;
                @endphp

                <tr>
                    <th colspan="2" class="text-center">
                        {{ $databooking->status == 'DP' ? 'Piutang' : $databooking->status }}</th>
                    <th style="border-right: 1px solid rgba(0, 0, 0, 0)">
                        {{ $databooking->kurs->pilih_konversi == 'USD' ? '$' : $databooking->kurs->pilih_konversi }}
                    </th>
                    <th class="text-right">{{ number_format($sisadeposit, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        <p>
            <b>
                <i>*note : kurs mengikuti kurs BSI pada saat hari pembayaran</i> <br>
                * KURS BSI
                {{ \Carbon\Carbon::parse($databooking->kurs->created_at)->locale('id')->translatedFormat('d F Y') }}
                Rp. {{ $databooking->kurs->kurs_bsi }}</span> <br>
                * KURS RIYAL
                {{ \Carbon\Carbon::parse($databooking->kurs->created_at)->locale('id')->translatedFormat('d F Y') }}
                SAR {{ $databooking->kurs->kurs_riyal }}</span>
            </b>
        </p>
        <table>
            <tbody>
                <tr>
                    <td>
                        <table class="table table-bordered table-sm w-75 small bank">
                            <tbody>
                                <tr>
                                    <th>
                                        <u>Transfer ke : </u> <br>
                                        No. Rek <br>
                                        A/n <br>
                                        Bank
                                    </th>
                                    <th>
                                        <br>
                                        <span id="norek1">{{ $databank[0]->no_rek }}</span><br>
                                        {{ $databank[0]->keterangan }}<br>
                                        <span id="norekid1">{{ $databank[0]->rekening_id }}</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        No. Rek <br>
                                        A/n <br>
                                        Bank
                                    </th>
                                    <th>
                                        <span id="norek2">{{ $databank[1]->no_rek }}</span><br>
                                        {{ $databank[1]->keterangan }}<br>
                                        <span id="norekid2">{{ $databank[1]->rekening_id }}</span>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table style="text-align: center">
                            <tbody>
                                <tr>
                                    <td style="width: 10%"></td>
                                    <td style="width: 50%; text-align: center;">
                                        <span>Approve By</span> <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <span><b><u>Fatimah Az zahra</u></b></span> <br>
                                        <span>Finance</span>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="horizontal-rule black"></div>
        <div class="horizontal-rule red"></div>
        <table width="100%" style="font-size: 8pt;">
            <tr style="text-align: center">
                <td width="35%" valign="top">
                    <strong style="font-size: 10pt;">Makassar</strong><br>
                    Jl. Sirajuddin Rani No. 49 RT/RW 001/001<br>
                    Kel. Bonto Bontoa, Kec. Somba Upu, Kab. Gowa <br>
                    Sulawesi Selatan
                </td>
                <td width="20%" valign="top">
                    <strong style="font-size: 10pt;">Balikpapan</strong><br>
                    Jl. Syarifuddin Yoes No. 10<br>
                    Kota Balikpapan
                </td>
                <td width="45%" valign="top">
                    <strong style="font-size: 10pt;">Jakarta</strong><br>
                    Ruko Graha Aziz, Unit B JL. KH. Abdullah Syafei No.12,<br>
                    RT/RW 012/009 Kel. Bukit Duri, Kec. Tebet, Jakarta Selatan
                </td>
            </tr>
        </table>
    </div>
</body>


</html>
