<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('backoffice/instansi/create'); ?>" class="btn btn-primary mb-3">Tambah Instansi</a>
                            <table class="table table-bordered table-sm table-condensed" id="data_instansi">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Instansi</th>
                                        <th>Alamat</th>
                                        <th>Nama User</th>
                                        <th>TTL</th>
                                        <th>Nomor HP</th>
                                        <th>Email</th>
                                        <th>PIC Marketing</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    use App\Models\UserModel;
                                    use App\Models\MarketingModel;

                                    $no = 1;
                                    $userModel = new UserModel();
                                    $marketingModel = new MarketingModel();
                                    foreach ($data as $key => $value) {
                                        // $data_user = ($value['id_user'] !== "" || $value['id_user'] !== null) ? $userModel->find(['id' => $value['id_user']]) : '';
                                        // $data_marketing = ($value['pic_marketing'] !== "" || $value['pic_marketing'] !== null) ? $marketingModel->find($value['pic_marketing']) : '';
                                        // var_dump($value);
                                        // exit();
                                        if ($value['pic_marketing'] == null) {
                                            $nama_marketing = "";
                                        } else {
                                            $detail_marketing = $marketingModel->find($value['pic_marketing']);
                                            // dd(db_connect()->showLastQuery());
                                            $nama_marketing = ucwords($detail_marketing['nama_marketing']);
                                        }

                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $value['nama']; ?></td>
                                            <td><?= $value['alamat']; ?></td>
                                            <td><?= $value['nama_user'] ?></td>
                                            <td><?= $value['tempat_lahir'] . ', ' . $value['tgl_lahir']; ?></td>
                                            <td><?= $value['phone']; ?></td>
                                            <td><?= $value['email']; ?></td>
                                            <td><?= $nama_marketing; ?></td>
                                            <td>
                                                <a href="<?= base_url('backoffice/instansi/' . $value['id']); ?>" class="btn btn-primary btn-sm">Detail</a>
                                                <a href="<?= base_url('backoffice/instansi/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                                <a href="/backoffice/instansi/delete_instansi/<?= $value['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
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
        $("#data_instansi").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>