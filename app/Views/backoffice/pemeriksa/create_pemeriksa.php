<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
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
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title; ?></h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('backoffice/' . $page . '/save'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="form-group row">
                                    <label class="col-md-4" for="nama">Nama <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="nama" id="nama" class="form-control" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="phone">No HP</label>
                                    <div class="col-md-8">
                                        <input type="tel" mode="tel" name="phone" id="phone" class="form-control">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('phone'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="email">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" mode="email" name="email" id="email" class="form-control">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group float-right">
                                    <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-success ml-2" id="saveButton" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </form>
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