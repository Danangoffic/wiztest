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
                        <a href="<?= base_url('backoffice/dokter/create'); ?>" class="btn btn-primary mb-3">Tambah Dokter</a>
                        <table class="table table-bordered table-sm table-condensed" id="data_faskes">
                            <thead>
                                <tr class="text-center">
                                    <th width="2%">No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Email</th>
                                    <th width="35%">TTD</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data as $key => $value) {
                                    $user_dokter = $user->find($value['id_user']);
                                    $email = $user_dokter['email'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $value['nama']; ?></td>
                                        <td><?= $value['phone']; ?></td>
                                        <td><?= $email; ?></td>
                                        <td>
                                            <img src="<?= $value['qrcode_ttd']; ?>" alt="">
                                        </td>
                                        <td>
                                            <a href="<?= base_url('backoffice/dokter/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                            <a href="<?= base_url('backoffice/dokter/delete/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
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