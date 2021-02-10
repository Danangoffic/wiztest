<?= $this->extend('backoffice/template/layout'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header pb-0">

    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?= $title; ?></h5>
                        </div>
                        <div class="card-body">
                            <?php
                            foreach ($data_bilik as $key => $bilik) {
                                $nomor_bilik = $bilik['nomor_bilik'];
                                $js = base_url('/backoffice/frontoffice/manajemen_antrian/' . $nomor_bilik);

                                echo "<a class='btn btn-primary m-2' href='{$js}'>Bilik {$nomor_bilik}</a>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>