<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= base_url('backoffice/frontoffice/antrian_swab_walk_in'); ?>" method="POST">
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <button type="button" class="btn btn-default" data-card-widget="collapse">
                                    Filtering
                                </button>
                            </div>

                            <!-- <h5 class="card-header">Filter Tanggal Kunjungan</h5> -->

                            <input type="hidden" name="filtering" value="on">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="date1" name="date1" value="<?= (old('date1')) ? old('date1') : $filterDate; ?>" max="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                foreach ($data_layanan_test as $key => $value) {
                    $detail_layanan = $layanan_model->find($value['id_layanan']);
                    $detail_test = $test_model->find($value['id_test']);
                    $nama_layanan = $detail_layanan['nama_layanan'];
                    $nama_test = $detail_test['nama_test'];
                    $jenis_test_layanan = $value['id_layanan'];
                ?>
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="card-title">Antrian <?= $nama_test . " " . $nama_layanan; ?> (Tanggal : <?= $filterDate; ?>)</div>
                            </div>
                            <div class="card-body p-0 pb-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-hover" id="data_customer">
                                        <thead>
                                            <tr>
                                                <th>Jam</th>
                                                <th>Kuota</th>
                                                <th>Jml Booking </th>
                                                <th>Antrain</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $kuota_swab = $kuota_model->where(['jenis_test_layanan' => $jenis_test_layanan])->get()->getResultArray();
                                            foreach ($kuota_swab as $key => $value) {
                                                // $DetailInstansi = new Ins
                                                $jml_booking = $customer_model->customersBooking($value['jenis_test_layanan'], $filterDate, $value['jam'])->get()->getResultArray();
                                                $jml_antrian = $customer_model->customersBooking($value['jenis_test_layanan'], $filterDate, $value['jam'], 'settlement', '1')->get()->getResultArray();
                                                // echo db_connect()->showLastQuery();
                                                // exit();
                                            ?>
                                                <tr>
                                                    <td><?= $value['jam']; ?></td>
                                                    <td class="text-center"><?= $value['kuota']; ?></td>
                                                    <td class="text-center"><?= count($jml_booking); ?></td>
                                                    <td class="text-center"><?= count($jml_antrian); ?></td>
                                                    <td>
                                                        <a href="<?= base_url("backoffice/frontoffice/detail_antrian/{$jenis_test_layanan}/{$filterDate}/"  . intval($value['jam'])); ?>" class="btn btn-primary btn-sm">Detail</a>
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
                <?php
                }
                ?>
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
        $("#data_customer, #data_customer2").DataTable({
            searching: false,
            ordering: false,
            lengthChange: false,
            processing: true,
            info: false
        });
    });
</script>
<?= $this->endSection(); ?>