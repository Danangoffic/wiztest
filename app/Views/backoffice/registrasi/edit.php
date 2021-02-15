<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-heading"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(() => {
        $("#data_customer").DataTable();
    });
</script>
<?= $this->endSection(); ?>