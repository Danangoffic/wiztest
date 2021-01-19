<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (session()->getFlashdata('success')) {
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                            <p><?= session()->getFlashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    if (session()->getFlashdata('error')) {
                    ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fa fa-close"></i> Gagal!</h5>
                            <p><?= session()->getFlashdata('error'); ?></p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content mt-0">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('backoffice/user/create_user'); ?>" class="btn btn-primary mb-3">Tambah <?= ucwords($page); ?></a>
                        <table class="table table-bordered table-sm table-condensed" id="data_faskes">
                            <thead>
                                <tr class="text-center">
                                    <th width="2%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>Lokasi</th>
                                    <th>User Level</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($users as $key => $value) {
                                    $detail_user = $user_detail->find($value['id']);
                                    $data_level = $user_level->find($value['user_level']);
                                    $level_user = $data_level['level'];
                                    $nama_user = $detail_user['nama'];
                                    $phone_user = $detail_user['phone'];
                                    $id_lokasi_user = $detail_user['id_lokasi'];
                                    $detail_lokasi = $lokasi_input->find($id_lokasi_user);
                                    $data_lokasi_user = $kota_user->find($detail_lokasi['id_kota']);
                                    $nama_lokasi = $data_lokasi_user['nama_kota'];
                                    $city_user = $data_lokasi_user['city'];
                                    $province_user = $data_lokasi_user['province'];
                                    $email = $value['email'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $nama_user; ?></td>
                                        <td><?= $email; ?></td>
                                        <td><?= $phone_user; ?></td>
                                        <td><?= $nama_lokasi; ?></td>
                                        <td><?= $level_user; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('backoffice/user/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                            <!-- <a href="<?= base_url('backoffice/user/delete/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a> -->
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
        $("#data_faskes").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>