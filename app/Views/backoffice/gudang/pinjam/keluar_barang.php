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
            <form action="<?= base_url('backoffice/' . $page . '/save_masuk_barang'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="status" value="<?= base64_encode('18'); ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-3" for="nama_peminjam">Nama Peminjam</label>
                                    <div class="col-9">
                                        <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" required minlength="4">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="catatan" class="col-md-3">Catatan</label>
                                    <div class="col-md-9">
                                        <textarea name="catatan" id="catatan" class="form-control" id="" cols="5" rows="5" placeholder="(optional)"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="catatan" class="col-md-3">Tanggal Barang Keluar</label>
                                    <div class="col-md-9">
                                        <input name="tgl_keluar" type="datetime" id="tgl_keluar" value="<?= date('Y-m-d H:i:s'); ?>" readonly aria-readonly="true">
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
                    </div>
                </div>
                <div class="row">
                    <div class="card card-primary col-md-6" id="input1">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title; ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <!-- <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-3" for="id_barang1">Barang yang keluar:</label>
                                <div class="col-9">
                                    <select name="id_barang[]" id="id_barang1" class="form-control select2">
                                        <option value="">Pilih Barang</option>
                                        <?php
                                        foreach ($barang as $key => $value) {
                                            echo "<option value=\"{$value['id']}\">{$value['nama_barang']} ({$value['stock']})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="qty">Banyak Item</label>
                                <div class="col-9">
                                    <input type="number" name="qty" id="qty" class="form-control" required min="1">
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    $(document).ready(() => {

    });
</script>
<?= $this->endSection(); ?>