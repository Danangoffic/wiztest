<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= $this->include('backoffice/template/content-header'); ?>
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
                                    <label class="col-3" for="id_kota">Kota</label>
                                    <div class="col-9">
                                        <select name="id_kota" id="id_kota" class="form-control">
                                            <?php
                                            foreach ($kota as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama_kota']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_kota'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="url_kop">Url Kop</label>
                                    <div class="col-9">
                                        <input type="url" placeholder="Url Kop" name="url_kop" id="url_kop" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
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