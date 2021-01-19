<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (session()->getFlashdata('success')) {
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fa fa-check"></i> Sukses!</h5>
                            <p><?= session()->getFlashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    if (session()->getFlashdata('error')) {
                    ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fa fa-close"></i> Gagal!</h5>
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
                <div class="col-md-12">
                    <!-- filtering box -->
                    <div class="card card-primary ">
                        <div class="card-header" id="headingOne">
                            <h5 class="card-title">Pengaturan Biaya</h5>
                        </div>
                        <form action="<?= base_url('backoffice/settings/update_biaya'); ?>" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <?php
                                        foreach ($jenis_layanan_test as $key => $value) {
                                            $detail_test = $test_model->find($value['id_test']);
                                            $detail_layanan = $layanan_model->find($value['id_layanan']);
                                            $nama_test = $detail_test['nama_test'];
                                            $nama_layanan = $detail_layanan['nama_layanan'];
                                            $biaya = $value['biaya'];
                                        ?>
                                            <div class="col-md-3 col-sm-6">
                                                <input type="hidden" name="id[]" value="<?= $value['id']; ?>">
                                                <label for="biaya" class="col-form-label"><?= $nama_test . "({$nama_layanan})"; ?></label>
                                                <input type="number" class="form-control" id="biaya" name="biaya<?= $value['id']; ?>" value="<?= $biaya; ?>" min="0">
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="conteiner-fluid">
            <div class="row">
                <?php
                $no = 1;
                foreach ($jenis_layanan_test as $key => $LT) {
                    $detail_test = $test_model->find($LT['id_test']);
                    $detail_layanan = $layanan_model->find($LT['id_layanan']);
                    $nama_test = $detail_test['nama_test'];
                    $nama_layanan = $detail_layanan['nama_layanan'];
                ?>
                    <div class="col-md-3">
                        <form action="<?= base_url('backoffice/settings/update_kuota/' . $LT['id']); ?>" method="post">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Kuota <?= $nama_test . "({$nama_layanan})"; ?></h5>
                                </div>
                                <div class="card-body">

                                    <?php
                                    $each_kuota = $kuota_model->where(['jenis_test_layanan' => $LT['id']])->get()->getResultArray();
                                    // echo db_connect()->showLastQuery();
                                    foreach ($each_kuota as $key => $value) {
                                    ?>
                                        <div class="form-group row">
                                            <label for="" class="col-md-4 col-form-label"><?= $value['jam']; ?></label>
                                            <div class="col-md-8">
                                                <input type="hidden" name="id[]" value="<?= $value['id']; ?>">
                                                <input type="number" name="kuota<?php $value['id']; ?>" id="kuota<?= $no++ ?>" class="form-control" value="<?= $value['kuota']; ?>">
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
</div>


<?= $this->endSection(); ?>