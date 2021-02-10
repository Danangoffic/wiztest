<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('backoffice'); ?>" class="brand-link">
        <img src="<?= base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">QuickTest</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/default-profile.png'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $session->get('nama'); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= base_url('backoffice'); ?>" class="nav-link <?= ($page == "dashboard") ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php
                $menu_open = ($page == 'walk_in' || $page == 'antrian_swab_walk_in' || $page == 'antrian_rapid_antigen' || $page == 'home_service') ? 'menu-is-open menu-open' : '';
                $menu_aktif = ($page == 'walk_in' || $page == 'antrian_swab_walk_in' || $page == 'antrian_rapid_antigen' || $page == 'home_service') ? 'active' : '';
                ?>
                <li class="nav-item <?= $menu_open; ?>">
                    <a href="#" class="nav-link <?= $menu_aktif; ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Frontoffice <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/frontoffice/walk_in'); ?>" class="nav-link <?= ($page == "walk_in") ? 'active' : ''; ?>">
                                <i class="far fa-circle"></i>
                                <small>Walk in</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/frontoffice/antrian_swab_walk_in'); ?>" class="nav-link <?= ($page == "antrian_swab_walk_in") ? 'active' : ''; ?>">
                                <i class="far fa-circle"></i>
                                <small>Antrian Swab Walk In</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/frontoffice/antrian_rapid_antigen'); ?>" class="nav-link <?= ($page == "antrian_rapid_antigen") ? 'active' : ''; ?>">
                                <i class="far fa-circle"></i>
                                <small>Antrian Rapid/Antigen Walkin</small>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/home_service'); ?>" class="nav-link <?= ($page == "home_service") ? 'active' : ''; ?>">
                                <i class="far fa-circle"></i>
                                <small>Home Service</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                $menu_open = ($page == 'registrasi' || $page == 'registrasi_overkuota' || $page == 'instansi') ? 'menu-is-open menu-open' : '';
                $menu_aktif = ($page == 'registrasi' || $page == 'registrasi_overkuota' || $page == 'instansi') ? 'active' : '';
                ?>
                <li class="nav-item <?= $menu_open; ?>">
                    <a href="#" class="nav-link <?= $menu_aktif; ?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Registrasi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/registrasi'); ?>" class="nav-link <?= ($page == 'registrasi') ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Registrasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/pesert_overkuota/create'); ?>" class="nav-link <?= ($page == 'registrasi_overkuota') ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Registrasi Over Kuota</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/instansi'); ?>" class="nav-link <?= ($page == 'instansi') ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Instansi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Laboratorium
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/laboratorium/validasi'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Validasi Hasil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/laboratorium/hasil'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hasil Pemeriksaan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                $menu_open = ($page == 'reporting_hasil' || $page == 'reporting_marketing' || $page == 'reporting_dinkes') ? 'menu-is-open menu-open' : '';
                $menu_aktif = ($page == 'reporting_hasil' || $page == 'reporting_marketing' || $page == 'reporting_dinkes') ? 'active' : '';
                ?>
                <li class="nav-item <?= $menu_open; ?>">
                    <a href="#" class="nav-link <?= $menu_aktif; ?>">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/backoffice/reporting/hasil" class="nav-link <?= ($page == "reporting_hasil") ? "active" : ""; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Hasil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/backoffice/reporting/marketing" class="nav-link <?= ($page == "reporting_marketing") ? "active" : ""; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Marketing</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/customer/kehadiran'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Kehadiran Peserta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/backoffice/reporting/dinkes" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Dinkes</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Finance
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/finance/instansi'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Instansi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/finance/invoice'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/finance/invoice_aps'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Invoice APS</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Master Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/faskes'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Faskes Asal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/dokter'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dokter Pemeriksa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/petugas'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Petugas Pemeriksa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/kota'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Master Kota</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/lokasi_input'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lokasi Penginputan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/user'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Master User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Pengaturan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/settings'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/user/activity'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Log Activity Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tools
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/print/barcode'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Barcode</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/print/hasil'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Hasil</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Pengelolaan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/setting/broadcasting'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Broadcasting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/setting/peserta'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Peserta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/kategori_gudang'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('backoffice/gudang'); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gudang</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/swabber" class="nav-link">
                        <p>Swabber</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>Antrian Swab</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>Antrian Rapid/Antigen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>Tampilan Antrian Swab</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>Tampilan Antrian Rapid/Antigen</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>