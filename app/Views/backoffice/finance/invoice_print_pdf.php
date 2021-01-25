<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://quicktest.id" />
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
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
    </style>
</head>

<body>
    <center><b><?= $title; ?></b></center>
    <section class="invoice">
        <table class="table table-bordered table-condensed table-sm" id="data_customer">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor Invoice</th>
                    <th>Instansi</th>
                    <th>ATTN</th>
                    <th>Total</th>
                    <th>Vat/PPh</th>
                    <th>Metode Bayar</th>
                    <th>Tanggal Bayar</th>
                    <th>Status Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                var_dump($data_customer);
                foreach ($data_customer as $key => $c) {
                    $nomor_invoice = $c['invoice_number'];
                    $detail_instansi = $instansi_model->find($c['instansi']);
                    $nama_instansi = $detail_instansi['nama'];

                    $detail_marketing = $marketing_model->find($c['id_marketing']);
                    $nama_marketing = $detail_marketing['nama_marketing'];

                    $detail_pembayaran = $pembayaran_model->where(['id_customer' => $c['id']])->get()->getRowArray();
                    $total_pembayaran = $detail_pembayaran['amount'];
                    $jenis_pembayaran = ucwords(str_replace("_", " ", $detail_pembayaran['jenis_pembayaran']));
                    $tgl_pembayaran = ($detail_pembayaran['created_at'] !== $detail_pembayaran['updated_at']) ? substr($detail_pembayaran['updated_at'], 0, 10) : '';
                    $status_pembayaran = $detail_pembayaran['status_pembayaran'];

                    $url_download_file_with_ttd = base_url('invoicement/' . $c['invoice_number']);
                    $url_download_file = base_url('invoicement/a/' . $c['invoice_number']);
                    // $data_user = ($value['id_user'] !== "" || $value['id_user'] !== null) ? $userModel->find(['id' => $value['id_user']]) : '';
                    // $data_marketing = ($value['pic_marketing'] !== "" || $value['pic_marketing'] !== null) ? $marketingModel->find($value['pic_marketing']) : '';
                ?>
                    <tr>
                        <td class="text-center align-middle"><?= $no++; ?></td>
                        <td class="text-center align-middle"><?= $c['tgl_kunjungan']; ?></td>
                        <td class="align-middle"><?= $nomor_invoice; ?></td>
                        <td class="align-middle"><?= $nama_instansi; ?></td>
                        <td class="align-middle"><?= $nama_marketing; ?></td>
                        <td class="align-middle"><?= $total_pembayaran; ?></td>
                        <td class="text-center align-middle">Vat</td>
                        <td class="align-middle"><?= $jenis_pembayaran; ?></td>
                        <td class="text-center align-middle"><?= $tgl_pembayaran; ?></td>
                        <td class="text-center align-middle"><?= $status_pembayaran; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>