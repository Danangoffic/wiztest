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
        <div class="contaier-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <form action="<?= base_url('backoffice/' . $page . '/update/' . $id); ?>" method="post">
                            <div class="card-body">

                                <?= csrf_field(); ?>
                                <input type="hidden" name="id_petugas" value="<?= $id; ?>">
                                <div class="form-group row">
                                    <label class="col-3" for="nama">Nama <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" name="nama" id="nama" class="form-control" required value="<?= $data['nama']; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="phone">No HP</label>
                                    <div class="col-9">
                                        <input type="tel" mode="tel" name="phone" id="phone" class="form-control" value="<?= $data['phone']; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('phone'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="email">Email</label>
                                    <div class="col-9">
                                        <input type="email" mode="email" name="email" id="email" class="form-control" value="<?= $data['email']; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button class="btn btn-default mr-3" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-success" id="saveButton" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>