<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <div class="card collapsed-card">
                        <div class="card-header" id="headingOne">
                            <button type="button" class="btn btn-default" data-card-widget="collapse">
                                Filtering
                            </button>
                        </div>

                        <div class="card-body">
                            <form action="<?= base_url('backoffice/home_service'); ?>" method="POST">
                                <input type="hidden" name="filtering" value="on">
                                <div class="form-group row">
                                    <div class="col-md-8 col-offset-3">
                                        <div class="row">
                                            <div class="col-md-12 row">
                                                <label for="date1" class="col-md-3 col-form-label">Tanggal Kunjungan</label>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <a href="home_service/create" class="btn btn-primary mb-3">Tambah Peserta</a>
                            <table class="table table-bordered table-sm table-condensed" id="data_cust">
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
                                    foreach ($customers_home_service as $key => $c_hs) {
                                        $data_customer = $customer_model->where('id_hs', $c_hs['id'])->get()->getResultArray();
                                        if (count($data_customer) > 0) {
                                            foreach ($data_customer as $key => $value) {
                                                // $DetailInstansi = new Ins
                                                $dataInstansi = $instansiModel->find($value['instansi']);
                                                $dataMarketing = $marketingModel->find($value['id_marketing']);
                                                $status_bayar = $value['status_pembayaran'];
                                                if ($status_bayar == "pending" || $status_bayar == "refund") {
                                                    $status_bayar = "<span class='badge bg-warning'>" . $status_bayar . "</span>";
                                                } elseif ($status_bayar == "expire" || $status_bayar == "failure" || $status_bayar == "cancel" || $status_bayar == "deny") {
                                                    $status_bayar = "<span class='badge bg-danger'>" . $status_bayar . "</span>";
                                                } elseif ($status_bayar == "settlement" || $status_bayar == "success") {
                                                    $status_bayar = "<span class='badge bg-success'>" . $status_bayar . "</span>";
                                                }
                                                $nama_marketing = $dataMarketing['nama_marketing'];
                                                $nama_instansi = $dataInstansi['nama'];
                                                $create_tgl_registrasi = strtotime($value['created_at']);
                                                $create_tgl_lahir = strtotime($value['tanggal_lahir']);
                                                $tgl_registrasi = date('d-m-Y', $create_tgl_registrasi);
                                                $tgl_lahir = date('d-m-Y', $create_tgl_lahir);
                                                $getStatus = db_connect()->table('status_hasil')->where('id', $value['kehadiran'])->get()->getFirstRow();
                                                // $detail_status_hadir = $status_hadir->find($value['kehadiran']);
                                                $status_hadir = ucwords($getStatus->nama_status);
                                    ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $value['tgl_kunjungan']; ?></td>
                                                    <td><?= $nama_instansi; ?></td>
                                                    <td><?= $tgl_registrasi; ?> / <?= $value['customer_unique']; ?></td>
                                                    <td><?= $value['nik']; ?></td>
                                                    <td><?= $value['nama']; ?></td>
                                                    <td><?= $value['tempat_lahir'] . ', ' . $tgl_lahir . ' / ' . ucwords($value['jenis_kelamin']); ?></td>
                                                    <td><?= $nama_marketing; ?></td>
                                                    <td><?= $status_bayar; ?></td>
                                                    <td><?= $status_hadir; ?></td>
                                                    <td nowrap>
                                                        <a href="<?= base_url('backoffice/home_service/' . $c_hs['id']); ?>" class="btn btn-primary btn-sm">Detail</a>
                                                        <a href="<?= base_url('backoffice/home_service/hapus/' . $c_hs['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
                                                    </td>
                                                </tr>
                                    <?php
                                                $no++;
                                            }
                                        }
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
        $("#data_cust").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>