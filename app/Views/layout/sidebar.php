<aside class="main-sidebar sidebar-primary elevation-4">
    <a href="<?= base_url('/') ?>" class="brand-link">
        <img src="<?= base_url() ?>/assets/img/logoqenza.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
        <span class="brand-text font-weight-light">SI-Qenza</span>
    </a>

    <div class="sidebar">
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari Menu" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <?php if(session()->get('role') == 'admin' || session()->get('role') == 'pimpinan'): ?>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/admin" class="nav-link <?= (current_url() == base_url('admin')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(session()->get('role') == 'admin'): ?>
                <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/karyawan" class="nav-link <?= (current_url() == base_url('karyawan')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Karyawan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/pelanggan" class="nav-link <?= (current_url() == base_url('pelanggan')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Pelanggan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/paket" class="nav-link <?= (current_url() == base_url('paket')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Paket Cucian</p>
                    </a>
                </li>
                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/pencucian" class="nav-link <?= (current_url() == base_url('pencucian')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-hand-sparkles"></i>
                        <p>Pencucian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/selesai" class="nav-link <?= (current_url() == base_url('selesai')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Kendaraan Selesai</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(session()->get('role') == 'admin' || session()->get('role') == 'pimpinan'): ?>
                <li class="nav-header">LAPORAN</li>
                <!-- <li class="nav-item">
                    <a href="<?= base_url('laporan-master/pelanggan') ?>" class="nav-link <?= (current_url() == base_url('laporan-master/pelanggan')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>Laporan Pelanggan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('laporan-master/paket') ?>" class="nav-link <?= (current_url() == base_url('laporan-master/paket')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>Laporan Paket Cucian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('laporan-master/karyawan') ?>" class="nav-link <?= (current_url() == base_url('laporan-master/karyawan')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>Laporan Karyawan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('laporan-transaksi/pencucian') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/pencucian')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>Laporan Pencucian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('laporan-transaksi/selesai') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/selesai')) ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>Laporan Selesai</p>
                    </a>
                </li> -->
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>
