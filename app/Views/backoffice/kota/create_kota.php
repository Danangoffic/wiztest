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
                        <form action="<?= base_url('backoffice/' . $page . '/save'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group row">
                                <label class="col-3" for="nama_kota">Nama Kota</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nama_kota" name="nama_kota" required autocomplete="off" placeholder="Nama Kota">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_kota'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="city">City</label>
                                <div class="col-9">
                                    <input type="text" placeholder="City" name="city" id="city" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="province">Provinsi</label>
                                <div class="col-9">
                                    <input type="text" placeholder="Provinsi" name="province" id="province" class="form-control" required autocomplete="off">
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