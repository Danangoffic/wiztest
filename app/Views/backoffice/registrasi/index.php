<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">

        <!-- filtering box -->
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Filtering
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapsing" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body bg-light">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <div class="col-8 col-offset-3">
                                    <div class="row">
                                        <label for="date1" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="date1" name="date1" value="" max="">
                                        </div>
                                        <div class="col-sm-2">&nbsp;</div>
                                        <div class="col-sm-10">s/d</div>
                                        <label for="date2" class="col-sm-2 col-form-label">&nbsp;</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="date2" name="date2" value="" max="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading">Data Registrasi</h5>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('registrasi/create'); ?>" class="btn btn-success mb-3">Tambah Peserta</a>
                        <table class="table table-bordered table-condensed table-hover" id="data_customer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl. Kunjungan</th>
                                    <th>Instansi</th>
                                    <th>Registrasi</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>TTL/JK</th>
                                    <th>PIC Marketing</th>
                                    <th>Status Bayar</th>
                                    <th>Status Hadir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data_customer as $key => $value) {
                                    // $DetailInstansi = new Ins
                                    $create_tgl_registrasi = date_create($key['created_at']);
                                    $create_tgl_lahir = date_create($key['tgl_lahir']);
                                    $tgl_registrasi = date_format($create_tgl_registrasi, 'd-m-Y');
                                    $tgl_lahir = date_format($create_tgl_lahir, 'd-m-Y');
                                    $status_bayar = ($key['status_pembayaran'] == "unpaid") ? "Belum Lunas" : "Lunas";
                                    $status_hadir = ($key['kehadiran'] == 0) ? "Belum Hadir" : "Hadir";
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $value['tgl_kunjungan']; ?></td>
                                        <td><?= $value['nama_instansi']; ?></td>
                                        <td><?= $tgl_registrasi; ?>/<?= $value['customer_unique']; ?></td>
                                        <td><?= $value['nik']; ?></td>
                                        <td><?= $value['nama']; ?></td>
                                        <td><?= $value['tempat_lahir'] . ', ' . $tgl_lahir . '/' . ucwords($value['jenis_kelamin']); ?></td>
                                        <td><?= $value['nama_marketing']; ?></td>
                                        <td><?= $status_bayar; ?></td>
                                        <td><?= $status_hadir; ?></td>
                                        <td>
                                            <a href="<?= base_url('backoffice/peserta/' . $value['id']); ?>" class="btn btn-primary btn-sm">Detail</a>
                                            <a href="<?= base_url('backoffice/peserta/hapus/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
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
        $("#data_customer").DataTable();
    });
</script>
<?= $this->endSection(); ?>