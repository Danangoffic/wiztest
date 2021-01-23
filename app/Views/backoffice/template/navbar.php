<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i> <?= session('nama'); ?> <i class="fa fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="<?= base_url('backoffice/logout'); ?>" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <a href="<?= base_url('backoffice/change-password'); ?>" class="dropdown-item">
                    Ubah Password
                </a>
            </div>
        </li>
    </ul>
</nav>