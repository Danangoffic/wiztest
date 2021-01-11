<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <div class="card collapsed-card">
                        <div class="card-header" id="headingOne">
                            <h5 class="card-title">
                                <button type="button" class="btn btn-default" data-card-widget="collapse">
                                    Filtering
                                </button>
                                <!-- <button class="btn btn-default" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Filtering
                                    </button> -->
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <div class="col-8 col-offset-3">
                                        <div class="row">
                                            <label for="date1" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date1" name="date1" value="<?= $date_now; ?>" max="<?= $date_now; ?>">
                                            </div>
                                            <div class="col-sm-2">&nbsp;</div>
                                            <div class="col-sm-10">s/d</div>
                                            <label for="date2" class="col-sm-2 col-form-label">&nbsp;</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date2" name="date2" value="<?= $date_now; ?>" max="<?= $date_now; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>

                        <div id="collapseOne" class="collapsing" aria-labelledby="headingOne" data-parent="#accordion">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-primary" role="alert">
                        <h5 class="">Data Swab</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">APS</th>
                                        <th class="text-center">SAMEDAY</th>
                                        <th class="text-center">BASIC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subSameDay = 0;
                                    $subBasic = 0;
                                    $totalAll = 0;
                                    foreach ($jenis_layanan as $key => $value) {
                                        $dataSameDayCustomer = $kehadiran_model->getFilterByDateLayanan($date1, $date2, $key['id'], '1');
                                        $dataBasicCustomer = $kehadiran_model->getFilterByDateLayanan($date1, $date2, $key['id'], '2');
                                        $totalSameDay = ($dataSameDayCustomer) ? count($dataSameDayCustomer) : 0;
                                        $totalBasic = ($dataBasicCustomer) ? count($dataBasicCustomer) : 0;
                                        $subSameDay = $subSameDay + $totalSameDay;
                                        $subBasic = $subBasic + $totalBasic;
                                        $totalAll += ($subSameDay + $subBasic);
                                    ?>
                                        <tr>
                                            <td><?= $value['nama_layanan']; ?></td>
                                            <td class="text-center"><?= $totalSameDay; ?></td>
                                            <td class="text-center"><?= $totalBasic ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>SUB TOTAL</td>
                                        <td class="text-center"><?= $subSameDay; ?></td>
                                        <td class="text-center"><?= $subBasic; ?></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL</td>
                                        <td colspan="2" class="text-center"><strong><?= $totalAll; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">SEGMEN</th>
                                        <th class="text-center">JUMLAH</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

</script>
<?= $this->endSection(); ?>