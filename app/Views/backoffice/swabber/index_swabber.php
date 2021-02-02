<?= $this->extend('backoffice/template/layout_swabber'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <sectino class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (session()->getFlashdata('success')) {
                    ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                            <p><?= session()->getFlashdata('success'); ?></p>
                        </div>
                    <?php
                    }
                    if (session()->getFlashdata('error')) {
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
    </sectino>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <?php
                    if ($data_bilik != null) :

                    ?>
                        <div class="card card-primary ">
                            <div class="card-header">
                                <h5 class="card-title">Data Swabber</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    // dd($session->get("id_user"));
                                    // dd($data_bilik);
                                    foreach ($data_bilik as $key => $bilik_swabber) {
                                        $id_swabber = $bilik_swabber['assigned_to'];
                                        $swabber = $detail_swabber->where(['id_user' => $id_swabber])->first();
                                        // dd(db_connect()->showLastQuery());
                                        $nama = $swabber['nama'];
                                        $nama = ucwords($nama);
                                        $nomor = $bilik_swabber['nomor_bilik'];
                                    ?>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">Nama</div>
                                                <div class="col-md-8"><strong><?= $nama; ?></strong></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Bilik</div>
                                                <div class="col-md-8"><strong><?= $nomor; ?></strong></div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php

                    endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                if ($session->get("user_level") == 1 || $session->get("user_level") == 99) {
                ?>
                    <div class="col-md-12">
                        <div class="callout callout-info">
                            <h5>Data Antrian Bilik</h5>
                        </div>
                        <a href="/backoffice/swabber/create_bilik" class="btn btn-primary btn-sm mb-3">Tambah Data Bilik</a>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($data_bilik != null) :
                    foreach ($data_bilik as $key => $bilik_swabber) {
                        $swabber = $detail_swabber->find($bilik_swabber['assigned_to']);
                ?>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">Antrian Swabber</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No Antrian</th>
                                                <th>Nama</th>
                                                <th>No Reg</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="antrian_bilik_<?= $bilik_swabber['nomor_bilik'] ?>"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">Booking Swabber</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No Antrian</th>
                                                <th>Nama</th>
                                                <th>No Reg</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="booking_bilik_<?= $bilik_swabber['nomor_bilik'] ?>"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                endif;
                ?>
            </div>
        </div>
    </section>
</div>
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        load_detail_antrian();
        $("table").DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            "processing": true
        });
    });

    function load_detail_antrian() {
        <?php
        if ($data_bilik != null) :
            foreach ($data_bilik as $key => $bilik_swabber) {
                $detail_swabber = $detail_swabber->find($bilik_swabber['assigned_to']);
        ?>
                let api_get = "<?= base_url("api/get_antrian_swabber"); ?>";
                let data = {
                    nomor_bilik: '<?= $bilik_swabber['nomor_bilik']; ?>',
                    requested_by: "<?= $session->get("id_user"); ?>"
                }
                $.ajax({
                    url: api_get,
                    type: "GET",
                    data: data,
                    success: function(data, status, xhqr) {
                        let antrian_swabber = data.antrian_swabber,
                            booking_antrian = data.booking_antrian;
                        var html_antrian = "";
                        $.each(antrian_swabber, (k, v) => {
                            let str_jam = v.jam_kunjungan;
                            let prefix_urutan = str_jam.substring(0, 2);
                            let urutan = (v.urutan < 10) ? '00' + v.urutan : (v.urutan > 9 && v.urutan < 100) ? '0' + v.urutan : v.urutan;
                            let new_urutan = prefix_urutan + "" + urutan;
                            html_antrian += `<tr><td>${new_urutan}</td>
                                    <td>${v.nama}</td>
                                    <td>${v.customer_unique}</td>
                                    <td>${prefix_urutan}</td></tr>`;
                        });
                        var html_booking = "";
                        $.each(booking_antrian, (k, v) => {
                            let str_jam = v.jam_kunjungan;
                            let prefix_urutan = str_jam.substring(0, 2);
                            let urutan = (v.urutan < 10) ? '00' + v.urutan : (v.urutan > 9 && v.urutan < 100) ? '0' + v.urutan : v.urutan;
                            let new_urutan = prefix_urutan + "" + urutan;
                            html_booking += `<tr><td>${new_urutan}</td>
                                    <td>${v.nama}</td>
                                    <td>${v.customer_unique}</td>
                                    <td>${prefix_urutan} <a href="<?= base_url('backoffice/printbarcode/'); ?>${v.id}" class="btn btn-primary">Barcode</a></td></tr>`;
                        });
                        $("#antrian_bilik_" + data.nomor_bilik).html(html_antrian);
                        $("#booking_bilik_" + data.nomor_bilik).html(html_booking);
                        setTimeout(load_detail_antrian, 5000);
                    }
                })
        <?php
            }
        endif;
        ?>
    }
</script>
<?= $this->endSection(); ?>