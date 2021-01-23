<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Antrian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('backoffice'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $subcontent_url; ?>">Antrian <?= $subcontent; ?></a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Antrian Swabber</div>
                        </div>
                        <div class="card-body p-0 pb-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover" id="data_customer">
                                    <thead>
                                        <tr>
                                            <th>No Antrian</th>
                                            <th>Nama</th>
                                            <th>No Reg</th>
                                            <th>Jam Kunjungan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data_antrian_swabber">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Booking Antrian</div>
                        </div>
                        <div class="card-body p-0 pb-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover" id="data_customer">
                                    <thead>
                                        <tr>
                                            <th>No Antrian</th>
                                            <th>Nama</th>
                                            <th>No Reg</th>
                                            <th>Jam Kunjungan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data_booking_antrian">

                                    </tbody>
                                </table>
                            </div>
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
        load_detail_antrian();
        $("table").DataTable({
            searching: false,
            ordering: false,
            lengthChange: false,
            processing: true,
            info: false
        });
    });

    function load_detail_antrian() {
        $.ajax({
            url: "<?= base_url('backoffice/frontoffice/load_detail_antrian'); ?>",
            type: 'GET',
            data: {
                tanggal: '<?= $tanggal; ?>',
                id_jenis_test: '<?= $id_jenis_test; ?>',
                jam: '<?= $jam; ?>',
                requested_by: '<?= $session->get('id_user'); ?>'
            },
            success: function(data, status, xhqr) {
                let antrian_swabber = data.antrian_swabber,
                    booking_antrian = data.booking_antrian;
                var html_antrian = "";
                $.each(antrian_swabber, (k, v) => {
                    let str_jam = v.jam_kunjungan;
                    let prefix_urutan = str_jam.substring(0, 2);
                    let urutan = (v.urutan < 10) ? '00' + v.urutan : (v.urutan > 9 && v.urutan < 100) ? '0' + v.urutan : v.urutan;
                    let new_urutan = prefix_urutan + "" + urutan;
                    html_antrian += `<td>${new_urutan}</td>
                                    <td>${v.nama}</td>
                                    <td>${v.customer_unique}</td>
                                    <td>${prefix_urutan}</td>`;
                });
                var html_booking = "";
                $.each(booking_antrian, (k, v) => {
                    let str_jam = v.jam_kunjungan;
                    let prefix_urutan = str_jam.substring(0, 2);
                    let urutan = (v.urutan < 10) ? '00' + v.urutan : (v.urutan > 9 && v.urutan < 100) ? '0' + v.urutan : v.urutan;
                    let new_urutan = prefix_urutan + "" + urutan;
                    html_booking += `<td>${new_urutan}</td>
                                    <td>${v.nama}</td>
                                    <td>${v.customer_unique}</td>
                                    <td>${prefix_urutan} <a href="<?= base_url('backoffice/printbarcode/'); ?>${v.id}" class="btn btn-primary">Barcode</a></td>`;
                });
                $("#data_antrian_swabber").html(html_antrian);
                $("#data_booking_antrian").html(html_booking);
                setTimeout(load_detail_antrian, 2000);
            }
        });
    }
</script>
<?= $this->endSection(); ?>