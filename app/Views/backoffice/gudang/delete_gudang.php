<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header mb-0">
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
    </section>
    <section class="content mt-0">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-danger">
                    <h5 class="card-header"><?= $title; ?></h5>
                    <div class="card-body">
                        <h5>Apakah anda yakin ingin menghapus barang <?= $data['nama_barang']; ?> dari gudang?</h5>
                    </div>
                    <div class="card-footer float-right">
                        <button class="btn btn-default mr-3" type="button" onclick="return history.back()">Batal</button>
                        <a href="<?= base_url('backoffice/gudang/doDelete/' . $id); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                    </div>
                </div>
            </div>
    </section>
</div>

<?= $this->endSection(); ?>