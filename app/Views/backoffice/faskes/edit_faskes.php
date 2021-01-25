<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?= $this->include('backoffice/template/content-header'); ?>
    <section class="content mt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="<?= base_url('backoffice/' . $page . '/update/' . $id); ?>" method="post">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><?= $title; ?></h3>
                            </div>
                            <div class="card-body">

                                <input type="hidden" name="id_faskes" value="<?= $id; ?>">
                                <div class="form-group row">
                                    <label class="col-md-4" for="nama_faskes">Nama Faskes</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="nama_faskes" name="nama_faskes" required autocomplete="off" placeholder="Nama Faskes" value="<?= $data['nama_faskes']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="health_facility">Health Facility</label>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="Health Facility" name="health_facility" id="health_facility" class="form-control" required value="<?= $data['health_facility']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="phone">No HP</label>
                                    <div class="col-md-8">
                                        <input type="number" mode="tel" placeholder="No HP" name="phone" id="phone" class="form-control" required value="<?= $data['phone']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="email">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" mode="email" placeholder="Email" name="email" id="email" class="form-control" required value="<?= $data['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="alamat">Alamat</label>
                                    <div class="col-md-8">
                                        <textarea placeholder="Alamat" name="alamat" id="alamat" class="form-control" class="form-control" cols="10" rows="5"><?= $data['alamat']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="nama">Kota</label>
                                    <div class="col-md-8">
                                        <select name="kota" id="kota" class="form-control">
                                            <?php
                                            foreach ($kota as $key => $value) {
                                            ?>
                                                <option value="<?= $value['id']; ?>" <?= ($data['kota'] == $value['id']) ? 'selected' : ''; ?>><?= $value['nama_kota']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    <button class="btn btn-default" id="backButton" role="button" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                    <button class="btn btn-success ml-2" id="saveButton" role="button" type="submit"><i class="fa fa-save"></i> Simpan</button>
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