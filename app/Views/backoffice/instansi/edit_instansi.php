<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""></label>
                        </div>
                    </div>
                </div>
            </div>
        </div><?= $this->extend('backoffice/template/layout'); ?>
        <?= $this->section('content'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content mt-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-heading"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">
                                <form action="/backoffice/instansi/update_instansi/<?= $id; ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group row">
                                        <label class="col-3" for="nama">Nama</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="nama" name="nama" required autocomplete="off" placeholder="Nama Instansi" value="<?= $data_instansi['nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3" for="nama">Alamat</label>
                                        <div class="col-9">
                                            <textarea placeholder="Alamat" name="alamat" id="alamat" cols="2" rows="2" class="form-control" required><?= $data_instansi['alamat']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3" for="nama">Kota</label>
                                        <div class="col-9">
                                            <select name="kota" id="kota" class="form-control">
                                                <?php
                                                foreach ($data_kota as $key => $value) {
                                                ?>
                                                    <option value="<?= $value['id']; ?>" <?= ($value['id'] == $data_instansi['kota']) ? 'selected' : ''; ?>><?= $value['nama_kota']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_user" class="col-3">Nama User</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="nama_user" name="nama_user" autocomplete="off" placeholder="Nama User" value="<?= $data_instansi['nama_user']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tempat_lahir" class="col-3">Tempat Lahir</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" autocomplete="off" placeholder="Tempat Lahir" value="<?= $data_instansi['tempat_lahir']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_lahir" class="col-3">Tanggal Lahir</label>
                                        <div class="col-9">
                                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" autocomplete="off" value="<?= $data_instansi['tgl_lahir']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-3">Nomor HP</label>
                                        <div class="col-9">
                                            <input type="number" class="form-control" id="phone" name="phone" autocomplete="off" placeholder="Nomor HP" value="<?= $data_instansi['phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-3">Email</label>
                                        <div class="col-9">
                                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="Email Instansi. Contoh: Email@mail.com" value="<?= $data_instansi['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pic_marketing" class="col-3">PIC Marketing</label>
                                        <div class="col-9">
                                            <select name="pic_marketing" id="pic_marketing" class="form-control">
                                                <?php
                                                foreach ($data_marketing as $key => $value) {
                                                ?>
                                                    <option value="<?= $value['id']; ?>" <?= ($value['id'] == $data_instansi['pic_marketing']) ? 'selected' : ''; ?>><?= $value['nama_marketing']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a class="btn btn-default" id="backButton" role="button" type="button" href="/backoffice/instansi/<?= $id; ?>"><i class="fa fa-chevron-left"></i> Kembali</a>
                                        <button class="btn btn-success" id="saveButton" role="button" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?= $this->endSection(); ?>
    </section>
</div>