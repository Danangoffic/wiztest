<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="/backoffice/peserta/doDelete" method="post">
                        <?= csrf_field() ?>

                        <input type="hidden" name="id_customer" value="<?= base64_encode($id); ?>">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h5 class="card-title"><?= $title; ?> <?= $data_customer['nama']; ?></h5>
                            </div>
                            <div class="card-body">
                                <h5>Apakah anda yakin akan menghapus data peserta <strong><?= $data_customer['nama']; ?></strong> ?</h5>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <a href="/backoffice/registrasi" class="btn btn-default mr-3"><i class="fa fa-chevron-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>