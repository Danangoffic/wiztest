<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url(); ?>">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="modal" data-target="#modal_cel" data-backdrop="static">
                Waiting..
            </a></li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#modal_reschedule" type="button" data-backdrop="static">RESCHEDULE</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#modal_check_registration" data-backdrop="static">CHECK NO REGISTRATION</a>
        </li>
    </ul>
</nav>