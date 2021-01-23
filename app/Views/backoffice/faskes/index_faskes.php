<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= $this->include('backoffice/template/content-header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title; ?></h3>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('backoffice/faskes/create'); ?>" class="btn btn-primary mb-3">Tambah Faskes</a>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-condensed" id="data_faskes">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="2%">No</th>
                                            <th>Nama Faskes/Health Facilty</th>
                                            <th>No Telp</th>
                                            <th>Email</th>
                                            <th width="35%">Alamat</th>
                                            <th>Kota</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data as $key => $value) {
                                            $DetailKota = $kota->find($value['kota']);
                                            $nama_kota = ($DetailKota['nama_kota']) ? $DetailKota['nama_kota'] : '';
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td><?= $value['nama_faskes']; ?> / <?= $value['health_facility']; ?></td>
                                                <td><?= $value['phone']; ?></td>
                                                <td><?= $value['email']; ?></td>
                                                <td><?= $value['alamat']; ?></td>
                                                <td><?= $nama_kota; ?></td>
                                                <td>
                                                    <a href="<?= base_url('backoffice/' . $page . '/edit/' . $value['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <a href="<?= base_url('backoffice/' . $page . '/delete/' . $value['id']); ?>" class="btn btn-danger btn-sm">Hapus</a>
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
        $("#data_faskes").DataTable({
            ordering: false
        });
    });
</script>
<?= $this->endSection(); ?>