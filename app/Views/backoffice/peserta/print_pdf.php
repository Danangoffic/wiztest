<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <!-- <link media="all" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
    <!-- <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 100%;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 10px;
            text-align: justify;
        }

        .text-right {
            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style> -->
</head>

<body>
    <?php
    $jenis_kelamin = $data_customer['jenis_kelamin'];
    $prefix_nama = "";
    if ($jenis_kelamin == "pria") {
        $prefix_nama = "Bapak";
    } elseif ($jenis_kelamin == "wanita") {
        $prefix_nama = "Ibu";
    }
    $nama = $data_customer['nama'];
    $full_attn = $prefix_nama . " " . $nama;
    $invoice_number = $data_customer['invoice_number'];
    // $date
    ?>
    <header class="clearfix">
        <!-- <div id="logo">
            <img src="logo.png">
        </div> -->
        <h2 class="text-center"><u>INVOICE / OFFICIAL RECEIPT</u></h2>
        <div id="project" class="clearfix">
            <div>
                <b>Attn : <?= $full_attn; ?></b>
            </div>
        </div>
        <div id="company" class="clearfix">
            <div>Invoice: #<?= $data_customer['invoice_number']; ?></div>
            <div>Order Id: <?= $data_customer['customer_unique']; ?></div>
            <div>(602) 519-0450</div>
            <div><a href="mailto:company@example.com">company@example.com</a></div>
        </div>

    </header>
    <main>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="service">No</th>
                    <th class="desc">DESCRIPTION</th>
                    <th>Quantity</th>
                    <th>Unit Price(IDR)</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $status_peserta = $data_customer['status_peserta'];
                $is_hs = $data_customer['is_hs'];
                // echo "isHS: " . $is_hs;
                if ($is_hs == "yes") {
                    $id_hs = $data_customer['id_hs'];
                    $new_data_customer = $customer_model->where(['id_hs' => $id_hs])->groupBy("jenis_test")->get()->getResultArray();
                    if ($new_data_customer !== null) {
                        $no = 1;
                        foreach ($new_data_customer as $key => $cust) {
                            // echo $cust['id_hs'];
                            $jenis_test = $cust['jenis_test'];
                            $customer_in_same_test = $customer_model->total_customer_same_test_hs($id_hs, $jenis_test);
                            if ($customer_in_same_test !== null) {
                                $total_customer_same_test = $customer_in_same_test;
                            } else {
                                $total_customer_same_test = 1;
                            }

                            $detail_layanan_test = $layanan_test_model->find($cust['jenis_test']);
                            $detail_layanan = $layanan_model->find($detail_layanan_test['id_layanan']);
                            $detail_test = $test_model->find($detail_layanan_test['id_test']);
                            $nama_test = $detail_test['nama_test'];
                            $nama_layanan = $detail_layanan['nama_layanan'];

                            $biaya = $detail_layanan_test['biaya'];
                            $total_biaya = $biaya * $total_customer_same_test;
                            $new_biaya = number_format($biaya, 0, ',', '.');
                            $new_total_biaya = number_format($total_biaya, 0, ',', '.');
                            $test_date = date_create($cust['tgl_kunjungan']);
                            $new_test_date = date_format($test_date, 'd-m-Y');
                ?>
                            <tr>
                                <td class="service"><?= $no++; ?></td>
                                <td class="desc">
                                    <p>Pemeriksaan <?= $nama_test . " " . $nama_layanan; ?></p>
                                    <b>Test Date: <?= $new_test_date; ?></b>
                                </td>
                                <td class="qty"><?= $total_customer_same_test; ?></td>
                                <td class="unit"><?= 'Rp ' . $new_biaya; ?></td>
                                <td class="total"><?= 'Rp ' . $new_total_biaya; ?></td>
                            </tr>
                    <?php
                        }
                    }
                } elseif ($is_hs == "no") {
                    $cust = $data_customer;
                    $detail_layanan_test = $layanan_test_model->find($cust['jenis_test']);
                    $detail_layanan = $layanan_model->find($detail_layanan_test['id_layanan']);
                    $detail_test = $test_model->find($detail_layanan_test['id_test']);
                    $nama_test = $detail_test['nama_test'];
                    $nama_layanan = $detail_layanan['nama_layanan'];

                    $biaya = $detail_layanan_test['biaya'];
                    $total_biaya = $biaya;
                    $new_biaya = number_format($biaya, 0, ',', '.');
                    $new_total_biaya = number_format($total_biaya, 0, ',', '.');
                    $test_date = date_create($cust['tgl_kunjungan']);
                    $new_test_date = date_format($test_date, 'd-m-Y');
                    ?>
                    <tr>
                        <td class="service">1</td>
                        <td class="desc">
                            <p>Pemeriksaan <?= $nama_test . " " . $nama_layanan; ?></p>
                            <b>Test Date: <?= $new_test_date; ?></b>
                        </td>
                        <td class="qty">1</td>
                        <td class="unit"><?= 'Rp ' . $new_biaya; ?></td>
                        <td class="total"><?= 'Rp ' . $new_total_biaya; ?></td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="4" class="grand total text-right">Subtotal</td>
                    <td class="total">1000000</td>
                </tr>
                <tr>
                    <td colspan="4" class="grand total text-right">Total Amount</td>
                    <td>1000000</td>
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div>
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>