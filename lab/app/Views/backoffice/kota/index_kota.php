<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('backoffice/' . $page . '/create'); ?>" class="btn btn-primary mb-3">Tambah Data Kota</a>
                        <table class="table table-bordered table-sm table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kota/City</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data as $key => $value) {
                                    // $data_user = ($value['id_user'] !== "" || $value['id_user'] !== null) ? $userModel->find(['id' => $value['id_user']]) : '';
                                    // $data_marketing = ($value['pic_marketing'] !== "" || $value['pic_marketing'] !== null) ? $marketingModel->find($value['pic_marketing']) : '';
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $value['nama_kota']; ?>/<?= $value['city']; ?></td>
                                        <td><?= $value['province']; ?></td>
                                        <td>
                                            <a href="<?= base_url('backoffice/kota/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="<?= base_url('backoffice/kota/delete/' . $value['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
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