<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://quicktest.id" />
    <!-- <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>"> -->
    <title><?= $title; ?></title>
    <style>
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #444
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #444
        }

        .table tbody+tbody {
            border-top: 2px solid #444
        }

        .table .table {
            background-color: #fff
        }

        .table-sm td,
        .table-sm th {
            padding: .3rem
        }

        .table-bordered {
            border: 1px solid #444
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #444
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px
        }

        .text-center {
            text-align: center !important
        }

        .align-middle {
            vertical-align: middle !important
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -7.5px;
            margin-left: -7.5px;
        }

        .col-1,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-10,
        .col-11,
        .col-12,
        .col,
        .col-auto,
        .col-sm-1,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm,
        .col-sm-auto,
        .col-md-1,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md,
        .col-md-auto,
        .col-lg-1,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg,
        .col-lg-auto,
        .col-xl-1,
        .col-xl-2,
        .col-xl-3,
        .col-xl-4,
        .col-xl-5,
        .col-xl-6,
        .col-xl-7,
        .col-xl-8,
        .col-xl-9,
        .col-xl-10,
        .col-xl-11,
        .col-xl-12,
        .col-xl,
        .col-xl-auto {
            position: relative;
            width: 100%;
            padding-right: 7.5px;
            padding-left: 7.5px;
        }

        .col-md-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-md-12 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .invoice {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            position: relative;
        }

        .invoice-title {
            margin-top: 0;
        }

        .dark-mode .invoice {
            background-color: #343a40;
        }

        .invoice {
            border: 0;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .invoice-col {
            float: left;
            width: 33.3333333%;
        }
    </style>
</head>

<body>
    <center><b><?= $title; ?></b></center>
    <section class="invoice">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>No. Reg/ Reg. No</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir/DOB</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin/Sex</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Waktu Sampling</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Waktu Periksa</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Waktu Selesai</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>Instansi</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>No. Passport</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Kewarganegaraan</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Faskes</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Kota</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-sm" id="data_customer">
                    <thead>
                        <tr style="background-color: aquamarine;">
                            <th>PEMERIKSAAN/TEST</th>
                            <th>DALAM KISARAN RUKUAN/VALUE WITHIN RANGE</th>
                            <th>DILUAR KISARAN RUJUKAN/VALUE OUTSIDE RANGE</th>
                            <th>NILAI RUJUKAN/NORMAL RANGE</th>
                            <th>METODE/METHOD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5">Note:</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <p>- Negative Result do not rule out the possibility of SARS-COV-2 infection particularly in those who have been in contact with the virus, so it is still at risk of transmitting to others.</p>
                                <p>- Negative results can occur in antigen quantity conditions in specimens below the detection level of the device.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>Petugas Pemeriksa : </td>
                    </tr>
                    <tr>
                        <td><i>QRCODE RESULT</i></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>Petugas Pemeriksa : </td>
                    </tr>
                    <tr>
                        <td><i>Dokter Pemeriksa</i></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</body>

</html>