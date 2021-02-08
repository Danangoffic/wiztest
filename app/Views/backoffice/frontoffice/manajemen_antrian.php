<?= $this->extend('backoffice/template/layout_swabber'); ?>
<?= $this->section('content'); ?>
<div class="">
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
                    <div class="callout callout-info">
                        <h5>Data Antrian Bilik <?= $nomor_bilik; ?></h5>
                    </div>
                    <!-- <a href="/backoffice/swabber/create_bilik" class="btn btn-primary btn-sm mb-3">Tambah Data Bilik</a> -->
                </div>
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Antrian Bilik</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>No Antrian</th>
                                        <th>Nomor Bilik</th>
                                        <th>No Reg</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="antrian_bilik"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
        // setInterval(load_detail_antrian, 5000);
        $("table").DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            processing: true
        });
    });

    function load_detail_antrian() {
        let api_get = "<?= base_url("api/get-antrian-panggilan"); ?>";
        let data = {
            nomor_bilik: '<?= $nomor_bilik; ?>'
        }
        $.ajax({
            url: api_get,
            type: "GET",
            data: data,
            success: function(data, status, xhqr) {
                let v = data.antrian;
                var html_antrian = "";
                let str_jam = v.jam_kunjungan;
                // let prefix_urutan = str_jam.substring(0, 2);
                // let urutan = (v.urutan < 10) ? '00' + v.urutan : (v.urutan > 9 && v.urutan < 100) ? '0' + v.urutan : v.urutan;
                // let new_urutan = prefix_urutan + "" + v.no_urutan;
                html_antrian += `<tr><td>${v.no_antrian}</td>
                            <td>${v.nomor_bilik}</td>
                            <td>${v.customer_unique}</td>
                            <td><button type="button" onclick="return next_antrian('${v.id}')" class="btn btn-primary">Antrian Selanjutnya</button></td></tr>`;

                $("#antrian_bilik").html(html_antrian);

            }
        });
    }

    function next_antrian(id_customer) {
        $.post('<?= base_url('backoffice/frontoffice/next_antrian'); ?>', {
            id_customer
        }, function(data) {
            load_detail_antrian();
        });
        // setTimeout(window.location.reload(), 2000);
    }
</script>
<?= $this->endSection(); ?>