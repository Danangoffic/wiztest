<?= $this->extend('backoffice/template/layout'); ?>
<?php echo $this->section('content');

$kota_marketing = $kota_model->find($data_marketing['id_kota']);
$nama_kota = $kota_marketing['nama_kota'];
$afiliasi = db_connect()->table('afiliasi')->select()->where(['id_marketing' => $data_marketing['id']])->get()->getRowArray();
$kode_afiliasi = ($afiliasi['value']) ? $afiliasi['value'] : '';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">Nama Marketing</div>
                                        <div class="col-md-8"><?= $data_marketing['nama_marketing']; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">Kota Input</div>
                                        <div class="col-md-8"><?= $nama_kota; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">Kode Afiliasi</div>
                                        <div class="col-md-8"><?= $kode_afiliasi; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('marketing/edit/' . $data_marketing['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Customer Marketing</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Order</th>
                                        <th>Invoice</th>
                                        <th>Nama</th>
                                        <th>Paket Pemeriksaan</th>
                                        <th>Status Pembayaran</th>
                                        <th></th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $customers = $customer_model->where(['id_marketing' => $data_marketing['id']])->orderBy('id', 'DESC')->get()->getResultArray();
                                    foreach ($customers as $key => $value) {
                                        $id_marketing = $value['id'];
                                        $detail_kota_marketing = $kota_model->find($value['id_kota']);
                                        $nama_kota = $detail_kota_marketing['nama_kota'];
                                        $detail_customers = $customer_model->where(['id_marketing' => $id_marketing])->get()->getResultArray();
                                        $total_customers = count($detail_customers);
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $value['nama_marketing']; ?></td>
                                            <td><?= $nama_kota; ?></td>
                                            <td><?= $total_customers; ?></td>
                                            <td>
                                                <a href="<?= base_url('marketing/' . $id_marketing); ?>" class="btn btn-primary btn-sm">Detail</a>
                                                <a href="<?= base_url('marketing/edit/' . $id_marketing); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="<?= base_url('marketing/delete/' . $id_marketing); ?>" class="btn btn-danger btn-sm">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php
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
        $("table").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>