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
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                            <p><?= session()->getFlashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    if (session()->getFlashdata('error')) {
                    ?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Gagal!</h5>
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
                    <form action="<?= base_url('backoffice/' . $page . '/save'); ?>" method="post">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">

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
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button class="btn btn-default mr-3" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-success" id="saveButton" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>