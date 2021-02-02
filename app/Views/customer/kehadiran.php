<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-lg-3">&nbsp;</div>
        <div class="col-lg-9">
            <div id="loading" class="row">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row" id="menus">
                <div class="col-md-6">
                    <?= $message; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Reschedule -->

<?= $this->endSection(); ?>