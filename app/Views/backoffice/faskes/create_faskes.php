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
                    <div class="alert alert-success fade show" role="alert">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php
                }
                if (session()->getFlashdata('error')) {
                ?>
                    <div class="alert alert-warning fade show" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('backoffice/faskes/save'); ?>" method="post">
                            <div class="form-group row">
                                <label class="col-3" for="nama_faskes">Nama Faskes</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nama_faskes" name="nama_faskes" required autocomplete="off" placeholder="Nama Faskes">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="health_facility">Health Facility</label>
                                <div class="col-9">
                                    <input type="text" placeholder="Health Facility" name="health_facility" id="health_facility" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="phone">No HP</label>
                                <div class="col-9">
                                    <input type="number" mode="tel" placeholder="No HP" name="phone" id="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="email">Email</label>
                                <div class="col-9">
                                    <input type="email" mode="email" placeholder="Email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="alamat">Alamat</label>
                                <div class="col-9">
                                    <textarea placeholder="Alamat" name="alamat" id="alamat" class="form-control" class="form-control" cols="10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3" for="nama">Kota</label>
                                <div class="col-9">
                                    <select name="kota" id="kota" class="form-control">
                                        <?php
                                        foreach ($kota as $key => $value) {
                                        ?>
                                            <option value="<?= $value['id']; ?>"><?= $value['nama_kota']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-default" id="backButton" role="button" type="button" onclick="history.back()"><i class="fa fa-chevron-left"></i> Kembali</button>
                                <button class="btn btn-success" id="saveButton" role="button" type="submit"><i class="fa fa-save"></i> Simpan</button>
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
<script>
    $(document).ready(() => {
        $("#data_customer").DataTable();
    });
</script>
<?= $this->endSection(); ?>