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
                <div class="card card-primary">
                    <h5 class="card-header"><?= $title; ?></h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">Kode Barang</div>
                            <div class="col-md-9"><strong><?= $data['kode_barnag']; ?></strong></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Nama Barang</div>
                            <div class="col-md-9">
                                <<?= $data['nama_barang']; ?> /div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">Kategori Barang</div>
                                <div class="col-md-9"><?= $kategori['nama_kategori']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">Stok Barang</div>
                                <div class="col-md-9"><?= $data['stock']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">Status Barang</div>
                                <div class="col-md-9"><?= $status['nama_status']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">Gambar Barang</div>
                                <div class="col-md-9">
                                    <?php if ($data['image_barang'] !== "") { ?>
                                        <img src="<?= base_url('assets/gudang/' . $data['image_barang']); ?>" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer float-right">
                        <button class="btn btn-default mr-3" type="button" onclick="return history.back()">Kembali</button>
                        <a href="<?= base_url('backoffice/gudang/edit/' . $id); ?>" class="btn btn-success">Edit</a>
                    </div>
                </div>
            </div>
    </section>
</div>

<?= $this->endSection(); ?>