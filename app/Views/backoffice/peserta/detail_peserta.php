<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">

        <!-- filtering box -->
        <div id="accordion">
            <?php
            if ($session->getFlashdata('success')) {
            ?>
                <div class="alert alert-success fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php
            }
            if ($session->getFlashdata('error')) {
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
                    <a href="/api/print_invoice/no-ttd/<?= $data_customer->invoice_number; ?>" class="btn btn-primary btn-sm">Print Pdf</a>
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
                                        $kehadiran = $data_customer->kehadiran;
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
                                            <?php
                                            if ($kehadiran == 23) :
                                            ?>
                                                <a href="/backoffice/print/barcode/<?= base64_encode($data_customer->id); ?>" class="btn btn-primary btn-sm m-2" id="print_barcode">Barcode</a>
                                            <?php
                                            endif;
                                            ?>
                                            <a href="<?= base_url('backoffice/peserta/edit/' . $data_customer->id); ?>" class="btn btn-primary btn-sm m-2" id="edit">Edit</a>
                                            <a href="<?= base_url('backoffice/peserta/hapus/' . $data_customer->id); ?>" class="btn btn-danger btn-sm m-2" id="hapus">Hapus</a>
                                            <?php
                                            if ($data_customer->kehadiran == 22) {
                                            ?>


                                                <a href="<?= base_url('backoffice/peserta/reschedule/' . $data_customer->id); ?>" class="btn btn-info btn-sm disabled m-2" id="reschedule">Reschedule</a>
                                                <?php
                                                if (lcfirst($transactionStatus) == "settlement" || lcfirst($transactionStatus) == "invoice" || lcfirst($transactionStatus) == "lunas") {
                                                ?>
                                                    <a href="<?= base_url('backoffice/peserta/hadirkan_peserta/' . $data_customer->id); ?>" class="btn btn-primary btn-sm">Hadir</a>
                                            <?php
                                                }
                                            }
                                            ?>
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