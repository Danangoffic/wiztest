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
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title; ?></h3>
                        </div>
                        <form action="<?= base_url('backoffice/dokter/update/' . $id); ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">

                                <?= csrf_field(); ?>
                                <input type="hidden" name="img_ttd_old" <?= $data_dokter['img_ttd']; ?>>
                                <div class="form-group row">
                                    <label class="col-md-4" for="nama">Nama</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control <?= ($validation->getError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" required autocomplete="off" placeholder="Nama Dokter" value="<?= $data_dokter['nama']; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="phone">No HP</label>
                                    <div class="col-md-8">
                                        <input type="number" inputmode="tel" placeholder="No HP" name="phone" id="phone" class="form-control <?= ($validation->getError('phone')) ? 'is-invalid' : ''; ?>" required value="<?= $data_dokter['phone']; ?>">
                                        <div class="inalid-feedback">
                                            <?= $validation->getError('phone'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="email">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" placeholder="Email" name="email_dokter" id="email_dokter" class="form-control <?= ($validation->getError('email')) ? 'is-invalid' : ""; ?>" required autocomplete="off" value="<?= $data_user['email']; ?>">
                                        <div class="inalid-feedback">
                                            <?= $validation->getError('email_dokter'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="password">Password</label>
                                    <div class="col-md-8">
                                        <input type="password" placeholder="Password" name="password_dokter" id="password_dokter" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="img_ttd" class="col-md-4">TTD</label>
                                    <div class="col-md-8">
                                        <input type="file" name="img_ttd" id="img_ttd" class="form-control" accept="image/*">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('img_ttd'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8 offset-md-4 mt-3">
                                        <img src="<?= base_url('assets/dokter/' . $data_dokter['img_ttd']); ?>" alt="" width="200" height="200">
                                        <input type="hidden" name="old_img_ttd" value="<?= $data_dokter['img_ttd']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">

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