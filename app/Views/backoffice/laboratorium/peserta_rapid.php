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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="save" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="type" value="import_excel">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Registrasi</label>
                                    <div class="col-md-9">
                                        <input type="date" readonly class="form-control" name="tanggalregistrasi" value="<?= $tgl_registrasi; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nomor Registrasi</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nomorregistrasi" value="<?= $customer['customer_unique']; ?>" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">NIK</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nik" value="<?= $customer['nik']; ?>" readonly disabled>
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">No. Passport</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nopassport" value="">
                                </div>
                            </div> -->
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nationality</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nationality" readonly value="Indonesia" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nama Lengkap <small style="color:red;">*</small></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nama" value="<?= $customer['nama']; ?>" readonly disabled>
                                    </div>
                                </div>

                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Jenis Kelamin</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="jeniskelamin" aria-readonly="true" readonly disabled>
                                            <option value="">--Pilih--</option>
                                            <option value="pria" <?= ($customer['jenis_kelamin'] == "pria") ? "selected" : ""; ?>>Pria</option>
                                            <option value="wanita" <?= ($customer['jenis_kelamin'] == "wanita") ? "selected" : ""; ?>>Wanita</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tempat Lahir</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="tempatlahir" value="<?= $customer['tempat_lahir']; ?>" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Lahir</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="tanggallahir" value="<?= $customer['tanggal_lahir']; ?>" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nomor HP</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nomorhp" value="<?= $customer['phone']; ?>" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" value="<?= $customer['email']; ?>" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Alamat</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="alamat" readonly disabled><?= $customer['alamat']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Instansi</label>
                                    <div class="col-md-9">
                                        <select name="idinstansi" class="form-control" aria-readonly="true" readonly disabled>
                                            <option value="">--Pilih--</option>
                                            <?php
                                            foreach ($instansi as $key => $in) {
                                            ?>
                                                <option value="<?= $in['id']; ?>"><?= $in['nama']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3" aria-readonly="true" readonly disabled>Titimangsa</label>
                                    <div class="col-md-9">
                                        <select name="titimangsa" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <?php
                                            foreach ($lokasi as $key => $lok) {
                                            ?>
                                                <option value="<?= $lok['id']; ?>"><?= $lok['nama_kota']; ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Catatan</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="catatan" readonly disabled><?= $customer['catatan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <a class="btn btn-primary btn-sm" target="_blank" href="/backoffice/layanan/print/barcode/<?= $customer['customer_unique']; ?>">Barcode</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                Data Pemeriksaan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Waktu Kunjungan</label>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control " type="date" name="tanggalkunjungan" value="<?= $customer['tgl_kunjungan']; ?>" readonly disabled />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control " type="time" name="jamkunjungan" value="<?= $customer['jam_kunjungan']; ?>" readonly disabled />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Jenis Pemeriksaan</label>
                                <div class="col-md-9">
                                    <input type="text" name="" value="<?= $customer['nama_test']; ?>" id="" class="form-control disabled" disabled readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Alat Pemeriksaan</label>
                                <div class="col-md-9">
                                    <!-- <select class="form-control" name="idalat" id="idalat" onchange="changeFuncalat('idalat');"> -->
                                    <input type="text" name="" value="Tianlong" id="" class="form-control disabled" disabled readonly>
                                    <!-- <select class="form-control" name="idalat" id="idalat">
                                        <option value="">--Pilih--</option>
                                        <?php
                                        foreach ($alat as $key => $al) {
                                        ?>
                                            <option value="<?= $al['id']; ?>"><?= $al['nama_alat']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Waktu Ambil Sampling</label>
                                <div class="col-md-9">
                                    <?= $detail_hasil['waktu_ambil_sampling']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Waktu Periksa Sampling</label>
                                <div class="col-md-9">
                                    <?= $detail_hasil['waktu_periksa_sampling']; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Waktu Selesai Periksa</label>
                                <div class="col-md-9">
                                    <?= $detail_hasil['waktu_selesai_periksa']; ?>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Jenis Sample</label>
                                <div class="col-md-9">
                                    <select name="jenissample" class="form-control">
                                        <?php
                                        foreach ($jenis_sample as $key => $sample) {
                                        ?>
                                            <option value="<?= $sample['id']; ?>"><?= $sample['nama_sample']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> -->
                            <div id="swab">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">2019-nCoV</label>
                                    <div class="col-md-9">
                                        <input type="text" name="" value="<?= $detail_hasil['status_cov']; ?>" id="" class="form-control disabled" disabled readonly>
                                        <!-- <select name="status_cov" id="status_cov" class="form-control">
                                            <option value="1"> Negatif</option>
                                            <option value="2">Positif</option>
                                        </select> -->
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">N gene</label>
                                    <div class="col-md-9">
                                        <input type="text" name="" value="<?= $detail_hasil['status_gene']; ?>" id="" class="form-control disabled" disabled readonly>
                                        <!-- <select name="status_n_gene" id="status_n_gene" class="form-control" onchange="changeFunc('fam');">
                                            <option value="3">Undetection</option>
                                            <option value="4" selected> Detection</option>

                                        </select> -->
                                    </div>
                                </div>
                                <div id="uraianfam">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Nilai FAM / N gene</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="uraianfam" value="<?= $detail_hasil['value_n_gene']; ?>" id="value_n_gene" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">ORF1ab</label>
                                    <div class="col-md-9">
                                        <input type="text" name="" value="<?= $detail_hasil['status_orf']; ?>" id="" class="form-control disabled" disabled readonly>
                                        <!-- <select name="status_orf" id="status_orf" class="form-control" onchange="changeFunc('rox');">
                                            <option value="5">Undetection</option>
                                            <option value="6"> Detection</option>

                                        </select> -->
                                    </div>
                                </div>
                                <div id="uraianrox">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Nilai ROX / ORF1ab</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="uraianrox" value="<?= $detail_hasil['value_orf']; ?>" id="value_orf" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">IC</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="vic" value="<?= $detail_hasil['value_ic']; ?>" readonly disabled>
                                    </div>
                                </div>
                            </div>

                            <div style='display:none;' id="rapid">

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Anti SARS-CoV-2 IgM</label>
                                    <div class="col-md-9">
                                        <select name="lgm" id="lgm" class="form-control">
                                            <option value="24"> Non Reaktif</option>
                                            <option value="25">Reaktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Anti SARS-CoV-2 IgG</label>
                                    <div class="col-md-9">
                                        <select name="lgg" id="lgg" class="form-control">
                                            <option value="26"> Non Reaktif</option>
                                            <option value="27">Reaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style='display:none;' id="antigen">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Antigen</label>
                                    <div class="col-md-9">
                                        <select name="antigen" id="antigen" class="form-control">
                                            <option value="Negatif"> Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style='display:none;' id="mcr">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Swab Molecular</label>
                                    <div class="col-md-9">
                                        <select name="mcr" class="form-control">
                                            <option value="Negatif"> Negatif</option>
                                            <option value="Positif">Positif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Dokter Pemeriksa</label>
                                <div class="col-md-9">
                                    <select name="iddokter" class="form-control">
                                        <option value="">--Pilih--</option>
                                        <?php
                                        foreach ($dokter as $key => $dok) {
                                        ?>
                                            <option value="<?= $dok['id']; ?>"><?= $dok['nama']; ?></option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Petugas Pemeriksa</label>
                                <div class="col-md-9">
                                    <select name="idpetugas" class="form-control">
                                        <option value="">--Pilih--</option>
                                        <?php
                                        foreach ($petugas as $key => $pet) {
                                        ?>
                                            <option value="<?= $pet['id']; ?>"><?= $dok['nama']; ?></option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Status Pemeriksaan</label>
                                <div class="col-md-9">
                                    <select name="statustransaksi" class="form-control">
                                        <option value="">--Pilih--</option>
                                        <option value="7" selected>Pemeriksaan Sample</option>
                                        <option value="8">Selesai</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Status Kirim Hasil</label>
                                <div class="col-md-9">
                                    <select name="statuskirimhasil" class="form-control statuskirimhasil">
                                        <option value="9" selected>Belum Di Kirim</option>
                                        <option value="10">Sudah Di Kirim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button class="btn btn-secondary btn-sm" onclick="return window.close()">Kembali</button>
                                <button class="btn btn-success btn-sm">Simpan</button>
                                <div class="hidden">
                                    <a href="/api/get_hasil_lab/<?= $customer['id']; ?>" class="btn btn-primary btn-sm">Cetak Hasil(en)</a>
                                    <a class="btn btn-primary btn-sm" type="button" href="send_hasil_peserta/<?= $customer['id']; ?>">Kirim Hasil</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("select").select2({
            theme: "bootstrap4"
        });
    });

    function kirim_hasil() {
        let id_customer = <?= $customer['id']; ?>;
        $.get("<?= base_url('backoffice/laboratorium/send_hasil_peserta/'); ?>" + id_customer, {
            id_customer
        }, (data) => {

        });
    }
</script>
<?= $this->endSection(); ?>