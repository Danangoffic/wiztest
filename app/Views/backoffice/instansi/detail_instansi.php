<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <td>Instansi</td>
                                            <td><?= $nama_instansi; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td><?= $alamat; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Peserta</td>
                                            <td><?= $jumlah_customer; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Peserta Hadir</td>
                                            <td><?= $total_kehadiran; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Peserta Tidak Hadir</td>
                                            <td><?= $total_tidak_hadir; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Invoice Terbit</td>
                                            <td><?= $total_invoice_terbit; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama PIC</td>
                                            <td><?= $PIC; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?= form_open(false); ?>
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <button type="button" class="btn btn-default" data-card-widget="collapse">
                                Filtering
                            </button>
                        </div>
                        <div class="card-body">
                            <?= form_hidden('filtering', "on"); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    .<div class="form-group row">
                                        <?= form_label('Tanggal Kunjungan', 'date1', ['class' => 'col-md-4']); ?>
                                        <div class="col-md-8">
                                            <?= form_input('date1', '', ['class' => 'form-control', 'id' => 'date1'], 'date'); ?>
                                            <span>s/d</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">&nbsp;</div>
                                        <div class="col-md-8">
                                            <?= form_input('date2', '', ['class' => 'form-control', 'id' => 'date2'], 'date'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <?= form_label("Paket Pemeriksaan", 'jenis_test', ['class' => 'col-md-4']); ?>
                                        <div class="col-md-8">
                                            <select name="jenis_test" id="jenis_test" class="form-control">
                                                <?php
                                                foreach ($pemeriksaan as $key => $value) {
                                                ?>
                                                    <option value="<?= $value['id']; ?>"><?= $value['text']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <?= form_submit('Filter', 'Filter', ['class' => 'btn btn-primary']); ?>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Data Peserta Instansi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responseive">
                                <table class="table table-bordered table-condensed table-hover" id="data_customer">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl. Kunjungan</th>
                                            <th>Registrasi</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>TTL/JK</th>
                                            <th>Status Bayar</th>
                                            <th>Status Hadir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($customers_instansi as $key => $value) {
                                            // $DetailInstansi = new Ins
                                            $status_bayar = $value['status_pembayaran'];
                                            if ($status_bayar == "pending" || $status_bayar == "refund") {
                                                $status_bayar = "<span class='badge bg-warning'>" . $status_bayar . "</span>";
                                            } elseif ($status_bayar == "expire" || $status_bayar == "failure" || $status_bayar == "cancel" || $status_bayar == "deny") {
                                                $status_bayar = "<span class='badge bg-danger'>" . $status_bayar . "</span>";
                                            } elseif ($status_bayar == "settlement" || $status_bayar == "success") {
                                                $status_bayar = "<span class='badge bg-success'>" . $status_bayar . "</span>";
                                            } else {
                                                $status_bayar = "<span class='badge bg-secondary'>" . $status_bayar . "</span>";
                                            }
                                            $create_tgl_registrasi = strtotime($value['created_at']);
                                            $create_tgl_lahir = strtotime($value['tanggal_lahir']);
                                            $tgl_registrasi = date('d-m-Y', $create_tgl_registrasi);
                                            $tgl_lahir = date('d-m-Y', $create_tgl_lahir);
                                            $getStatus = db_connect()->table('status_hasil')->where('id', $value['kehadiran'])->get()->getFirstRow();
                                            // $detail_status_hadir = $status_hadir->find($value['kehadiran']);
                                            $status_hadir = ucwords($getStatus->nama_status);
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $value['tgl_kunjungan']; ?></td>
                                                <td><?= $tgl_registrasi; ?> / <?= $value['customer_unique']; ?></td>
                                                <td><?= $value['nik']; ?></td>
                                                <td><?= $value['nama']; ?></td>
                                                <td><?= $value['tempat_lahir'] . ', ' . $tgl_lahir . ' / ' . ucwords($value['jenis_kelamin']); ?></td>

                                                <td><?= $status_bayar; ?></td>
                                                <td><?= $status_hadir; ?></td>
                                                <td nowrap>
                                                    <a href="<?= base_url('backoffice/peserta/edit/' . $value['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="<?= base_url('backoffice/peserta/hapus/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
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
    });
</script>
<?= $this->endSection(); ?>