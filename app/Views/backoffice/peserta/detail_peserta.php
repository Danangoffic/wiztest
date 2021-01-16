<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">

        <!-- filtering box -->
        <div id="accordion">
            <?php
            if (session()->getFlashdata('success')) {
            ?>
                <div class="alert alert-success fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php
            }
            if (session()->getFlashdata('error')) {
            ?>
                <div class="alert alert-warning fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php
            }
            ?>
            <div class="card card-primary">
                <div class="card-header" id="headingOne">
                    <h5 class="card-title mb-0">Invoice No : <strong><?= $data_customer->invoice_number; ?></strong></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Total: </strong></td>
                                        <?php
                                        $amt = "";
                                        $bank = "";
                                        $va = "";
                                        $paymentType = "";
                                        $transactionStatus = "";
                                        // echo $detail_payment->bank;
                                        // dd($detail_payment);
                                        if ($detail_payment) {
                                            if ($detail_payment->status_code != '404') {
                                                $payment_type = $detail_payment->payment_type;
                                                if ($payment_type == "bank_transfer" || $payment_type == "credit_card") {
                                                    if ($detail_payment->va_numbers[0]) {
                                                        $va_numbers = $detail_payment->va_numbers[0];
                                                        $bank = ($va_numbers->bank) ? $va_numbers->bank : null;
                                                        $va = ($va_numbers->va_number) ? $va_numbers->va_number : null;
                                                    }
                                                } elseif ($payment_type == "echannel") {
                                                    $va = "<p>Biller Code : " . $detail_payment->biller_code . "</p>";
                                                    $va .= "<p>Bill Key : " . $detail_payment->bill_key . "</p>";
                                                }
                                                if ($detail_payment->gross_amount) {
                                                    $amt = 'Rp ' . number_format(intval($detail_payment->gross_amount), 0, ',', '.');
                                                }

                                                if ($detail_payment->payment_type) {
                                                    $paymentType = ucwords(str_replace('_', ' ', $detail_payment->payment_type));
                                                }
                                                if ($detail_payment->transaction_status) {
                                                    $transactionStatus = ucwords($detail_payment->transaction_status);
                                                }
                                            }
                                        }
                                        ?>
                                        <td id="total_payment"><?= $amt; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Virtual Account Number:</strong></td>
                                        <td id="va_number"><?= $va; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Cara Bayar:</strong></td>
                                        <td id="payment_method"><?= $paymentType; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pembayaran:</strong></td>
                                        <td id="status_payment"><strong><?= $transactionStatus; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('backoffice/print/pdf/' . $data_customer->id); ?>" class="btn btn-primary btn-sm">Print Pdf</a>
                    <!-- <?= $data_customer->kehadiran; ?> -->
                    <?php
                    if ($data_customer->kehadiran == 0) {
                    ?>
                        <a href="<?= base_url('backoffice/peserta/hadirkan_peserta/' . $data_customer->id); ?>" class="btn btn-primary btn-sm">Hadir</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Peserta</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive mb-0">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>Registrasi</th>
                                        <th>Jadwal Kunjungan</th>
                                        <th>No Antrian</th>
                                        <th>Jenis Layanan</th>
                                        <th>Paket Pemeriksaan</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>
                                        <th>No HP</th>
                                        <th>Status Bayar</th>
                                        <th>Status Hadir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $jam_kunjungan = substr($data_customer->jam_kunjungan, 0, 5);
                                        $getStatus = $status_hadir->find($data_customer->kehadiran);
                                        $status_kehadiran = $getStatus['nama_status'];
                                        ?>
                                        <td><?= $data_customer->customer_unique; ?></td>
                                        <td><?= $data_customer->tgl_kunjungan . ', ' . $jam_kunjungan; ?></td>
                                        <td><?= $data_customer->no_antrian; ?></td>
                                        <td><?= $data_customer->nama_pemeriksaan; ?></td>
                                        <td><?= $data_customer->nama_test . '(' . $data_customer->nama_layanan . ')'; ?></td>
                                        <td><?= $data_customer->nama; ?></td>
                                        <td><?= $data_customer->jenis_kelamin; ?></td>
                                        <td><?= $data_customer->tanggal_lahir; ?></td>
                                        <td><?= $data_customer->phone; ?></td>
                                        <td><?= $transactionStatus; ?></td>
                                        <td><?= $status_kehadiran; ?></td>
                                        <td width="10%">
                                            <a href="<?= base_url('backoffice/layanan/printbarcode/' . base64_encode($data_customer->id)); ?>" class="btn btn-primary btn-sm mt-2" id="print_barcode">Barcode</a>
                                            <a href="<?= base_url('backoffice/peserta/edit/' . $data_customer->id); ?>" class="btn btn-primary btn-sm mt-2" id="edit">Edit</a>
                                            <a href="<?= base_url('backoffice/peserta/hapus/' . $data_customer->id); ?>" class="btn btn-danger btn-sm mt-2" id="hapus">Hapus</a>
                                            <?php
                                            if ($data_customer->kehadiran == 0) {
                                            ?>
                                                <a href="<?= base_url('backoffice/peserta/hadirkan_peserta/' . $data_customer->id); ?>" class="btn btn-primary btn-sm">Hadir</a>
                                            <?php
                                            }
                                            ?>
                                            <a href="<?= base_url('backoffice/peserta/reschedule/' . $data_customer->id); ?>" class="btn btn-info btn-sm disabled mt-2" id="reschedule">Reschedule</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script>
    $(document).ready(() => {
        // $("#data_customer").DataTable();
    });
</script>
<?= $this->endSection(); ?>