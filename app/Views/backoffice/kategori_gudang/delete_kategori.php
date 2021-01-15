<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
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
                </div>
            </div>
        </div>
    </section>
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <form action="<?= base_url('backoffice/' . $page . '/doDelete/' . $id); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="card-header">
                                <h5 class="card-heading"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">
                                <h5>Apakah anda yakin ingin menghapus kategori gudang <?= $data['nama_kategori']; ?> ?</h5>
                                <input type="hidden" name="id_kategori" value="<?= $id; ?>">
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                <button class="btn btn-danger" id="saveButton" type="submit"><i class="fa fa-trash"></i> Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>