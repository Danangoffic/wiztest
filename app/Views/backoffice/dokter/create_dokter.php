<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="conteint-header mb-0">
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
    <section class="content mt-3">
        <div class="row">
            <div class="col-md-6">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('backoffice/dokter/save'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="level_user" value="7">
                            <div class="form-group row">
                                <label class="col-md-4" for="nama">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="nama" name="nama" required autocomplete="off" placeholder="Nama Dokter">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="phone">No HP</label>
                                <div class="col-md-8">
                                    <input type="tel|number" placeholder="No HP" name="phone" id="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="email">Email</label>
                                <div class="col-md-8">
                                    <input type="email" mode="email" placeholder="Email" name="email" id="email" class="form-control" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4" for="password">Password</label>
                                <div class="col-md-8">
                                    <input type="password" mode="password" placeholder="Password" name="password" id="password" class="form-control" required autocomplete="off">
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
    </section>
</div>


<script>
    $(document).ready(() => {
        $("select").select2({
            theme: 'bootstrap4',
            allowClear: true
        });
    });
</script>
<?= $this->endSection(); ?>