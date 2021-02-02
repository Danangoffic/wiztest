<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h5 class="card-title"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <h6>Apakah anda yakin akan menghapus instansi <?= $data_instansi['nama']; ?></h6>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <form action="/backoffice/instansi/doDelete_instansi" method="post">
                                <input type="hidden" name="id_instansi" value="<?= $id; ?>">
                                <a href="/backoffice/registrasi/instansi" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Batal</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>