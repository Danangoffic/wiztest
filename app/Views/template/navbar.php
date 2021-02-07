<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
    <a class="navbar-brand" href="<?= base_url(); ?>">QuickTest</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <!-- <ul class="navbar-nav">

        </ul> -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url(); ?>">Home</a>
            </li>
            <li class="nav-item"><a href="/home-service" class="nav-link">
                    Home Service
                </a></li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="modal" data-target="#modal_reschedule" type="button" data-backdrop="static">RESCHEDULE</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="modal" data-target="#modal_check_registration" data-backdrop="static">CHECK NO REGISTRATION</a>
            </li>
        </ul>
    </div>

</nav>