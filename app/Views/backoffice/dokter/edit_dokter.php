<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-12">
                <?php
                if (session()->getFlashdata('success')) {
                ?>
                    <div class="alert alert-success">
                        <p><?= session()->getFlashdata('success'); ?></p>
                    </div>
                <?php
                }
                if (session()->getFlashdata('error')) {
                ?>
                    <div class="alert alert-warning">
                        <p><?= session()->getFlashdata('error'); ?></p>
                    </div>
                <?php
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('backoffice/dokter/update/' . $id); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="img_ttd_old" <?= $data_dokter['img_ttd']; ?>>
                            <div class="form-group row">
                                <label class="col-3" for="nama">Nama</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nama" name="nama" required autocomplete="off" placeholder="Nama Dokter" value="<?= $data_dokter['nama']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="phone">No HP</label>
                                <div class="col-9">
                                    <input type="tel|number" placeholder="No HP" name="phone" id="phone" class="form-control" required value="<?= $data_dokter['phone']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="email">Email</label>
                                <div class="col-9">
                                    <input type="email" mode="email" placeholder="Email" name="email" id="email" class="form-control" required autocomplete="off" value="<?= $data_user['email']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="password">Password</label>
                                <div class="col-9">
                                    <input type="password" mode="password" placeholder="Password" name="password" id="password" class="form-control" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="img_ttd" class="col-3">TTD</label>
                                <div class="col-9">
                                    <input type="file" name="img_ttd" id="img_ttd" class="form-control" accept="image/*">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('img_ttd'); ?>
                                    </div>
                                </div>
                                <div class="col-9 offset-md-3">
                                    <img src="<?= base_url('assets/dokter/' . $data_dokter['img_ttd']); ?>" alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                <button class="btn btn-success" id="saveButton" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
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