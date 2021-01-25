<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= $this->include('backoffice/template/content-header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <h6>Apakah anda yakin untuk menghapus lokasi input dari kota <?= $nama_kota; ?>?</h6>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <form action="<?= base_url('backoffice/' . $page . '/do_delete'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id_lokasi" value="<?= $id; ?>">
                                    <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-danger" id="saveButton" type="submit"><i class="fa fa-save"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>