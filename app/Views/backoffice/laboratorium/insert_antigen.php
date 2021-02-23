<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($session->getFlashdata('success')) {
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                            <p><?= session()->getFlashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    if ($session->getFlashdata('error')) {
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
        <?= form_open('/backoffice/laboratorium/save_verifikasi'); ?>
        <?= form_hidden('id_test', $id_test); ?>
        <?= form_hidden('id', $detail_hasil_lab['id']); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Peserta</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <?php
                                $id_customer = $detail_customer['id'];
                                $no_registrasi = $detail_customer['customer_unique'];
                                $tgl_registrasi = $detail_customer['created_at'];
                                $nik = $detail_customer['nik'];
                                $nama = $detail_customer['nama'];
                                $tanggal_lahir = $detail_customer['tanggal_lahir'];
                                $jenis_kelamin = $detail_customer['jenis_kelamin'];
                                $waktu_kunjungan = $detail_customer['tgl_kunjungan'] . " " . $detail_customer['jam_kunjungan'];
                                $waktu_sampling = $detail_customer['tgl_kunjungan'];
                                $waktu_periksa = $detail_customer['tgl_kunjungan'];
                                $waktu_selesai = $detail_customer['tgl_kunjungan'];
                                echo form_hidden('id_customer', $id_customer);
                                ?>
                                <tr>
                                    <td>No. Registrasi</td>
                                    <td><?= $no_registrasi; ?></td>
                                </tr>
                                <tr>
                                    <td>Tgl. Registrasi</td>
                                    <td><?= $tgl_registrasi; ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td><?= $nik; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td><?= $nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal lahir/Jenis Kelamin</td>
                                    <td><?= $tanggal_lahir . "/" . $jenis_kelamin; ?></td>
                                </tr>
                                <!-- <tr>
                                    <td><strong>Well</strong></td>
                                    <td>select</td>
                                </tr> -->
                                <tr>
                                    <td>Waktu Kunjungan</td>
                                    <td><?= $waktu_kunjungan; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Sampling</td>
                                    <td><?= $waktu_sampling; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Periksa</td>
                                    <td><?= $waktu_periksa; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Selesai</td>
                                    <td><?= $waktu_selesai; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= csrf_field(); ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Pemeriksaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="waktu_kunjungan" class="col-label-form col-md-4">Waktu Kunjungan</label>
                                <div class="col-md-8">
                                    <input type="datetime" name="waktu_kunjungan" id="waktu_kunjungan" class="form-control disabled" readonly disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_pemeriksaan" class="col-label-form col-md-4">Jenis Pemeriksaan</label>
                                <div class="col-md-8">
                                    <input type="text" name="jenis_pemeriksaan" id="jenis_pemeriksaan" class="form-contro disabled" readonly disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alat" class="col-label-form col-md-4">Alat Pemeriksaan</label>
                                <div class="col-md-4">
                                    <input type="text" name="alat" id="alat" class="form-control disabled" readonly disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="waktu_ambil_sampling" class="col-label-form col-md-4">Waktu Ambil Sampling</label>
                                <div class="col-md-8">
                                    <input type="datetime" name="waktu_ambil_sampling" id="waktu_ambil_sampling" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="waktu_periksa_sampling" class="col-label-form col-md-4">Waktu Periksa Sampling</label>
                                <div class="col-md-8">
                                    <input type="datetime" name="waktu_periksa_sampling" id="waktu_periksa_sampling" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="waktu_selesai_periksa" class="col-label-form col-md-4">Waktu Selesai Periksa</label>
                                <div class="col-md-8">
                                    <input type="datetime" name="waktu_selesai_periksa" id="waktu_selesai_periksa" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis_sample" class="col-label-from col-md-4">Jenis Sample</label>
                                <div class="col-md-8">
                                    <select name="jenis_sample" id="jenis_sample" class="form-control select2">
                                        <option value="1" label="Orofaring & Nasofaring" aria-label="Orofaring & Nasofaring">Orofaring & Nasofaring</option>
                                        <option value="2" label="Sputum" aria-label="Sputum">Sputum</option>
                                        <option value="3" label="Saliva" aria-label="Saliva">Saliva</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status_antigen" class="col-label-form col-md-4">Antigen</label>
                                <div class="col-md-8">
                                    <select name="status_antigen" id="status_antigen" class="form-control select2">
                                        <option value="Negatif" label="Negatif" aria-label="Negatif">Negatif</option>
                                        <option value="Positif" label="Positif" aria-label="Positif">Positif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dokter" class="col-label-form col-md-4">Dokter Pemeriksa</label>
                                <div class="col-md-8">
                                    <input type="text" name="dokter" id="dokter" class="form-control disabled" readonly aria-readonly="true" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="petugas" class="col-label-form col-md-4">Petugas Pemeriksa</label>
                                <div class="col-md-8">
                                    <input type="text" name="petugas" id="petugas" class="form-control disabled" readonly aria-readonly="true" disabled aria-disabled="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status_pemeriksaan" class="col-label-form col-md-4">Status Pemeriksaan</label>
                                <div class="col-md-8">
                                    <select name="status_pemeriksaan" id="status_pemeriksaan" class="form-control select2">
                                        <option value="Pemeriksaan Sample" aria-label="Pemeriksaan Sample" label="Pemeriksaan Sample">Pemeriksaan Sample</option>
                                        <option value="Selesai" aria-label="Selesai" label="Selesai">Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status_kirim" class="col-label-form col-md-4">Status Kirim Hasil</label>
                                <div class="col-md-8">
                                    <select name="status_kirim" id="status_kirim" class="form-control select2">
                                        <option value="Belum Dikirim" aria-label="Belum Dikirim" label="Belum Dikirim">Belum Dikirim</option>
                                        <option value="Sudah Dikirim" aria-label="Sudah Dikirim" label="Sudah Dikirim">Sudah Dikirim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <!-- <button class="btn btn-default mr-3" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button> -->
                                <button class="btn btn-success" id="saveButton" type="submit"><i class="fa fa-check"></i> Validasi</button>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </section>
</div>
<script>
    $(document).ready(function() {
        $(".select2").select2({
            theme: "bootstrap4"
        })
    })
</script>
<?= $this->endSection(); ?>