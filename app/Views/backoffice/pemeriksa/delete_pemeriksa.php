<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-12">
                <?php
                if (session()->getFlashdata('success')) {
                ?>
                    <div class="alert alert-success">
                        <p><?= session()->getFlashdata('success'); ?></p>
                    </div>
                <?php
                }
                if (session()->getFlashdata('error')) {
                ?>
                    <div class="alert alert-warning">
                        <p><?= session()->getFlashdata('error'); ?></p>
                    </div>
                <?php
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <h6>Apakah anda yakin untuk menghapus kota <?= $data['nama']; ?>?</h6>
                        <form action="<?= base_url('backoffice/' . $page . '/do_delete/' . $id); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_pemeriksa" value="<?= $id; ?>">
                            <div class="form-group">
                                <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                <button class="btn btn-danger" id="saveButton" type="submit"><i class="fa fa-save"></i> Hapus</button>
                            </div>
                        </form>
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
<?= $this->endSection(); ?>