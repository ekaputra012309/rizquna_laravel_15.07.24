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

        .horizontal-rule.black {
            border-top: 2px solid black;
        }

        #table-detail,
        #table-detail th,
        #table-detail td {
            border: 2px solid black;
        }

        #table-detail1,
        #table-detail1 th,
        #table-detail1 td {
            border: 2px solid black;
        }

        #table-detail1 th,
        #table-detail1 td {
            padding: 0.5rem;
        }
    </style>
</head>

<body>
    <div>
        <div class="text-center">
            <img src="{{ asset('backend/img/logo.png') }}" alt="logo" width="100px">
        </div>
        <table class="w-100">
            <tbody>
                <tr>
                    <th>Date</th>
                    <td>: 10/07/2024</td>
                    <td rowspan="6" style="vertical-align: text-top;">
                        <p class="text-xl text-right text-danger">Tetative Confirmation</p>
                    </td>
                </tr>
                <tr>
                    <th>To</th>
                    <td>: </td>
                </tr>
                <tr>
                    <th>Attn.</th>
                    <td>: </td>
                </tr>
                <tr>
                    <th>Fax</th>
                    <td>: </td>
                </tr>
                <tr>
                    <th>From</th>
                    <td>: Mamlakat Al-Rayah Company to organize trips</td>
                </tr>
                <tr>
                    <th>Fax</th>
                    <td>: </td>
                </tr>
            </tbody>
        </table>
        <div class="horizontal-rule black"></div>
        <p>
            Thank you for your interest on Mamlakat Al-Rayah Company to organize trips Co
        </p>
        <table class="w-100">
            <tbody>
                <tr>
                    <th>Res. NO</th>
                    <th>: 2221</th>
                    <th>Hotel Name</th>
                    <td>: Movenpick Hajar Mekkah</td>
                </tr>
                <tr>
                    <th>Arrival date</th>
                    <td>: 23/07/2024</td>
                    <th rowspan="2" style="vertical-align: text-top;">Depart. date</th>
                    <td rowspan="2" style="vertical-align: text-top;">: 27/07/2024</td>
                </tr>
                <tr>
                    <th>Guest Name</th>
                    <th>: Fairus Travel</th>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="text-center w-100" id="table-detail">
            <thead>
                <tr>
                    <th>QTY</th>
                    <th>Room Type</th>
                    <th>Room Rate</th>
                    <th>Meal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>4</td>
                    <td>QUAD</td>
                    <td>1.380</td>
                    <td>F.B</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>QUAD</td>
                    <td>1.380</td>
                    <td>F.B</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>QUAD</td>
                    <td>1.380</td>
                    <td>F.B</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>QUAD</td>
                    <td>1.380</td>
                    <td>F.B</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="text-left">
                    <td style="border-right-color: white;"></td>
                    <td colspan="3">
                        Net Accommodation Charge : SAR 26.800
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                </tr>
                <tr class="text-left">
                    <td style="border-right-color: white;"></td>
                    <td style="border-right-color: white;">
                        Total Dalam USD
                        <br>
                        Total Dalam IDR
                        <br>
                        <br>
                    </td>
                    <th style="border-right-color: white;">
                        $ 7.165
                        <br>
                        Rp 117.733.689
                        <br>
                        <br>
                    </th>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <br>
        <table class="w-100" id="table-detail1">
            <tbody>
                <tr>
                    <th>
                        Remarks &nbsp; &nbsp; :
                    </th>
                </tr>
                <tr>
                    <td>
                        * We hope that we have covered all your request waiting for your reply by
                        the option date otherwise the reservation will be released automically
                        without prior notice.
                    </td>
                </tr>
                <tr>
                    <td>
                        - Kurs mengikuti kurs BSI pada saat hari pembayaran <br>
                        - DP minimal 50% dari total tagihan <br>
                        - Pelunasan 2 minggu sebelum keberangkatan <br>
                        - Apabila Agent membatalkan setelah kamar terkonfirmasi, dan ada pinalty (denda) maka agent wajib <br>
                        membayar penalty (denda) tersebut.
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="w-75">
            <tbody>
                <tr>
                    <th>
                        <u>* Our Bank Acc :</u>
                    </th>
                </tr>
                <tr>
                    <td>
                        Account Name
                    </td>
                    <td>: </td>
                    <td>
                        Mamlaket Al Rayah For Organizing Tourist TourS
                    </td>
                </tr>
                <tr>
                    <td>
                        Bank Name
                    </td>
                    <td>: </td>
                    <td>
                        National Commercial Bank
                    </td>
                </tr>
                <tr>
                    <td>
                        Account
                    </td>
                    <td>: </td>
                    <td>
                        00365600000110
                    </td>
                </tr>
                <tr>
                    <td>
                        IBAN
                    </td>
                    <td>: </td>
                    <td>
                        SA14100000-00365600000110
                    </td>
                </tr>
                <tr>
                    <td>
                        Swift Code
                    </td>
                    <td>: </td>
                    <td>

                    </td>
                </tr>

                <tr>
                    <td>
                        Account Name
                    </td>
                    <td>: </td>
                    <td>
                        PT Mamlakat Al Raya
                    </td>
                </tr>
                <tr>
                    <td>
                        Bank Name
                    </td>
                    <td>: </td>
                    <td>
                        Mandiri (IDR)
                    </td>
                </tr>
                <tr>
                    <td>
                        Account
                    </td>
                    <td>: </td>
                    <td>
                        006-00-1299669-4
                    </td>
                </tr>

                <tr>
                    <td>
                        Account Name
                    </td>
                    <td>: </td>
                    <td>
                        PT Mamlakat Al Raya
                    </td>
                </tr>
                <tr>
                    <td>
                        Bank Name
                    </td>
                    <td>: </td>
                    <td>
                        Mandiri (USD)
                    </td>
                </tr>
                <tr>
                    <td>
                        Account
                    </td>
                    <td>: </td>
                    <td>
                        006-00-1299674-4
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="horizontal-rule black"></div>
        <p class="text-center">
            Kingdom Of Saudi Arabia Makkah, KSA - South Azizyah <br>
            Abdullah Khayat Street, Next To Omar Ibn El Khattab Mosque <br>
            Ruko Graha Aziz, unit B. Jl.KH.Abdullah Syafei No.12, RT/RW 012/009, Kel.Bukit Duri, Kec.Tebet, Jakarta Selatan
        </p>
    </div>
</body>

</html>