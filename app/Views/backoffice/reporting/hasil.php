<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <form action="" method="POST">
                        <div class="card collapsed-card">
                            <div class="card-header" id="headingOne">
                                <button type="button" class="btn btn-default" data-card-widget="collapse">
                                    Filtering
                                </button>
                            </div>

                            <div class="card-body">

                                <input type="hidden" name="filtering" value="on">
                                <div class="form-group row">
                                    <div class="col-md-8 col-offset-3">
                                        <div class="row">
                                            <div class="col-md-12 row">
                                                <label for="date1" class="col-md-3 col-form-label">Tanggal Registrasi</label>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control" id="date1" name="date1" value="" max="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 row">
                                                <div class="col-md-3">&nbsp;</div>
                                                <div class="col-md-6">s/d</div>
                                            </div>
                                            <div class="col-md-12 row">
                                                <label for="date2" class="col-md-3 col-form-label">&nbsp;</label>
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control" id="date2" name="date2" value="" max="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-offset-3">
                                        <div class="row">
                                            <div class="col-md-12 row">
                                                <label for="instansi" class="col-md-3 col-form-label">Instansi</label>
                                                <div class="col-md-6">
                                                    <select name="instansi" id="instansi" class="form-control select2">
                                                        <option value=""></option>
                                                        <?php
                                                        $data_instansi = $instansi_model->findAll();
                                                        foreach ($data_instansi as $key => $instansi) {
                                                        ?>
                                                            <option value="<?= $instansi['id']; ?>"><?= $instansi['nama']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-offset-3">
                                        <div class="row">
                                            <div class="col-md-12 row">
                                                <label for="marketing" class="col-md-3 col-form-label">PIC Marketing</label>
                                                <div class="col-md-6">
                                                    <select name="marketing" id="marketing" class="form-control select2">
                                                        <option value=""></option>
                                                        <?php
                                                        $data_marketing = $marketing_model->findAll();
                                                        foreach ($data_marketing as $key => $marketing) {
                                                        ?>
                                                            <option value="<?= $marketing['id']; ?>"><?= $marketing['nama_marketing']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="submit" name="tipe_filter" value="Filter" class="btn btn-primary">
                                <input type="submit" name="tipe_filter" value="Cetak PDF" class="btn btn-danger">
                                <input type="submit" name="tipe_filter" value="Cetak Excel" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title; ?></h3>
                        </div>
                        <div class="card-body">
                            <!-- <a href="<?= base_url('backoffice/peserta/create'); ?>" class="btn btn-primary mb-3">Tambah Peserta</a> -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover" id="data">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Registrasi</th>
                                            <th>Paket Pemeriksaan</th>
                                            <th>Nomor Pegawai</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Waktu Sampling</th>
                                            <th>Waktu Periksa</th>
                                            <th>Waktu Selesai Periksa</th>
                                            <th>Jenis Sample</th>
                                            <th>Hasil Swab PCR</th>
                                            <th>Hasil Swab Antigen</th>
                                            <th>Hasil Rapid Test</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_hasil as $key => $value) {
                                            $id_customer = $value['id_customer'];
                                            $data_customer = $customer_model->find($id_customer);
                                            $jenis_test = $data_customer['jenis_test'];

                                            $cust_uniq = $data_customer['customer_unique'];
                                            $tgl_daftar = substr($data_customer['created_at'], 0, 10);

                                            $data_layanan_test = $layanan_test_model->find($jenis_test);
                                            $id_layanan = $data_layanan_test['id_layanan'];
                                            $id_test = $data_layanan_test['id_test'];

                                            $data_layanan = $layanan_model->find($id_layanan);
                                            $nama_layanan = $data_layanan['nama_layanan'];
                                            $data_test = $test_model->find($id_test);
                                            $nama_test = $data_test['nama_test'];

                                            $id_sample = $value['id_sample'];
                                            $data_sample = $sample_model->find($id_sample);
                                            $nama_sample = $data_sample['nama_sample'];

                                            // $id_pegawai = $value['id_petugas'];

                                            // $data_pegawai = $petugas_model->find($id_pegawai);

                                            $registrasi = $cust_uniq . " - " . $tgl_daftar;
                                            $paket_pemeriksaan = $nama_test . " " . $nama_layanan;
                                            $nomor_pegawai = "";
                                            $nik = $data_customer['nik'];
                                            $nama_peserta = $data_customer['nama'];
                                            $waktu_sampling = $value['waktu_ambil_sampling'];
                                            $waktu_periksa_sampling =  $value['waktu_periksa_sampling'];
                                            $waktu_selesai_periksa = $value['waktu_selesai_periksa'];

                                            $jenis_sample = $nama_sample;

                                            $hasil_swab_pcr = $value['txt_status_swab'];
                                            $hasil_swab_antigen = $value['txt_status_antigen'];
                                            $hasil_rapid_test = $value['txt_status_rapid'];
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $registrasi ?></td>
                                                <td><?= $paket_pemeriksaan; ?></td>
                                                <td><?= $nomor_pegawai ?></td>
                                                <td><?= $nik; ?></td>
                                                <td><?= $nama_peserta; ?></td>
                                                <td><?= $waktu_sampling ?></td>
                                                <td><?= $waktu_periksa_sampling; ?></td>
                                                <td><?= $waktu_selesai_periksa; ?></td>
                                                <td><?= $jenis_sample; ?></td>
                                                <td><?= $hasil_swab_pcr; ?></td>
                                                <td><?= $hasil_swab_antigen; ?></td>
                                                <td><?= $hasil_rapid_test; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        $("#data").DataTable({
            ordering: false
        });
        $(".select2").select2({
            theme: "bootstrap4",
            width: "100%"
        });
    });
</script>
<?= $this->endSection(); ?>