<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0 pb-0">
        <div class="container-fluid">
            <div class="row">

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('backoffice/' . $page . '/create_keluar_barang'); ?>" class="btn btn-primary mb-3">Barang Keluar</a>
                            <a href="<?= base_url('backoffice/' . $page . '/create_masuk_barang'); ?>" class="btn btn-primary mb-3">Barang Masuk</a>
                            <table class="table table-bordered table-sm table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Barang</th>
                                        <th>Status Peminjaman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $key => $value) {
                                        $id_status = $value['status_peminjaman'];
                                        // $detail_barang_pinjaman = $
                                        // $data_user = ($value['id_user'] !== "" || $value['id_user'] !== null) ? $userModel->find(['id' => $value['id_user']]) : '';
                                        // $data_marketing = ($value['pic_marketing'] !== "" || $value['pic_marketing'] !== null) ? $marketingModel->find($value['pic_marketing']) : '';
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $value['nama_peminjam']; ?></td>
                                            <td><?= $value['phone']; ?></td>
                                            <td><?= $value['email']; ?></td>
                                            <td>
                                                <a href="<?= base_url('backoffice/' . $page . '/detail/' . $value['id']); ?>" class="btn btn-primary btn-sm">Detail</a>
                                                <?php if ($id_status == 18) : ?>
                                                    <a href="<?= base_url('backoffice/' . $page . '/edit_to_masuk_barang/' . $value['id']); ?>" class="btn btn-success btn-sm">Barang Masuk</a>
                                                <?php endif; ?>
                                                <!-- <a href="<?= base_url('backoffice/' . $page . '/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                                <a href="<?= base_url('backoffice/' . $page . '/delete/' . $value['id']); ?>" class="btn btn-danger btn-sm">Delete</a> -->
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
        $("#data_customer").DataTable();
    });
</script>
<?= $this->endSection(); ?>