<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header" id="headingOne">
                            <h5 class="card-title">Invoice : <b><?= $customers_home_service['invoice_number']; ?></b></h5>
                        </div>
                        <?php
                        $get_all_amount = array();
                        $ids_cust = array();
                        foreach ($customer_model as $key => $value) {
                            $ids_cust[] = $value['id'];
                        }
                        $data_pembayaran = $pembayaran_model->whereIn('id_customer', $ids_cust)->get()->getResultArray();
                        foreach ($data_pembayaran as $key => $pembayaran) {
                            $get_all_total[] = $pembayaran;
                        }

                        $sum_amount = array_sum($get_all_amount);
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Total</td>
                                            <td><?= $sum_amount; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Cara Pembayaran</td>
                                            <td>Bank Transfer</td>
                                        </tr>
                                        <tr>
                                            <td>Status Pembayaran</td>
                                            <td><?= $customers_home_service['status_pembayaran']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('backoffice/print/pdf_hs/' . $customers_home_service['id']); ?>" class="btn btn-primary btn-sm">Print Pdf</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Customer Home Service</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm table-condensed" id="data_cust">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl. Kunjungan</th>
                                        <th>Instansi</th>
                                        <th>Registrasi</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>TTL/JK</th>
                                        <th>PIC Marketing</th>
                                        <th>Status Bayar</th>
                                        <th>Status Hadir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($customer_model as $key => $value) {
                                        // $DetailInstansi = new Ins
                                        $dataInstansi = $instansiModel->find($value['instansi']);
                                        $dataMarketing = $marketingModel->find($value['id_marketing']);
                                        $status_bayar = $value['status_pembayaran'];
                                        if ($status_bayar == "pending" || $status_bayar == "refund") {
                                            $status_bayar = "<span class='badge bg-warning'>" . $status_bayar . "</span>";
                                        } elseif ($status_bayar == "expire" || $status_bayar == "failure" || $status_bayar == "cancel" || $status_bayar == "deny") {
                                            $status_bayar = "<span class='badge bg-danger'>" . $status_bayar . "</span>";
                                        } elseif ($status_bayar == "settlement" || $status_bayar == "success") {
                                            $status_bayar = "<span class='badge bg-success'>" . $status_bayar . "</span>";
                                        }
                                        $nama_marketing = $dataMarketing['nama_marketing'];
                                        $nama_instansi = $dataInstansi['nama'];
                                        $create_tgl_registrasi = strtotime($value['created_at']);
                                        $create_tgl_lahir = strtotime($value['tanggal_lahir']);
                                        $tgl_registrasi = date('d-m-Y', $create_tgl_registrasi);
                                        $tgl_lahir = date('d-m-Y', $create_tgl_lahir);
                                        $getStatus = db_connect()->table('status_hasil')->where('id', $value['kehadiran'])->get()->getFirstRow();
                                        // $detail_status_hadir = $status_hadir->find($value['kehadiran']);
                                        $status_hadir = ucwords($getStatus->nama_status);
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $value['tgl_kunjungan']; ?></td>
                                            <td nowrap><?= $nama_instansi; ?></td>
                                            <td><?= $tgl_registrasi; ?> / <?= $value['customer_unique']; ?></td>
                                            <td><?= $value['nik']; ?></td>
                                            <td><?= $value['nama']; ?></td>
                                            <td><?= $value['tempat_lahir'] . ', ' . $tgl_lahir . ' / ' . ucwords($value['jenis_kelamin']); ?></td>
                                            <td><?= $nama_marketing; ?></td>
                                            <td><?= $status_bayar; ?></td>
                                            <td><?= $status_hadir; ?></td>
                                            <td>
                                                <a href="<?= base_url('backoffice/layanan/printbarcode/' . base64_encode($value['id'])); ?>" class="btn btn-primary btn-sm">Barcode</a>
                                                <a href="<?= base_url('backoffice/peserta/edit/' . $value['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="<?= base_url('backoffice/peserta/hapus/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
                                                <?php
                                                if ($value['kehadiran'] == 22) {
                                                ?>
                                                    <a href="<?= base_url('backoffice/peserta/hadirkan_peserta/' . $value['id']); ?>" class="btn btn-primary btn-sm">Hadir</a>
                                                <?php
                                                }
                                                ?>
                                                <a href="<?= base_url('backoffice/peserta/reschedule/' . $value['id']); ?>" class="btn btn-info btn-sm disabled mt-2" id="reschedule">Reschedule</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(() => {
        $("#data_cust").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>