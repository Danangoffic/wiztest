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
                    <form action="<?= base_url('backoffice/' . $page . '/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-heading"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-3" for="nama">Nama Lengkap</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" value="<?= (old('nama')) ? old('nama') : ''; ?>" id="nama" name="nama" required autocomplete="off" placeholder="Nama Lengkap">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="phone">Nomor HP</label>
                                    <div class="col-9">
                                        <input type="number" maxlength="13" class="form-control" value="<?= (old('phone')) ? old('phone') : ''; ?>" id="phone" name="phone" required autocomplete="off" placeholder="Nomor HP">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('phone'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="email">Email</label>
                                    <div class="col-9">
                                        <input type="email" class="form-control" value="<?= (old('email')) ? old('email') : ''; ?>" id="email" name="email" required autocomplete="off" placeholder="Email">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="password">Password</label>
                                    <div class="col-9">
                                        <input type="password" class="form-control" id="password" name="password" required autocomplete="off" placeholder="******">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="lokasi">Lokasi Penginputan</label>
                                    <div class="col-9">
                                        <select name="lokasi" id="lokasi" class="form-control" data-placeholder="Pilih Lokasi Penginputan">
                                            <option value=""></option>
                                            <?php
                                            foreach ($kota as $key => $value) {
                                                $isSelected = "";
                                                if (old('lokasi')) {
                                                    $isSelected = (old('lokasi') == $value['id']) ? 'selected' : '';
                                                }
                                                echo "<option value=\"{$value['id']}\" {$isSelected}>{$value['nama_kota']}</option>\n\t";
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('lokasi'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="level">Level</label>
                                    <div class="col-9">
                                        <select name="level" id="level" class="select2 form-control" data-placeholder="Pilih Level Users">
                                            <option value=""></option>
                                            <?php
                                            foreach ($level_user as $key => $value) {
                                                $isSelectedLevel = "";
                                                if (old('level')) {
                                                    $isSelectedLevel = (old('level') == $value['id']) ? "selected" : "";
                                                }
                                                echo "<option value=\"{$value['id']}\" {$isSelectedLevel}>{$value['level']}</option>\n\t";
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('level'); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <a class="btn btn-default mr-3" href="<?= base_url('backoffice/user'); ?>"><i class="fa fa-chevron-left"></i> Kembali</a>
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
<script>
$(document).ready(function(){
    $("select").select2({
            theme: 'bootstrap4',
            allowClear: true
        });
})
</script>
<?= $this->endSection(); ?>