<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= $this->include("backoffice/template/content-header"); ?>
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- filtering box -->
                    <div id="accordion">
                        <form action="" method="POST">
                            <div class="card collapsed-card">
                                <div class="card-header" id="headingOne">
                                    <button class="btn btn-default" data-card-widget="collapse">
                                        Filtering
                                    </button>
                                </div>

                                <div class="card-body">

                                    <input type="hidden" name="filtering" value="on">
                                    <div class="form-group row">
                                        <div class="col-md-8 col-offset-3">
                                            <div class="row">
                                                <div class="col-12 row">
                                                    <label for="date1" class="col-md-2 col-form-label">Kloter</label>
                                                    <div class="col-md-6">
                                                        <select name="id_file" id="kloter" class="form-control">
                                                            <?php
                                                            foreach ($data_import as $key => $file) {
                                                            ?>
                                                                <option value="<?= $file['id']; ?>"><?= $file['file']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
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
        </div>
    </section>
    <section class="content mt-0">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <h5 class="card-header"><?= $title; ?></h5>
                    <div class="card-body">
                        <a href="import_data" class="btn btn-success btn-sm mb-3">Import Excel PCR</a>
                        <a href="data_peserta_antigen" class="btn btn-success btn-sm mb-3">Validasi Peserta Antigen</a>
                        <a href="data_peserta_rapid" class="btn btn-success btn-sm mb-3">Validasi Peserta Rapid Test</a>
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
                                    <?php
                                    if ($data_customer_lab != null) {
                                        $no = 1;
                                        foreach ($data_customer_lab as $key => $cust) {
                                            $status_valid = $cust['valid'];
                                            $tipe_row = ($status_valid == "yes") ? "bg-success" : '';
                                            $id_customer = $cust['id_customer'];
                                            $detail_customer = $customer_model->deep_detail_by_id($id_customer)->getRowArray();
                                            $paket_pemeriksaan = $detail_customer['nama_test'] . " " . $detail_customer['nama_layanan'];
                                    ?>
                                            <tr class="<?= $tipe_row; ?>">
                                                <td><?= $no++; ?></td>
                                                <td><?= $detail_customer['tgl_kunjungan']; ?></td>
                                                <td><?= $detail_customer['customer_unique']; ?></td>
                                                <td><?= $paket_pemeriksaan; ?></td>
                                                <td><?= $detail_customer['nik']; ?></td>
                                                <td><?= $detail_customer['nama']; ?></td>
                                                <td><?= $cust['waktu_ambil_sampling']; ?></td>
                                                <td><?= $cust['waktu_periksa_sampling']; ?></td>
                                                <td><?= $cust['waktu_selesai_periksa']; ?></td>
                                                <td><?= $detail_customer['nama_test']; ?></td>
                                                <td><?= $cust['status_cov']; ?></td>
                                                <td><?= $cust['status_gene']; ?></td>
                                                <td><?= $cust['status_orf']; ?></td>
                                                <td><?= $cust['value_ic']; ?></td>
                                                <td><?= $cust['status_igg']; ?></td>
                                                <td><?= $cust['status_igm']; ?></td>
                                                <td></td>
                                                <td>
                                                    <?php
                                                    if ($status_valid != "yes") {
                                                    ?>
                                                        <a class="btn btn-success btn-sm" href="verifikasi_peserta/<?= $cust['id_customer']; ?>" target="_blank" rel="noopener noreferrer">Verifikasi</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php
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
        $("#data_laboratorium").DataTable({
            ordering: false,
            processing: true,
            info: false,
            deferRender: true
        });
        // $.ajax({
        //     url: "<?= base_url('backoffice/laboratorium/get_data_laboratorium'); ?>",
        //     type: "GET",
        //     success: function(data, status, xhr) {
        //         let result = data.data;
        //         let html_hasil;
        //         let no = 1;
        //         $.each(result, (i, v) => {
        //             let bg_status_customer_send = '';
        //             if (v.status_kirim == "Sudah Dikirim") {
        //                 bg_status_customer_send = 'bg-success';
        //             }
        //             html_hasil += `
        //             <tr class="${bg_status_customer_send}">
        //                 <td>${no++}</td>
        //                 <td>${v.tgl_kunjungan}</td>
        //                 <td>${v.registrasi}</td>
        //                 <td>${v.paket_pemeriksaan}</td>
        //                 <td>${v.nik}</td>
        //                 <td>${v.nama_customer}</td>
        //                 <td>${v.waktu_sampling}</td>
        //                 <td>${v.waktu_periksa}</td>
        //                 <td>${v.waktu_selesa_periksa}</td>
        //                 <td>${v.nama_sample}</td>
        //                 <td>${v.status_cov}</td>
        //                 <td>${v.status_gene}</td>
        //                 <td>${v.status_orf}</td>
        //                 <td>${v.ic}</td>
        //                 <td>${v.status_igg}</td>
        //                 <td>${v.status_igm}</td>
        //                 <td>${v.catatan}</td>
        //                 <td>
        //                     <a class="btn btn-success btn-sm" target="_blank" href="/backoffice/laboratorium/input/${v.id_hasil}">Input</a>
        //                     <a class="btn btn-primary btn-sm" target="_blank" href="/backoffice/laboratorium/print/${v.id_hasil}">Cetak Hasil</a>
        //                 </td>
        //             </tr>
        //             `
        //         });
        //         $("#data_hasil2").html(html_hasil);
        //     }
        // })

    });
</script>
<?= $this->endSection(); ?>