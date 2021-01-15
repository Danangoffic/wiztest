<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0 pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (session()->getFlashdata('success')) {
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php
                    }
                    if (session()->getFlashdata('error')) {
                    ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Gagal</h5>
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('backoffice/' . $page . '/create'); ?>" class="btn btn-success mb-3">Tambah Data</a>
                            <table class="table table-bordered table-sm table-condensed">
                                <thead>
                                    <tr class="text-center">
                                        <th width="4%">No</th>
                                        <th width="75%">Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $key => $value) {
                                        $nama_kategori = $value['nama_kategori'];
                                        // $data_user = ($value['id_user'] !== "" || $value['id_user'] !== null) ? $userModel->find(['id' => $value['id_user']]) : '';
                                        // $data_marketing = ($value['pic_marketing'] !== "" || $value['pic_marketing'] !== null) ? $marketingModel->find($value['pic_marketing']) : '';
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $nama_kategori; ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('backoffice/' . $page . '/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                                <a href="<?= base_url('backoffice/' . $page . '/' . $value['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                                                <a href="<?= base_url('backoffice/' . $page . '/delete/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
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
        $(".table").DataTable({
            ordering: false,
            info: false
        });
    });
</script>
<?= $this->endSection(); ?>