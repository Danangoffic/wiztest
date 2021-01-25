<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= base_url('backoffice/finance/' . $page); ?>" method="POST">
                        <div class="card collapsed-card">
                            <div class="card-header">
                                <button class="btn btn-default" id="filtering" type="button" data-card-widget="collapse">Filtering</button>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="filtering" value="on">
                                <div class="form-group row">
                                    <div class="col-md-8 col-offset-3">
                                        <div class="row mb-3">
                                            <div class="col-md-12 ">
                                                <div class="row">
                                                    <label for="date1" class="col-md-4 col-form-label">Tanggal Registrasi</label>
                                                    <div class="col-md-6">
                                                        <input type="date" class="form-control" id="date1" name="date1" value="<?= (old('date1')) ? old('date1') : $date1; ?>" max="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">&nbsp;</div>
                                                    <div class="col-md-6">s/d</div>
                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <label for="date2" class="col-md-4 col-form-label">&nbsp;</label>
                                                    <div class="col-md-6">
                                                        <input type="date" class="form-control" id="date2" name="date2" value="<?= (old('date2')) ? old('date2') : $date2; ?>" max="">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <label for="instansi" class="col-md-4 col-form-label">Instansi</label>
                                                    <div class="col-md-6">
                                                        <select name="instansi" id="instansi" class="select2 form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $data_instansi = $instansi_model->findAll();
                                                            foreach ($data_instansi as $key => $instansi) {
                                                            ?>
                                                                <option value="<?= $instansi['id']; ?>" <?= (old('instansi')) ? ($instansi['id'] == old('instansi')) ? 'selected' : '' : ''; ?>><?= $instansi['nama']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <label for="marketing" class="col-md-4 col-form-label">PIC Marketing</label>
                                                    <div class="col-md-6">
                                                        <select name="marketing" id="marketing" class="select2 form-control">
                                                            <option value=""></option>
                                                            <?php
                                                            $data_marketing = $marketing_model->findAll();
                                                            foreach ($data_marketing as $key => $marketing) {
                                                            ?>
                                                                <option value="<?= $marketing['id']; ?>" <?= (old('marketing')) ? (old('marketing') == $marketing['id']) ? 'selected' : '' : ''; ?>><?= $marketing['nama_marketing']; ?></option>
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
                            </div>
                            <div class="card-footer">
                                <input type="submit" value="Filter" name="filter_submit" class="btn btn-primary btn-sm mr-3">
                                <input type="submit" value="Print PDF" name="filter_submit" class="btn bg-maroon text-white btn-sm mr-3">
                                <input type="submit" value="Print Excel" name="filter_submit" class="btn btn-success btn-sm">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <?php if ($session->getFlashdata('error')) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Gagal Filtering</h5>
                            <?= $session->getFlashdata('error'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-condensed" id="data_customer">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nomor Invoice</th>
                                            <th>Instansi</th>
                                            <th>ATTN</th>
                                            <th>Total</th>
                                            <th>Vat/PPh</th>
                                            <th>Metode Bayar</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Status Bayar</th>
                                            <th>File</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_customer as $key => $c) {
                                            $nomor_invoice = $c['invoice_number'];
                                            $detail_instansi = $instansi_model->find($c['instansi']);
                                            $nama_instansi = $detail_instansi['nama'];

                                            $detail_marketing = $marketing_model->find('id_marketing');
                                            $nama_marketing = $detail_marketing['nama_marketing'];

                                            $detail_pembayaran = $pembayaran_model->where(['id_customer' => $c['id']])->get()->getRowArray();
                                            $total_pembayaran = $detail_pembayaran['amount'];
                                            $jenis_pembayaran = $detail_pembayaran['jenis_pembayaran'];
                                            $tgl_pembayaran = ($detail_pembayaran['created_at'] !== $detail_pembayaran['updated_at']) ? $detail_pembayaran['updated_at'] : '';
                                            $status_pembayaran = $detail_pembayaran['status_pembayaran'];

                                            $url_download_file_with_ttd = base_url('backoffice/finance/print_invoice/ttd/' . $c['invoice_number']);
                                            $url_download_file = base_url('backoffice/finance/print_invoice/no-ttd/' . $c['invoice_number']);
                                            // $data_user = ($value['id_user'] !== "" || $value['id_user'] !== null) ? $userModel->find(['id' => $value['id_user']]) : '';
                                            // $data_marketing = ($value['pic_marketing'] !== "" || $value['pic_marketing'] !== null) ? $marketingModel->find($value['pic_marketing']) : '';
                                        ?>
                                            <tr>
                                                <td class="text-center align-middle"><?= $no++; ?></td>
                                                <td class="text-center align-middle"><?= $c['tgl_kunjungan']; ?></td>
                                                <td class="align-middle"><?= $nomor_invoice; ?></td>
                                                <td class="align-middle"><?= $nama_instansi; ?></td>
                                                <td class="align-middle"><?= $nama_marketing; ?></td>
                                                <td class="align-middle"><?= $total_pembayaran; ?></td>
                                                <td class="text-center align-middle">Vat</td>
                                                <td class="align-middle"><?= $jenis_pembayaran; ?></td>
                                                <td class="text-center align-middle"><?= $tgl_pembayaran; ?></td>
                                                <td class="text-center align-middle"><?= $status_pembayaran; ?></td>
                                                <td class="align-middle">
                                                    <a href="<?= $url_download_file_with_ttd; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-default btn-sm mb-0">Download File (ttd)</a><br>
                                                    <a href="<?= $url_download_file; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-default btn-sm">Download Files</a>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="<?= base_url('backoffice/finance/edit/' . $c['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="<?= base_url('backoffice/finance/delete/' . $c['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
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
        $("#data_customer").DataTable({
            ordering: false
        });
        $(".select2").select2({
            theme: "bootstrap4"
        });
    });
</script>
<?= $this->endSection(); ?>