<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <button class="btn btn-default" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Filtering
                                </button>
                            </div>

                            <div id="collapseOne" class="collapsing" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <input type="hidden" name="filtering" value="on">
                                        <div class="form-group row">
                                            <div class="col-md-8 col-offset-3">
                                                <div class="row">
                                                    <div class="col-12 row">
                                                        <label for="date1" class="col-md-2 col-form-label">Tanggal Kunjungan</label>
                                                        <div class="col-md-6">
                                                            <input type="date" class="form-control" id="date1" name="date1" value="" max="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 row">
                                                        <div class="col-md-2">&nbsp;</div>
                                                        <div class="col-md-6">s/d</div>
                                                    </div>
                                                    <div class="col-12 row">
                                                        <label for="date2" class="col-md-2 col-form-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="date" class="form-control" id="date2" name="date2" value="" max="">
                                                        </div>
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
            </div>
        </div>
    </section>
    <section class="content mt-0">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <h5 class="card-header"><?= $title; ?></h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-condensed" id="data_laboratorium">
                                <thead class="text-center text-justify">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Registrasi</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="result">
                                    <?php
                                    $no = 1;
                                    foreach ($data_peserta_antigen as $key => $peserta) {
                                        $tgl_kunjungan = $peserta['tgl_kunjungan'];
                                        $registrasi = $peserta['created_at'];
                                        $nik = $peserta['nik'];
                                        $nama = $peserta['nama'];
                                        $id = $peserta['id'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $tgl_kunjungan; ?></td>
                                            <td><?= $registrasi; ?></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td>
                                                <a href="verifikasi_peserta/<?= $id; ?>" target="_blank" class="btn btn-info btn-sm">Verifikasi</a>
                                            </td>
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
    </section>
</div>


<script>
    $(document).ready(() => {
        $("#data_laboratorium").DataTable({
            ordering: false,
            processing: true,
            info: false,
            deferRender: true
        });
    });
</script>
<?= $this->endSection(); ?>