<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-12">
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body row">
                        <form action="update/<?= $id; ?>" method="post" class="col-8">
                            <input type="hidden" name="id_customer" value="<?= $id; ?>">
                            <div class="form-group row">
                                <label for="tgl_kunjungan" class="col-2">Waktu Kunjungan <span class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input type="date" name="tgl_kunjungan" class="form-control <?= ($validation->hasError('tgl_kunjungan')) ? 'is-invalid' : (old('tgl_kunjungan')) ? 'is-invalid' : ''; ?>" id="tgl_kunjungan" min="<?= date('Y-m-d'); ?>" readonly required value="<?= (old('tgl_kunjungan')) ? old('tgl_kunjungan') : $data['tgl_kunjungan']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tgl_kunjungan'); ?>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <select name="jam_kunjungan" id="jam_kunjungan" class="form-control" readonly aria-readonly="true">
                                        <?php
                                        for ($i = 7; $i < 23; $i++) {
                                            $timeNow = date('H');
                                            // if ($i > $timeNow) {
                                        ?>
                                            <option value="<?= $i; ?>" <?= ($data['jam_kunjungan'] == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
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
                                <label for="tgl_registrasi" class="col-2">Tanggal Registrasi</label>
                                <div class="col-10">
                                    <?php
                                    $tgl_registrasi_create = date_create($data['created_at']);
                                    $formatedRegistration = date_format($tgl_registrasi_create, 'Y-m-d');
                                    ?>
                                    <input type="date" name="tgl_registrasi" id="tgl_registrasi" class="form-control" value="<?= $formatedRegistration; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_pemeriksa" class="col-2">Nama Pemeriksa <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <select name="nama_pemeriksa" id="nama_pemeriksa" class="form-control">
                                        <?php
                                        foreach ($pemeriksa as $key => $value) {
                                        ?>
                                            <option value="<?= $value['id']; ?>" <?= ($data['pemeriksa'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="layanan_test" class="col-2">Paket Pemeriksaan</label>
                                <div class="col-10">
                                    <select name="layanan_test" id="layanan_test" class="form-control">
                                        <?php
                                        foreach ($data_layanan_test as $key => $value) {
                                            $DetailLayanan = $layananModel->find($value['id_layanan']);
                                            $DetailTest = $testModel->find($value['id_test']);
                                            $namaLayanan = $DetailLayanan['nama_layanan'];
                                            $nama_test = $DetailTest['nama_test'];
                                        ?>
                                            <option value="<?= $value['id']; ?>" <?= ($data['jenis_test'] == $value['id']) ? 'selected' : ''; ?>><?= $nama_test; ?> (<?= $namaLayanan; ?>)</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nik" class="col-2">NIK <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <input type="text" name="nik" id="nik" class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : (old('nik')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('nik')) ? old('nik') : $data['nik']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nik'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-2">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <input type="text" name="nama" id="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : (old('nama')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('nama')) ? old('nama') : $data['nama']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_kelamin" class="col-2">Jenis Kelamin</label>
                                <div class="col-10">
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="pria" <?= ($data['jenis_kelamin'] == "pria") ? 'selected' : ''; ?>>Pria</option>
                                        <option value="wanita" <?= ($data['jenis_kelamin'] == "wanita") ? 'selected' : ''; ?>>Wanita</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tempat_lahir" class="col-2">Tempat Lahir <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control <?= ($validation->hasError('tempat_lahir')) ? 'is-invalid' : (old('tempat_lahir')) ? 'is-valid' : ''; ?>" required value="<?= (old('tempat_lahir')) ? old('tempat_lahir') : $data['tempat_lahir']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tempat_lahir'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_lahir" class="col-2">Tanggal Lahir <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control <?= ($validation->hasError('tgl_lahir')) ? 'is-invalid' : (old('tgl_lahir')) ? 'is-valid' : ''; ?>" required value="<?= (old('tgl_lahir')) ? old('tgl_lahir') : $data['tanggal_lahir']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tgl_lahir'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-2">Nomor HP</label>
                                <div class="col-10">
                                    <input type="number" name="phone" id="phone" class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : (old('phone')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('phone')) ? old('phone') : $data['phone']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('phone'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-2">Email</label>
                                <div class="col-10">
                                    <input type="email" name="email" id="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : (old('email')) ? 'is-valid' : ''; ?>" required autocomplete="off" value="<?= (old('email')) ? old('email') : $data['email']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-2">Alamat</label>
                                <div class="col-10">
                                    <textarea name="alamat" id="alamat" class="form-control" cols="5" rows="2" required><?= old('alamat') ? old('alamat') : $data['alamat']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="faskes_asal" class="col-2">Faskes Asal</label>
                                <div class="col-10">
                                    <select name="faskes_asal" id="faskes_asal" class="form-control" required>
                                        <?php
                                        foreach ($faskes as $key => $value) {
                                        ?>
                                            <option value="<?= $value['id']; ?>" <?= ($data['faskes_asal'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama_faskes']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="instansi" class="col-2">Instansi</label>
                                <div class="col-10">
                                    <select name="instansi" id="instansi" class="form-control" required>
                                        <?php
                                        foreach ($instansi as $key => $value) {
                                        ?>
                                            <option value="<?= $value['id']; ?>" <?= ($data['instansi'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_marketing" class="col-2">PIC Marketing</label>
                                <div class="col-10">
                                    <select name="id_marketing" id="id_marketing" class="form-control">
                                        <?php
                                        foreach ($marketing as $key => $value) {
                                        ?>
                                            <option value="<?= $value['id']; ?>" <?= ($data['id_marketing'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama_marketing']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status_pembayaran" class="col-2">Cara Pembayaran</label>
                                <div class="col-10">
                                    <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                                        <option value="">&nbsp;</option>
                                        <option value="invoice" <?= ($data['status_pembayaran'] == 'invoice') ? 'selected' : ''; ?>>Invoice</option>
                                        <option value="unpaid" <?= ($data['status_pembayaran'] == 'unpaid') ? 'selected' : ''; ?>>Belum Lunas</option>
                                        <option value="paid" <?= ($data['status_pembayaran'] == 'paid') ? 'selected' : ''; ?>>Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="catatan" class="col-2">Catatan</label>
                                <div class="col-10">
                                    <textarea name="catatan" id="catatan" class="form-control"><?= (old('catatan')) ? old('catatan') : $data['catatan']; ?></textarea>
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
    </section>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script>
    $(document).ready(() => {

    });
</script>
<?= $this->endSection(); ?>