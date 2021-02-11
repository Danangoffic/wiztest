<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <form action="<?= base_url('backoffice'); ?>" method="POST">
                        <div class="card collapsed-card">
                            <div class="card-header" id="headingOne">
                                <h5 class="card-title">
                                    <button type="button" class="btn btn-default mr-3" data-card-widget="collapse">
                                        Filtering
                                    </button>
                                    <strong>
                                        <?php

                                        if ($date1 == $date2) {
                                            $dateCreated = date_create($date1);
                                            $newDate = date_format($dateCreated, 'd/m/Y');
                                            echo $newDate;
                                        } else {
                                            $dateCreated = date_create($date1);
                                            $dateCreated2 = date_create($date2);
                                            $newDate = date_format($dateCreated, 'd/m/Y');
                                            $newDate2 = date_format($dateCreated2, 'd/m/Y');
                                            echo "{$newDate} - {$newDate2}";
                                        }
                                        ?>
                                    </strong>
                                    <!-- <button class="btn btn-default" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Filtering
                                    </button> -->
                                </h5>
                            </div>
                            <div class="card-body">

                                <div class="form-group row">
                                    <div class="col-8 col-offset-3">
                                        <div class="row">
                                            <label for="date1" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date1" name="date1" value="<?= (old('date1')) ? old('date1') : $date1; ?>" max="<?= $date_now; ?>">
                                            </div>
                                            <div class="col-sm-2">&nbsp;</div>
                                            <div class="col-sm-10">s/d</div>
                                            <label for="date2" class="col-sm-2 col-form-label">&nbsp;</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="date2" name="date2" value="<?= (old('date2')) ? old('date2') : $date2; ?>" max="<?= $date_now; ?>" min="<?= $date1; ?>">
                                            </div>
                                        </div>
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
    <section class="content mt-0">
        <div class="container-fluid">
            <?php
            foreach ($jenis_test_model as $tester) {
                $id_tester = $tester['id'];
                $nama_tester = $tester['nama_test'];
                if ($id_tester == "1") {
                    $card_temp = "card-primary";
                    $alert_temp = "alert-primary";
                } else if ($id_tester == "2") {
                    $card_temp = "card-success";
                    $alert_temp = "alert-success";
                } else if ($id_tester == "3") {
                    $card_temp = "card-info";
                    $alert_temp = "alert-info";
                }
            ?>
                <div class="row <?= ($id_tester > 1) ? 'mt-2' : ''; ?>">
                    <div class="col-md-12">
                        <div class="alert <?= $alert_temp; ?>">
                            <h4><i class="icon fas fa-info" title="SWAB PCR section"></i> <?= $nama_tester; ?></h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card <?= $card_temp; ?> card-outline">
                            <div class="card-body p-0">
                                <table class="table table-bordered table-condensed table-sm table-hover">
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
                                        foreach ($jenis_pemeriksaan as $key => $value) {
                                            $detail_LayananTestModel = $LayananTestModel->where(['id_test' => $id_tester, 'id_pemeriksaan' => $value['id'], 'id_segmen' => '1'])->get()->getResultArray();
                                            // echo db_connect()->showLastQuery();
                                            // dd($detail_LayananTestModel);
                                            // exit();
                                            // $id_LayananTestModel = $detail_LayananTestModel['id'];
                                            echo "<tr>";
                                            // JENIS APS //
                                            echo "<td>{$value['nama_pemeriksaan']}</td>";
                                            foreach ($detail_LayananTestModel as $key => $layanan) {
                                                $id_layanan = $layanan['id'];
                                                $customers_aps = db_connect()->query("SELECT COUNT(*) as customers_aps FROM customers a 
                                            JOIN data_layanan_test b ON b.id = a.jenis_test
                                            WHERE b.id = '{$id_layanan}' 
                                            AND (a.tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}')")->getFirstRow();
                                                // echo db_connect()->showLastQuery() . "<br><br>";
                                                // $customers_aps = $customers_model->customer_jenis_test_filtering_date_between("count(*) as customers", $id_LayananTestModel, $id_layanan, $date1, $date2);

                                                $customers = $customers_aps->customers_aps;

                                                // TOTAL TIAP JENIS LAYANAN UNTUK TIAP APS
                                                echo "<td class=\"text-center\">{$customers}</td>";

                                                if ($key == 0) {
                                                    $subSameDay += $customers;
                                                } elseif ($key == 1) {
                                                    $subBasic += $customers;
                                                }
                                            }

                                            echo "</tr>";
                                        }

                                        $totalAll = ($subSameDay + $subBasic);
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

                        <div class="card <?= $card_temp; ?> card-outline">
                            <div class="card-body p-0">
                                <table class="table table-bordered table-condensed table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center">RUJUKAN</th>
                                            <th class="text-center">SAMEDAY</th>
                                            <th class="text-center">BASIC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        ?>
                                        <tr>
                                            <td>SUB TOTAL</td>
                                            <?php
                                            $customers_rujukan = 0;
                                            foreach ($jenis_layanan as $key => $jenisLayanan) {
                                                $id_layanan = $jenisLayanan['id'];
                                                $getResultCustomers = db_connect()->query("SELECT COUNT(*) as customers_rujukan FROM customers a 
                                            JOIN data_layanan_test b ON b.id = a.jenis_test 
                                            WHERE b.id_segmen = '3' AND b.id_test = '{$id_tester}' AND b.id_layanan = '{$id_layanan}' 
                                            AND a.tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}';
                                            ")->getFirstRow();
                                                $cust_ruj = $getResultCustomers->customers_rujukan;
                                                $customers_rujukan += $cust_ruj;
                                                echo "<td class = \"text-center\">{$cust_ruj}</td>";
                                            }
                                            ?>
                                            <!-- <td class="text-center"></td>
                                        <td class="text-center"></td> -->
                                        </tr>
                                        <tr>
                                            <td>TOTAL</td>
                                            <td colspan="2" class="text-center"><strong><?= $customers_rujukan; ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                        <div class="card card-outline <?= $card_temp; ?>">
                            <div class="card-body p-0">
                                <table class="table table-bordered table-condensed table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">MARKETING</th>
                                            <th class="text-center">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($marketing_model as $key => $marketing) {
                                            $nama_marketing = $marketing['nama_marketing'];
                                            $id_marketing = $marketing['id'];
                                            $data_marketing = db_connect()->query("SELECT COUNT(*) as customers_marketing FROM customers a 
                                        JOIN data_layanan_test b ON b.id = a.jenis_test
                                         WHERE a.id_marketing = '{$id_marketing}' AND 
                                        (a.tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}') 
                                        AND b.id_test = '{$id_tester}' ;")->getFirstRow();
                                            $customer_marketing = $data_marketing->customers_marketing;
                                            echo "<tr><td>{$nama_marketing}</td>";
                                            echo "<td class=\"text-center\">{$customer_marketing}</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card <?= $card_temp; ?> card-outline">
                            <div class="card-body p-0">
                                <table class="table table-bordered table-condensed table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SEGMEN</th>
                                            <th class="text-center">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_customers = 0;
                                        foreach ($segmen_model->findAll() as $key => $segmen) {
                                            $id_segmen = $segmen['id'];
                                            echo "<tr>";
                                            echo "<td>{$segmen['nama_segmen']}</td>";
                                            $get_data_segmented = db_connect()->query("SELECT count(*) as total_customers FROM customers a 
                                        JOIN data_layanan_test b ON b.id = a.jenis_test 
                                        WHERE b.id_segmen = '{$id_segmen}' AND b.id_test = '{$id_tester}' AND a.tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}'")->getFirstRow();
                                            // echo db_connect()->showLastQuery() . "<br>";
                                            // ->select("count(*) as total_customers")
                                            // ->join('data_layanan_test b', 'b.id = a.jenis_test')
                                            // ->where('b.id_segmen', $id_segmen)
                                            // ->where('b.id_test', '1')->get()->getRowArray();
                                            $segmented_customers = $get_data_segmented->total_customers;
                                            echo "<td class=\"text-center\">{$segmented_customers}</td>";
                                            $total_customers += $segmented_customers;
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="card <?= $card_temp; ?> card-outline">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle" rowspan="2">CORPORATE</th>
                                                <th class="text-center" colspan="2">WALK IN</th>
                                                <th class="text-center" colspan="2">HOME SERVICE</th>
                                                <th class="text-center align-middle" rowspan="2">TOTAL</th>
                                            </tr>
                                            <tr>
                                                <td class="text-center ">SAME DAY</td>
                                                <td class="text-center">BASIC</td>
                                                <td class="text-center">SAME DAY</td>
                                                <td class="text-center">BASIC</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($instansi_model as $key => $corporate) {
                                                // dd($corporate);
                                                echo "<tr>";
                                                $total_each_corporate_customers = 0;
                                                $id_instansi = $corporate['id'];
                                                $nama_instansi = $corporate['nama'];
                                                echo "<td>{$nama_instansi}</td>";
                                                foreach ($jenis_layanan as $key => $layanan_corporate) {
                                                    $id_layanan_c = $layanan_corporate['id'];
                                                    foreach ($jenis_pemeriksaan as $key => $pemeriksaan) {
                                                        $id_pemeriksaan = $pemeriksaan['id'];
                                                        $corporate_each = db_connect()->query("SELECT COUNT(*) as customers_corporate FROM customers a 
                                                                            JOIN data_layanan_test b ON b.id = a.jenis_test 
                                                                            WHERE
                                                                            a.instansi = '{$id_instansi}' AND
                                                                            b.id_layanan = '{$id_layanan_c}' AND 
                                                                            b.id_test = '{$id_tester}' AND
                                                                            b.id_pemeriksaan = '{$id_pemeriksaan}' AND
                                                                            a.tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}'
                                                                            
                                                                            ")->getFirstRow();
                                                        // AND b.id_segmen = '3'
                                                        $customers_corporate = $corporate_each->customers_corporate;
                                                        $total_each_corporate_customers += $customers_corporate;
                                                        echo "<td class=\"text-center\">{$customers_corporate}</td>";
                                                    }
                                                }
                                                echo "<td class=\"text-center\">{$total_each_corporate_customers}</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            <?php
            }
            ?>

        </div>
    </section>
</div>

<script>

</script>
<?= $this->endSection(); ?>