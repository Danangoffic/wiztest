<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Marketing</th>
                                        <th>Kota</th>
                                        <th>Total Customer(s)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data_marketing as $key => $value) {
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
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script>
    $(document).ready(() => {
        $("table").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>