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
                                    <form action="<?= base_url('backoffice/laboratorium/hasil'); ?>" method="POST">
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
                        <a href="import_data" class="btn btn-success btn-sm mb-3">Import Excel PCR</a>
                        <a href="insert_antigen" class="btn btn-success btn-sm mb-3">Insert Data Antigen</a>
                        <a href="insert_rapid" class="btn btn-success btn-sm mb-3">Insert Data Rapid Test</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-condensed" id="data_laboratorium">
                                <thead class="text-center text-justify">
                                    <tr>
                                        <th rowspan="2" center="align-middle">No</th>
                                        <th rowspan="2">Tanggal Kunjungan</th>
                                        <th rowspan="2">Registrasi</th>
                                        <th rowspan="2">Paket Pemeriksaan</th>
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">Nama</th>
                                        <th rowspan="2">Waktu Sampling</th>
                                        <th rowspan="2">Waktu Periksa</th>
                                        <th rowspan="2">Waktu Selesai Periksa</th>
                                        <th rowspan="2">Jenis Sample</th>
                                        <th colspan="4">Swab Test / PCR</th>
                                        <th colspan="2">Rapid Test</th>
                                        <th rowspan="2">Catatan</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Result</th>
                                        <th>N&nbsp;Gene</th>
                                        <th>ORF1ab</th>
                                        <th>IC</th>
                                        <th>Anti SARS-<br>COV-2<br>IgG</th>
                                        <th>Anti SARS-<br>COV-2<br>IgM</th>
                                    </tr>
                                </thead>
                                <tbody id="data_hasil2">
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
        $("#data_laboratorium").DataTable({
            ordering: false,
            processing: true,
            info: false,
            deferRender: true
        });
        $.ajax({
            url: "<?= base_url('backoffice/laboratorium/get_data_laboratorium'); ?>",
            type: "GET",
            success: function(data, status, xhr) {
                let result = data.data;
                let html_hasil;
                let no = 1;
                $.each(result, (i, v) => {
                    let bg_status_customer_send = '';
                    if (v.status_kirim == "Sudah Dikirim") {
                        bg_status_customer_send = 'bg-success';
                    }
                    html_hasil += `
                    <tr class="${bg_status_customer_send}">
                        <td>${no++}</td>
                        <td>${v.tgl_kunjungan}</td>
                        <td>${v.registrasi}</td>
                        <td>${v.paket_pemeriksaan}</td>
                        <td>${v.nik}</td>
                        <td>${v.nama_customer}</td>
                        <td>${v.waktu_sampling}</td>
                        <td>${v.waktu_periksa}</td>
                        <td>${v.waktu_selesa_periksa}</td>
                        <td>${v.nama_sample}</td>
                        <td>${v.status_cov}</td>
                        <td>${v.status_gene}</td>
                        <td>${v.status_orf}</td>
                        <td>${v.ic}</td>
                        <td>${v.status_igg}</td>
                        <td>${v.status_igm}</td>
                        <td>${v.catatan}</td>
                        <td>
                            <a class="btn btn-success btn-sm" target="_blank" href="/backoffice/laboratorium/input/${v.id_hasil}">Input</a>
                            <a class="btn btn-primary btn-sm" target="_blank" href="/backoffice/laboratorium/print/${v.id_hasil}">Cetak Hasil</a>
                        </td>
                    </tr>
                    `
                });
                $("#data_hasil2").html(html_hasil);
            }
        })

    });
</script>
<?= $this->endSection(); ?>