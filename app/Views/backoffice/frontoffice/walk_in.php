<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-12">
                    <div class="card collapsed-card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button type="button" class="btn btn-default" data-card-widget="collapse">
                                    Filtering
                                </button>

                            </h5>
                        </div>

                        <div class="card-body">
                            <form action="" method="POST">
                                <input type="hidden" name="filtering" value="on">
                                <input type="hidden" name="id_pemeriksaan" value="1">
                                <div class="form-group row">
                                    <div class="col-8 col-offset-3">
                                        <div class="row">
                                            <label for="date1" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date1" name="date1" max="" value="<?= (old('date1')) ? old('date1') : ''; ?>">
                                            </div>
                                            <div class="col-sm-2">&nbsp;</div>
                                            <div class="col-sm-10">s/d</div>
                                            <label for="date2" class="col-sm-2 col-form-label">&nbsp;</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date2" name="date2" value="<?= (old('date2')) ? old('date2') : ''; ?>" max="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-8 col-offset-3">
                                        <div class="row">
                                            <label for="instansi" class="col-sm-2 col-form-label">Instansi</label>
                                            <div class="col-sm-10">
                                                <select name="instansi" id="instansi" class="form-control instansi">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($instansi as $key => $value) {
                                                    ?>
                                                        <option value="<?= $value['id']; ?>" <?= (old('instansi')) ? (old('instansi') == $value['id']) ? 'selected' : '' : ''; ?>><?= $value['nama']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-8 col-offset-3">
                                        <div class="row">
                                            <label for="marketing" class="col-sm-2 col-form-label">Marketing</label>
                                            <div class="col-sm-10">
                                                <select name="marketing" id="marketing" class="form-control marketing">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($marketing as $key => $value) {
                                                    ?>
                                                        <option value="<?= $value['id']; ?>" <?= (old('marketing')) ? (old('marketing') == $value['id']) ? 'selected' : '' : ''; ?>><?= $value['nama_marketing']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-8 col-offset-3">
                                        <div class="row">
                                            <label for="layanan_test" class="col-sm-2 col-form-label">Paket Pemeriksaan</label>
                                            <div class="col-sm-10">
                                                <select name="layanan_test" id="layanan_test" class="form-control marketing">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($layananTest as $key => $value) {
                                                        $detailLayanan = $layananModel->find($value['id_layanan']);
                                                        $detailTest = $testModel->find($value['id_test']);
                                                        $nama_paket = $detailTest['nama_test'] . ' ' . $detailLayanan['nama_layanan'];
                                                    ?>
                                                        <option value="<?= $value['id']; ?>" <?= (old('layanan_test')) ? (old('layanan_test') == $value['id']) ? 'selected' : '' : ''; ?>><?= $nama_paket; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">

        <!-- filtering box -->

        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <h5 class="card-header"><?= $title; ?></h5>
                    <div class="card-body">
                        <a href="<?= base_url('backoffice/peserta/create'); ?>" class="btn btn-success mb-2">Tambah Peserta</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-hover" id="data_customer">
                                <thead>
                                    <tr>
                                        <th>Tgl. Kunjungan</th>
                                        <th>Instansi</th>
                                        <th>Nama</th>
                                        <th>Tgl Lahir</th>
                                        <th>NIK</th>

                                        <th>Paket Pemeriksaan</th>
                                        <th>PIC Marketing</th>
                                        <th>Status Bayar</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    // dd($data_customer);
                                    foreach ($data_customer as $key => $value) {
                                        // $DetailInstansi = new Ins
                                        // $create_tgl_registrasi = date_create($key['created_at']);
                                        // $create_tgl_lahir = date_create($key['tgl_lahir']);
                                        // $tgl_registrasi = date('d-m-Y', strtotime($key['created_at']));
                                        // $tgl_lahir = date('d-m-Y', strtotime($key['tgl_lahir']));

                                        $status_bayar = $value['status_pembayaran'];
                                        if ($status_bayar == "pending" || $status_bayar == "refund") {
                                            $status_bayar = "<span class='badge bg-warning'>" . $status_bayar . "</span>";
                                        } elseif ($status_bayar == "expire" || $status_bayar == "failure" || $status_bayar == "cancel" || $status_bayar == "deny") {
                                            $status_bayar = "<span class='badge bg-danger'>" . $status_bayar . "</span>";
                                        } elseif ($status_bayar == "settlement" || $status_bayar == "success") {
                                            $status_bayar = "<span class='badge bg-success'>" . $status_bayar . "</span>";
                                        }
                                        $status_hadir = ($key['kehadiran'] == 0) ? "Belum Hadir" : "Hadir";
                                        $Marketing = $marketingModel->find($value['id_marketing']);
                                        $nama_marketing = $Marketing['nama_marketing'];
                                        $detailLayananTest = $layananTestModel->find($value['jenis_test']);
                                        $detailLayanan = $layananModel->find($detailLayananTest['id_layanan']);
                                        $detailTest = $testModel->find($detailLayananTest['id_test']);
                                        $nama_paket = $detailTest['nama_test'] . ' ' . $detailLayanan['nama_layanan'];
                                        $Instansi = $instansiModel->find($value['instansi']);
                                        $nama_instansi = $Instansi['nama'];
                                    ?>
                                        <tr>
                                            <td><?= $value['tgl_kunjungan']; ?></td>
                                            <td><?= $nama_instansi; ?></td>
                                            <td><?= $value['nama']; ?></td>
                                            <td><?= $value['tempat_lahir']; ?></td>
                                            <td><?= $value['nik']; ?></td>
                                            <td><?= $nama_paket ?></td>
                                            <td><?= $nama_marketing; ?></td>
                                            <td><?= $status_bayar; ?></td>
                                            <td><?= $value['catatan']; ?></td>
                                            <td>
                                                <a href="<?= base_url('backoffice/peserta/' . $value['id']); ?>" class="btn btn-primary btn-sm">Detail</a>
                                                <!-- <a href="<?= base_url('backoffice/peserta/hapus/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a> -->
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
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
        $("#data_customer").DataTable({
            ordering: false,
            processing: true,
            info: false,
            deferRender: true
        });
    });
</script>
<?= $this->endSection(); ?>