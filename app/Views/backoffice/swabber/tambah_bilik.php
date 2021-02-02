<?= $this->extend('backoffice/template/layout_swabber'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <?= $this->include('backoffice/template/content-header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="save_bilik" method="post">
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="card-title"><?= $title; ?></div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="swabber" class="label-control col-md-4">Swabber User</label>
                                        <div class="col-md-8">
                                            <select name="swabber" required id="swabber" class="select2 form-control" data-placeholder="Pilih user swabber pada bilik">
                                                <option value=""></option>
                                                <?php
                                                foreach ($data_user_swabber as $key => $swabber) {
                                                ?>
                                                    <option value="<?= $swabber['id']; ?>"><?= $swabber['email']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="nomor_bilik" class="label-control col-md-4">Bilik Ke</label>
                                        <div class="col-md-8">
                                            <select name="nomor_bilik" required id="nomor_bilik" class="form-control" data-placeholder="Pilih Nomor bilik">
                                                <option value=""></option>
                                                <?php
                                                for ($i = 1; $i < 9; $i++) {
                                                ?>
                                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jenis_test" class="label-control col-md-4">Jenis Test</label>
                                        <div class="col-md-8">
                                            <select name="jenis_test" required id="jenis_test" class="select2 form-control" data-placeholder="Pilih Jenis Test bilik">
                                                <option value=""></option>
                                                <?php
                                                foreach ($data_test as $key => $test) {
                                                    $id = $test['id'];

                                                    $nama_test = $test['nama_test'];
                                                ?>
                                                    <option value="<?= $id; ?>"><?= $nama_test; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button type="button" onclick="return window.history.back()" class="btn btn-default mr-3">Kembali</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    $(document).ready(function() {
        $("select").select2({
            theme: "bootstrap4"
        })
    })
</script>
<?= $this->endSection(); ?>