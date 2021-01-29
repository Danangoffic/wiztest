<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header mb-0">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (session()->getFlashdata('success')) {
                ?>
                    <div class="alert alert-success fade show" role="alert">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php
                }
                if (session()->getFlashdata('error')) {
                ?>
                    <div class="alert alert-warning fade show" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php
                }
                ?>
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
                        <div class="card-body row">
                            <form action="/backoffice/peserta/save" method="post" class="col-md-12">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="status_peserta" value="<?= $status_peserta; ?>">
                                <div class="form-group row">
                                    <label for="tgl_kunjungan" class="col-md-3 mt-2">Waktu Kunjungan <span class="text-danger">*</span></label>
                                    <div class="col-md-5 mt-2">
                                        <input type="date" name="tgl_kunjungan" class="form-control <?= ($validation->hasError('tgl_kunjungan')) ? 'is-invalid' : (old('tgl_kunjungan')) ? 'is-invalid' : ''; ?>" id="tgl_kunjungan" min="<?= date('Y-m-d'); ?>" autofocus required value="<?= (old('tgl_kunjungan')) ? old('tgl_kunjungan') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tgl_kunjungan'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <select name="jam_kunjungan" id="jam_kunjungan" class="form-control">
                                            <?php
                                            for ($i = 7; $i < 23; $i++) {
                                                $timeNow = date('H');
                                                // if ($i > $timeNow) {
                                            ?>
                                                <option value="<?= $i; ?>" <?= ($timeNow + 1 == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('jam_kunjungan'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tgl_registrasi" class="col-md-3">Tanggal Registrasi</label>
                                    <div class="col-md-9">
                                        <input type="date" name="tgl_registrasi" id="tgl_registrasi" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama_pemeriksa" class="col-md-3">Nama Pemeriksa <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <select name="nama_pemeriksa" id="nama_pemeriksa" class="form-control">
                                            <?php
                                            foreach ($pemeriksa as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="test_layanan" class="col-md-3">Paket Pemeriksaan</label>
                                    <div class="col-md-9">
                                        <select name="test_layanan" id="test_layanan" class="form-control">
                                            <?php
                                            foreach ($data_layanan_test as $key => $value) {
                                                $id_layanan = $value['id_layanan'];
                                                $id_test = $value['id_test'];
                                                $DetailLayanan = $layananModel->find($id_layanan);
                                                $DetailTest = $testModel->find($id_test);
                                                $namaLayanan = $DetailLayanan['nama_layanan'];
                                                $nama_test = $DetailTest['nama_test'];
                                            ?>
                                                <option value="<?= $id_test . " " . $id_layanan; ?>"><?= $nama_test; ?> (<?= $namaLayanan; ?>)</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="id_pemeriksaan" class="col-md-3">Jenis Layanan</label>
                                    <div class="col-md-9">
                                        <select name="id_pemeriksaan" id="id_pemeriksaan" class="form-control">
                                            <?php
                                            foreach ($jenis_pemeriksaan as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama_pemeriksaan']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-md-3">NIK <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="nik" id="nik" class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : (old('nik')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('nik')) ? old('nik') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nik'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-md-3">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="nama" id="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : (old('nama')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('nama')) ? old('nama') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-md-3">Jenis Kelamin</label>
                                    <div class="col-md-9">
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tempat_lahir" class="col-md-3">Tempat Lahir <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control <?= ($validation->hasError('tempat_lahir')) ? 'is-invalid' : (old('tempat_lahir')) ? 'is-valid' : ''; ?>" required value="<?= (old('tempat_lahir')) ? old('tempat_lahir') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tempat_lahir'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tgl_lahir" class="col-md-3">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control <?= ($validation->hasError('tgl_lahir')) ? 'is-invalid' : (old('tgl_lahir')) ? 'is-valid' : ''; ?>" required value="<?= (old('tgl_lahir')) ? old('tgl_lahir') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tgl_lahir'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-md-3">Nomor HP</label>
                                    <div class="col-md-9">
                                        <input type="number" name="phone" id="phone" class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : (old('phone')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('phone')) ? old('phone') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('phone'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-3">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="email" id="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : (old('email')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('email')) ? old('email') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-md-3">Alamat</label>
                                    <div class="col-md-9">
                                        <textarea name="alamat" id="alamat" class="form-control" cols="5" rows="2" required><?= old('alamat') ? old('alamat') : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="faskes_asal" class="col-md-3">Faskes Asal</label>
                                    <div class="col-md-9">
                                        <select name="faskes_asal" id="faskes_asal" class="form-control" required>
                                            <?php
                                            foreach ($faskes as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama_faskes']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="instansi" class="col-md-3">Instansi</label>
                                    <div class="col-md-9">
                                        <select name="instansi" id="instansi" class="form-control" required>
                                            <?php
                                            foreach ($instansi as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="id_marketing" class="col-md-3">PIC Marketing</label>
                                    <div class="col-md-9">
                                        <select name="id_marketing" id="id_marketing" class="form-control">
                                            <?php
                                            foreach ($marketing as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['nama_marketing']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status_pembayaran" class="col-md-3">Cara Pembayaran</label>
                                    <div class="col-md-9">
                                        <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                                            <option value="">&nbsp;</option>
                                            <option value="Invoice">Invoice</option>
                                            <option value="Belum Lunas">Belum Lunas</option>
                                            <option value="Lunas">Lunas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="catatan" class="col-md-3">Catatan</label>
                                    <div class="col-md-9">
                                        <textarea name="catatan" id="catatan" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group float-right">
                                    <button class="btn btn-default" role="button" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-success" role="button" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?= $this->endSection(); ?>