<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (session()->getFlashdata('success')) {
                ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                        <p><?= session()->getFlashdata('success'); ?></p>
                    </div>
                <?php
                }
                if (session()->getFlashdata('error')) {
                ?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Gagal!</h5>
                        <p><?= session()->getFlashdata('error'); ?></p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>