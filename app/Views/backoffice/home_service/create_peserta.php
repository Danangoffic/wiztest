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
                <div class="col-sm-12 col-md-6">
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
                                        <input type="date" name="tgl_kunjungan" class="form-control" id="tgl_kunjungan" min="<?= date('Y-m-d'); ?>" autofocus required value="<?= (old('tgl_kunjungan')) ? old('tgl_kunjungan') : ''; ?>">
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
                                    <label for="pemeriksa" class="col-md-3">Nama Pemeriksa <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <select name="pemeriksa" id="pemeriksa" class="select2 form-control">
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
                                    <label for="paket_pemeriksaan" class="col-md-3">Paket Pemeriksaan</label>
                                    <div class="col-md-9">
                                        <select name="paket_pemeriksaan" id="paket_pemeriksaan" class="form-control" onchange="detail_data_test()">
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
                                        <select name="id_pemeriksaan" id="id_pemeriksaan" class="form-control" aria-readonly="true" readonly data-disabled="true">
                                            <?php
                                            foreach ($jenis_pemeriksaan as $key => $value) {
                                                if ($value['nama_pemeriksaan'] == "HOME SERVICE") :
                                            ?>
                                                    <option value="<?= $value['id']; ?>"><?= $value['nama_pemeriksaan']; ?></option>
                                            <?php
                                                endif;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-md-3">NIK <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="nik" id="nik" class="form-control" required autocomplete="off" value="<?= (old('nik')) ? old('nik') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nik'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-md-3">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="nama" id="nama" class="form-control" required autocomplete="off" value="<?= (old('nama')) ? old('nama') : ''; ?>">
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
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control " required value="<?= (old('tempat_lahir')) ? old('tempat_lahir') : ''; ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('tempat_lahir'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_lahir" class="col-md-3">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control " required value="<?= (old('tgl_lahir')) ? old('tgl_lahir') : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-md-3">Nomor HP</label>
                                    <div class="col-md-9">
                                        <input type="number" name="phone" id="phone" class="form-control" required autocomplete="off" value="<?= (old('phone')) ? old('phone') : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirmPhone" class="col-md-3">Nomor HP</label>
                                    <div class="col-md-9">
                                        <input type="number" name="confirmPhone" id="confirmPhone" class="form-control" required autocomplete="off" value="<?= (old('phone')) ? old('phone') : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-3">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="email" id="email" class="form-control" required autocomplete="off" value="<?= (old('email')) ? old('email') : ''; ?>">
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
                                    <button class="btn btn-success" role="button" type="button" onclick="return tambah_peserta()"><i class="fa fa-save"></i> Tambah Peserta</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Tabel Peserta</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket Pemeriksaan</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="result_peserta"></tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="button" id="simpan" class="btn btn-primary disabled">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var token = "<?= csrf_hash(); ?>";
    <?= $this->include("backoffice/home_service/create.js"); ?>

    function simpan_peserta() {
        let length_peserta = array_peserta.length;
        if (length_peserta < 5) {
            showError('Peserta minimum adalah 5');
            return false;
        }
        $.ajax({
            url: "<?= base_url('api/peserta/home-service'); ?>",
            type: "POST",
            data: {
                peserta: array_peserta,
                token,
                is_hs: true
            },
            success: function(data, status, xhr) {
                let statusMessage = data.statusMessage;
                if (statusMessage == "success") {
                    reset_forms();

                }
            }
        })
    }
</script>
<?= $this->endSection(); ?>