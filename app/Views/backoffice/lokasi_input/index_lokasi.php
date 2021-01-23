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
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url('backoffice/' . $page . '/create'); ?>" class="btn btn-primary mb-3">Tambah Data</a>
                            <table class="table table-bordered table-sm table-condensed" id="data_faskes">
                                <thead>
                                    <tr class="text-center">
                                        <th width="2%">No</th>
                                        <th>Kota</th>
                                        <th>Url Kop</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $key => $value) {
                                        $dataKota = $kota->find($value['id_kota']);
                                        $nama_kota = $dataKota['nama_kota'];
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $nama_kota; ?></td>
                                            <td><?= $value['url_kop']; ?></td>
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