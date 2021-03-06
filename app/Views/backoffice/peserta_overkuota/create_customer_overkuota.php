<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
    </section>
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <form action="/backoffice/peserta/save" method="post" class="col-md-12">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="status_peserta" value="21">
                                    <div class="form-group row">
                                        <label for="tgl_kunjungan" class="col-md-4 mt-2">Waktu Kunjungan <span class="text-danger">*</span></label>
                                        <div class="col-md-4 mt-2">
                                            <input type="date" name="tgl_kunjungan" class="form-control" id="tgl_kunjungan" min="<?= date('Y-m-d'); ?>" autofocus required>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <select name="jam_kunjungan" id="jam_kunjungan" class="form-control" data-placeholder="Pilih jam kunjungan">
                                                <option value=""></option>
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
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_registrasi" class="col-md-4">Tanggal Registrasi</label>
                                        <div class="col-md-8">
                                            <input type="date" name="tgl_registrasi" id="tgl_registrasi" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_pemeriksa" class="col-md-4">Nama Pemeriksa <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <select name="nama_pemeriksa" id="nama_pemeriksa" class="form-control" data-placeholder="Pilih pemeriksa">
                                                <option value=""></option>
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
                                        <label for="layanan_test" class="col-md-4">Jenis Layanan</label>
                                        <div class="col-md-8">
                                            <select name="layanan_test" id="layanan_test" class="form-control" data-placeholder="Pilih jenis layanan">
                                                <option value=""></option>
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
                                        <label for="nik" class="col-md-4">NIK <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="nik" id="nik" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama" class="col-md-4">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="nama" id="nama" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jenis_kelamin" class="col-md-4">Jenis Kelamin</label>
                                        <div class="col-md-8">
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required data-placeholder="Pilih jenis kelamin">
                                                <option value=""></option>
                                                <option value="pria">Pria</option>
                                                <option value="wanita">Wanita</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_lahir" class="col-md-4">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-md-4">Nomor HP</label>
                                        <div class="col-md-8">
                                            <input type="number" name="phone" id="phone" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4">Email</label>
                                        <div class="col-md-8">
                                            <input type="email" name="email" id="email" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alamat" class="col-md-4">Alamat</label>
                                        <div class="col-md-8">
                                            <textarea name="alamat" id="alamat" class="form-control" cols="5" rows="2" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="faskes" class="col-md-4">Faskes Asal</label>
                                        <div class="col-md-8">
                                            <select name="faskes" id="faskes" class="form-control" data-placeholder="Pilih faskes asal">
                                                <option value=""></option>
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
                                        <label for="instansi" class="col-md-4">Instansi</label>
                                        <div class="col-md-8">
                                            <select name="instansi" id="instansi" class="form-control" data-placeholder="Pilih instansi">
                                                <option value=""></option>
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
                                        <label for="id_marketing" class="col-md-4">PIC Marketing</label>
                                        <div class="col-md-8">
                                            <select name="id_marketing" id="id_marketing" class="form-control" data-placeholder="Pilih PIC Marketing">
                                                <option value=""></option>
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
                                        <label for="status_pembayaran" class="col-md-4">Cara Pembayaran</label>
                                        <div class="col-md-8">
                                            <select name="status_pembayaran" id="status_pembayaran" class="form-control" data-placeholder="Pilih cara pembayaran">
                                                <option value=""></option>
                                                <option value="invoice">Invoice</option>
                                                <option value="belum lunas">Belum Lunas</option>
                                                <option value="lunas">Lunas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="catatan" class="col-md-4">Catatan</label>
                                        <div class="col-md-8">
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
        </div>
    </section>
</div>

<script>
    $(document).ready(() => {
        $("select").select2({
            theme: "bootstrap4"
        })
    });
</script>
<?= $this->endSection(); ?>