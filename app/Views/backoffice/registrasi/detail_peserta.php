<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">

        <!-- filtering box -->
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">Invoice No : <strong><?= $data_customer->invoice_number; ?></strong></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Total: </strong></td>
                                        <td id="total_payment"><?= 'Rp ' . number_format(intval($detail_payment->gross_amount), 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $va_numbers = $detail_payment->va_numbers[0];
                                        $bank = $va_numbers->bank;
                                        $va = $va_numbers->va_number;
                                        $payment_type = ucwords(str_replace('_', ' ', $detail_payment->payment_type));
                                        $transaction_status = ucwords($detail_payment->transaction_status);
                                        ?>
                                        <td><strong>Virtual Account Number:</strong></td>
                                        <td id="va_number"><?= $va; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Cara Bayar:</strong></td>
                                        <td id="payment_method"><?= $payment_type; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pembayaran:</strong></td>
                                        <td id="status_payment"><strong><?= $transaction_status; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('backoffice/print/pdf/' . $data_customer->id); ?>" class="btn btn-primary btn-sm">Print Pdf</a>
                    <a href="<?= base_url('backoffice/peserta/hadir/' . $data_customer->id); ?>" class="btn btn-primary btn-sm">Hadir</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading">Data Peserta</h5>
                    </div>
                    <div class="card-body">
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
                                    <td><?= $transaction_status; ?></td>
                                    <td><?= ($data_customer->kehadiran == 0 || $data_customer->kehadiran == "0") ? "Belum Hadir" : "Hadir"; ?></td>
                                    <td width="10%">
                                        <a href="<?= base_url('backoffice/layanan/printbarcode/' . $data_customer->id); ?>" class="btn btn-primary btn-sm mt-2" id="print_barcode">Barcode</a>
                                        <a href="<?= base_url('backoffice/layanan/printbarcode/' . $data_customer->id); ?>" class="btn btn-primary btn-sm mt-2" id="edit">Edit</a>
                                        <a href="<?= base_url('backoffice/peserta/hapus/' . $data_customer->id); ?>" class="btn btn-danger btn-sm mt-2" id="hapus">Hapus</a>
                                        <a href="<?= base_url('backoffice/peserta/hadir/' . $data_customer->id); ?>" class="btn btn-primary btn-sm mt-2" id="hadir">Hadir</a>
                                        <a href="<?= base_url('backoffice/peserta/reschedule/' . $data_customer->id); ?>" class="btn btn-info btn-sm disabled mt-2" id="reschedule">Reschedule</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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