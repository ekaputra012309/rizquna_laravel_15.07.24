<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('backend/css/adminlte.min.css?v=3.2.0') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
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

        .no-border {
            border-left: 1px solid white;
            border-bottom: 1px solid white;
        }

        .bank>tbody>tr>th {
            border: 1px solid black;
        }

        table.detail,
        th,
        td {
            padding: 2px;
        }

        @media print {
            @page {
                size: auto;
                /* auto is the default value, which adjusts page size based on content */
                margin: 0.15in 0.5in;

                /* Remove default margin */
                /* To exclude headers and footers, set display: none */
                header,
                footer {
                    display: none;
                }
            }
        }
    </style>
</head>

<body>
    <div>
        <table border="0">
            <thead>
                <tr>
                    <th>
                        <img src="{{ asset('backend/img/logo.png') }}" alt="logo" width="120px" style="border-radius: 50%;">
                    </th>
                    <th style="text-align: center;">
                        <span class="header">PT RIZQUNA MEKKAH MADINAH</span> <br>
                        <span class="subheader">IZIN : 02350009222460004</span> <br>
                        <span style="font-size: 11pt">Ruko Graha Aziz, Unit B. Jl.KH. Abdullah Syafei No. 12, RT/TW
                            012/009, <br>Kel.Bukit
                            Duri,
                            Kec.Tebet Jakarta Selatan</span> <br>
                        <span style="font-size: 10pt">Email rizqunamekkahmadinahjkt@gmail.com , Whatsapp 081999940934</span>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="horizontal-rule red"></div>
        <div class="horizontal-rule black"></div>

        <table style="border-collapse: collapse" border="0">
            <thead>
                <tr>
                    <th style="text-align: left" colspan="8">Customer</th>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>: <b><span id="namaagen">{{$databooking->agent->nama_agent}}</span></b></td>
                    <td colspan="3" width="20%"></td>
                    <td colspan="2">Number</td>
                    <td>: <span id="noinvoice">{{$databooking->booking_id}}</span></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">Invoice Date</td>
                    <td>: <span id="tglinvoice">{{ \Carbon\Carbon::parse($databooking->tgl_booking)->locale('id')->translatedFormat('d F Y') }}</span></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">Payment Term</td>
                    <td>: <span id="metodebayar">Cash</span> / Transfer</td>
                </tr>
                <tr>
                    <td>Nama Hotel</td>
                    <td>: <b><span id="namahotel">{{$databooking->hotel->nama_hotel}}</span></b></td>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td>Check In</td>
                    <td>: <span id="checkin">{{ \Carbon\Carbon::parse($databooking->check_in)->locale('id')->translatedFormat('d F Y') }}</span></td>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td>Check Out</td>
                    <td>: <span id="checkout">{{ \Carbon\Carbon::parse($databooking->check_out)->locale('id')->translatedFormat('d F Y') }}</span></td>
                    <td colspan="6"></td>
                </tr>
            </thead>
        </table>
        <br>
        <table border="1" class="detail" style="width: 90%;">
            <thead style="text-align: center;">
                <tr>
                    <th>Room Type</th>
                    <th>Room Quantity</th>
                    <th>Durasi (N)</th>
                    <th colspan="2">Room Rate</th>
                    <th colspan="2">Ammount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($databooking->details as $detail)
                <tr>
                    <td class="text-center">{{ $detail->room->keterangan }}</td>
                    <td class="text-center">{{ $detail->qty }}</td>
                    <td class="text-center">{{ $detail->malam }}</td>
                    <td>{{ $databooking->mata_uang }}</td>
                    <td class="text-right">{{ number_format($detail->tarif, 0, ',', '.') }}</td>
                    <td>{{ $databooking->mata_uang }}</td>
                    <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center"><span id="sumqty">{{$totalQty}}</span></th>
                    <th colspan="3" class="text-center">Sub Total</th>
                    <th class="text-left">{{$databooking->mata_uang}}</th>
                    <th class="text-right"><span id="sumamount">{{ number_format($totalSubtotal, 0, ',', '.')}}</span><input type="hidden" id="sumamount1">
                    </th>
                </tr>
                <tr>
                    <th colspan="2" rowspan="4" class="no-border"></th>
                    <th colspan="3" class="text-center">Total dalam USD</th>
                    <th colspan="2" style="text-align: right">$ {{number_format($totalUsd, 0, ',', '.')}}</th>
                </tr>
                <tr>
                    <th colspan="3" class="text-center">Total dalam IDR</th>
                    <th colspan="2" style="text-align: right">{{number_format($totalIdr, 0, ',', '.')}}</th>
                </tr>
                @php
                $tglpay = [];
                $konversi = [];
                $deposits = [];
                $counter = 1; // Initialize counter
                @endphp

                @foreach ($datapayment->detailpay as $pay)
                @php
                $tglpay[] = "Deposit {$counter} " . \Carbon\Carbon::parse($pay->tgl_payment)->locale('id')->translatedFormat('d F Y');
                $konversi[] = $datapayment->pilih_konversi; // Store konversi for each deposit
                $deposits[] = number_format($pay->deposit, 0, ',', '.'); // Format each deposit individually
                $counter++; // Increment counter
                @endphp
                @endforeach

                <tr>
                    <th colspan="3" class="text-center">{!! implode('<br>', $tglpay) !!}</th> <!-- Deposit dates -->
                    <th class="text-left" style="border-right: 1px solid rgba(0, 0, 0, 0)">{!! implode('<br>', $konversi) !!}</th> <!-- Each conversion type on a new line -->
                    <th class="text-right">{!! implode('<br>', $deposits) !!}</th> <!-- Each deposit amount on a new line -->
                </tr>
                @php
                $totalDeposit = array_sum(array_column($datapayment->detailpay->toArray(), 'deposit'));
                $sisadeposit = $datapayment->hasil_konversi - $totalDeposit;
                @endphp

                <tr>
                    <th colspan="3" class="text-center">{{$databooking->status == 'DP' ? 'Piutang' : $databooking->status}}</th>
                    <th style="border-right: 1px solid rgba(0, 0, 0, 0)">{{$datapayment->pilih_konversi}}</th>
                    <th class="text-right">{{ number_format($sisadeposit, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        <p>
            <b>
                <u>*Syarat & Ketentuan</u> <br>
                - Kurs mengikuti kurs BSI pada saat hari pembayaran <br>
                - DP minimal 50% dari total tagihan <br>
                - Pelunasan 2 minggu sebelum keberangkatan <br>
                - Apabila Agent membatalkan setelah kamar terkonfirmasi, dan ada pinalty (denda) maka <br>
                agent wajib membayar pinalty (denda) tersebut
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
                                        <span id="norekid1">{{$databank[0]->rekening_id}}</span>
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
                                        <span id="norekid2">{{$databank[1]->rekening_id}}</span>
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
</body>

</html>