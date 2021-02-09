<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
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
    </section>
    <section class="content">
        <?= form_open('/backoffice/laboratorium/save_verifikasi'); ?>
        <?= form_hidden('id_test', $id_test); ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Peserta</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <?php
                                $id_customer = $detail_customer['id'];
                                $no_registrasi = $detail_customer['customer_unique'];
                                $tgl_registrasi = $detail_customer['created_at'];
                                $nik = $detail_customer['nik'];
                                $nama = $detail_customer['nama'];
                                $tanggal_lahir = $detail_customer['tanggal_lahir'];
                                $jenis_kelamin = $detail_customer['jenis_kelamin'];
                                $waktu_kunjungan = $detail_customer['tgl_kunjungan'] . " " . $detail_customer['jam_kunjungan'];
                                $waktu_sampling = $detail_customer['tgl_kunjungan'];
                                $waktu_periksa = $detail_customer['tgl_kunjungan'];
                                $waktu_selesai = $detail_customer['tgl_kunjungan'];
                                echo form_hidden('id_customer', $id_customer);
                                ?>
                                <tr>
                                    <td>No. Registrasi</td>
                                    <td><?= $no_registrasi; ?></td>
                                </tr>
                                <tr>
                                    <td>Tgl. Registrasi</td>
                                    <td><?= $tgl_registrasi; ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td><?= $nik; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td><?= $nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal lahir/Jenis Kelamin</td>
                                    <td><?= $tanggal_lahir . "/" . $jenis_kelamin; ?></td>
                                </tr>
                                <!-- <tr>
                                    <td><strong>Well</strong></td>
                                    <td>select</td>
                                </tr> -->
                                <tr>
                                    <td>Waktu Kunjungan</td>
                                    <td><?= $waktu_kunjungan; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Sampling</td>
                                    <td><?= $waktu_sampling; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Periksa</td>
                                    <td><?= $waktu_periksa; ?></td>
                                </tr>
                                <tr>
                                    <td>Waktu Selesai</td>
                                    <td><?= $waktu_selesai; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= csrf_field(); ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Hasil Akhir</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <?php

                                $atribut_label = ['class' => 'col-md-4 col-label-form'];

                                echo form_label('Result', 'status_result', $atribut_label);
                                $atribut_result = [
                                    'class' => "form-control select2",
                                    'id' => 'status_result',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_dropdown('status_result', $status_hasil, [], $atribut_result) . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('N gene', 'status_n_gene', $atribut_label);
                                $atribut_ngene = [
                                    'class' => "form-control select2",
                                    'id' => 'status_n_gene',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_dropdown('status_n_gene', $status_ngene, [], $atribut_ngene) . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('ORF1ab', 'status_orf', $atribut_label);
                                $atribut_orf = [
                                    'class' => "form-control select2",
                                    'id' => 'status_orf',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_dropdown('status_orf', $status_orf, [], $atribut_orf) . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('IC', 'nilai_ic', $atribut_label);
                                $atribut_nilai_ic = [
                                    'class' => "form-control",
                                    'id' => 'nilai_ic',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_input('nilai_ic', '0', $atribut_nilai_ic, 'number') . "</div>";
                                ?>
                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Detail Hasil LIS</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <?php
                                echo form_label('Result', 'result', $atribut_label);
                                $atribut_result = [
                                    'class' => "form-control select2",
                                    'id' => 'result',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_dropdown('result', $status_hasil, [], $atribut_result) . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('Gene ORF1ab', 'gene_orf', $atribut_label);
                                $atribut_gene_orf = [
                                    'class' => "form-control select2",
                                    'id' => 'gene_orf',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_dropdown('gene_orf', $status_gene, [], $atribut_gene_orf) . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('CT ORF1ab', 'nilai_ct_orf', $atribut_label);
                                $atribut_ct = [
                                    'class' => "form-control",
                                    'id' => 'nilai_ct_orf',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_input('nilai_ct_orf', '0', $atribut_ct, 'number') . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('Gene Hex/N', 'gene_hex_n', $atribut_label);
                                $atribut_hex_n = [
                                    'class' => "form-control select2",
                                    'id' => 'gene_hex_n',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_dropdown('gene_hex_n', $status_gene_n, [], $atribut_hex_n) . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('CT HEX/N', 'nilai_ct_hex_n', $atribut_label);
                                $atribut_ct_hex_n = [
                                    'class' => "form-control",
                                    'id' => 'nilai_ct_hex_n',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_input('nilai_ct_hex_n', '0', $atribut_ct_hex_n, 'number') . "</div>";
                                ?>
                            </div>
                            <div class="form-group row">
                                <?php
                                echo form_label('IC', 'nilai_ic', $atribut_label);
                                $atribut_nilai_ic = [
                                    'class' => "form-control",
                                    'id' => 'nilai_ic',
                                    'required'
                                ];
                                echo "<div class=\"col-md-8\">" . form_input('nilai_ic', '0', $atribut_nilai_ic, 'number') . "</div>";
                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button class="btn btn-default mr-3" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                <button class="btn btn-success" id="saveButton" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </section>
</div>
<script>
    $(document).ready(function() {
        $("select").select2({
            theme: "bootstrap4"
        })
    })
</script>
<?= $this->endSection(); ?>