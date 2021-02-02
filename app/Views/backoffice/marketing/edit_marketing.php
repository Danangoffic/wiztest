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
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                            <p><?= session()->getFlashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    if (session()->getFlashdata('error')) {
                    ?>
                        <div class="alert alert-warning alert-dismissible">
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
                <div class="col-sm-6">
                    <form action="/marketing/update/<?= $id; ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_marketing" value="<?= $id; ?>">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-4" for="nama_marketing">Nama</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="nama_marketing" name="nama_marketing" required autocomplete="off" placeholder="Nama Marketing" value="<?= $data_marketing['nama_marketing']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="kota">Kota</label>
                                    <div class="col-md-8">
                                        <select name="kota" id="kota" required class="form-control" data-placeholder="Pilih Asal kota marketing">
                                            <option value=""></option>
                                            <?php
                                            $data_kota = $kota->findAll();
                                            foreach ($data_kota as $key => $k) {
                                                $selected = ($data_marketing['id_kota'] == $k['id']) ? "selected" : "";
                                            ?>
                                                <option value="<?= $k['id']; ?>" label="<?= $k['nama_kota']; ?>" <?= $selected; ?>><?= $k['nama_kota']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="">Afiliasi Home Service</label>
                                    <div class="col-md-8">
                                        <label for="afiliasi_hs">
                                            <input type="checkbox" name="afiliasi_hs" id="afiliasi_hs" value="yes" <?= ($data_marketing['is_afiliated_hs'] == "yes") ? "checked" : ''; ?>> Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="">Afiliasi Rujukan</label>
                                    <div class="col-md-8">
                                        <label for="afiliasi_rujukan">
                                            <input type="checkbox" name="afiliasi_rujukan" id="afiliasi_rujukan" value="yes" <?= ($data_marketing['is_afiliated_rujukan'] == "yes") ? "checked" : ''; ?>> Yes
                                        </label>
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