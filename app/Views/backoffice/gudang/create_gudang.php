<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header pb-0 mb-0">
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
                    <form action="<?= base_url('backoffice/' . $page . '/save'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="status" value="15">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h5 class="card-title"><?= $title; ?></h5>
                            </div>
                            <div class="card-body">

                                <?= csrf_field(); ?>
                                <div class="form-group row">
                                    <label class="col-3" for="nama_barang">Nama Barang</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= (old('nama_barang')) ? old('nama_barang') : ''; ?>" required autocomplete="off" placeholder="Nama Barang">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama_barang'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="kategori_gudang">Kategori Barang</label>
                                    <div class="col-9">
                                        <select name="kategori_gudang" id="kategori_gudang" class="form-control" required>
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            <?php
                                            foreach ($kategori->findAll() as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>" label="<?= $value['nama_kategori']; ?>"><?= $value['nama_kategori']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3" for="stock">Stock</label>
                                    <div class="col-9">
                                        <input type="number" placeholder="Stock" name="stock" id="stock" class="form-control" required autocomplete="off" value="<?= (old('stock')) ? old('stock') : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gambar_barang" class="col-md-3">Gambar Barang</label>
                                    <div class="col-md-9">
                                        <div class="custom-file">
                                            <input type="file" name="gambar_barang" id="gambar_barang" class="form-control <?= ($validation->hasError('gambar_barang')) ? 'is-invalid' : ''; ?>" accept="image/*" onchange="previewImgBarang()">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('gambar_barang'); ?>
                                            </div>
                                            <label class="custom-file-label" for="gambar_barang">Pilih Gambar Barang</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9 offset-md-3 mt-3">
                                        <img src="" class="img-thumbnail img-preview">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button class="btn btn-default" id="backButton" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-success" id="saveButton" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(() => {

    });

    function previewImgBarang() {
        const barang = document.querySelector('#gambar_barang');
        const barangLabel = document.querySelector('.custom-file-label');
        const imgPreview = document.querySelector('.img-preview');

        barangLabel.textContent = barang.files[0].name;

        const fileBarang = new FileReader();
        fileBarang.readAsDataURL(barang.files[0]);

        fileBarang.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endSection(); ?>