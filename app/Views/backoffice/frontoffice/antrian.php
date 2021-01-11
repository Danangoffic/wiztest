<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Filter Tanggal Kunjungan</h5>
                        <form action="<?= base_url('backoffice/frontoffice/antrian_swab_walk_in'); ?>" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="date1" name="date1" value="<?= $filterDate; ?>" max="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= ucwords('Antrian Swab Sameday'); ?></h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-condensed table-hover" id="data_customer">
                                <thead>
                                    <tr>
                                        <th>Jam</th>
                                        <th>Kuota</th>
                                        <th>Jml Booking (tgl <?= $filterDate; ?>) </th>
                                        <th>Antrain</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    use App\Models\CustomerModel;

                                    $no = 1;
                                    foreach ($kuotaSwabSameDay as $key => $value) {
                                        // $DetailInstansi = new Ins
                                        $customer_model =  new CustomerModel();
                                        $jml_booking = $customer_model->customersBooking($value['jenis_test_layanan'], $filterDate, $value['jam'])->get()->getResultArray();
                                        $jml_antrian = $customer_model->customersBooking($value['jenis_test_layanan'], $filterDate, $value['jam'], 'paid', '1')->get()->getResultArray();
                                        // echo db_connect()->showLastQuery();
                                        // exit();
                                    ?>
                                        <tr>
                                            <td><?= $value['jam_int']; ?></td>
                                            <td><?= $value['kuota']; ?></td>
                                            <td><?= count($jml_booking); ?></td>
                                            <td><?= count($jml_antrian); ?></td>
                                            <td>
                                                <a href="<?= base_url('backoffice/antrian/' . $filterDate . '/' . $value['jam_int'] . '/' . $value['jenis_test_layanan']); ?>" class="btn btn-primary btn-sm">Detail</a>
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
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= ucwords('Antrian Swab Basic'); ?></h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-condensed table-hover" id="data_customer2">
                                <thead>
                                    <tr>
                                        <th>Jam</th>
                                        <th>Kuota</th>
                                        <th>Jml Booking (tgl <?= $filterDate; ?>) </th>
                                        <th>Antrain</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $no = 1;
                                    foreach ($kuotaSwabBasic as $key => $value) {
                                        $jml_booking = $customer_model->customersBooking($value['jenis_test_layanan'], $filterDate, $value['jam'])->get()->getResultArray();
                                        // echo 'Jumlah booking query : ' . db_connect()->showLastQuery();
                                        $jml_antrian = $customer_model->customersBooking($value['jenis_test_layanan'], $filterDate, $value['jam'], 'settlement', '1')->get()->getResultArray();
                                        // echo '<br>Jumlah antrian query : ' . db_connect()->showLastQuery();
                                        $booking = count($jml_booking);
                                        $antriian = count($jml_antrian);
                                    ?>
                                        <tr>
                                            <td><?= $value['jam_int']; ?></td>
                                            <td><?= $value['kuota']; ?></td>
                                            <td><?= $booking; ?></td>
                                            <td><?= $antriian; ?></td>
                                            <td>
                                                <a href="<?= base_url('backoffice/antrianbasic/' . $filterDate . '/' . $value['jam_int'] . '/' . $value['jenis_test_layanan']); ?>" class="btn btn-primary btn-sm">Detail</a>
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