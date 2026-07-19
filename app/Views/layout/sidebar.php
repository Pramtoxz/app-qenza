<?php
$session = session();
$userRole = $session->get('role');
$currentUri = service('uri')->getPath();
?>

<style>
.sidebar-section-header {
    padding: 0.625rem 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    color: var(--text-secondary-light);
    font-size: 0.875rem;
    cursor: default;
    opacity: 0.7;
}
@media (min-width: 1650px) {
    .sidebar-section-header { font-size: 1rem; }
}
.sidebar-section-header .menu-icon {
    font-size: 1.125rem;
    margin-inline-end: 0.5rem;
}
@media (min-width: 1650px) {
    .sidebar-section-header .menu-icon {
        font-size: 1.375rem;
        margin-inline-end: 0.75rem;
    }
}
.sidebar-menu .sidebar-submenu.sidebar-open {
    display: block !important;
    padding-block-start: 0.25rem;
}
.sidebar.active .sidebar-submenu.sidebar-open {
    display: none !important;
}
.sidebar.active:hover .sidebar-submenu.sidebar-open {
    display: block !important;
}
</style>

<ul class="sidebar-menu" id="sidebar-menu">
    <?php if ($userRole == 'admin' || $userRole == 'pimpinan') : ?>
    <li class="mb-10">
        <a href="<?= site_url('admin') ?>" class="<?= (strpos($currentUri, 'admin') !== false && strpos($currentUri, 'admin/') === false) ? 'active' : '' ?>">
            <iconify-icon icon="solar:home-smile-outline" class="menu-icon"></iconify-icon>
            <span>Dashboard</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if ($userRole == 'admin') : ?>
    <li class="sidebar-section mb-10">
        <div class="sidebar-section-header">
            <iconify-icon icon="solar:database-outline" class="menu-icon"></iconify-icon>
            <span>Master</span>
        </div>
        <ul class="sidebar-submenu sidebar-open">
          <li>
    <a href="<?= site_url('karyawan') ?>" class="<?= (strpos($currentUri, 'karyawan') !== false) ? 'active' : '' ?>"><i class="ri-user-line circle-icon text-primary-600 w-auto"></i> Karyawan</a>
</li>
<li>
    <a href="<?= site_url('pelanggan') ?>" class="<?= (strpos($currentUri, 'pelanggan') !== false) ? 'active' : '' ?>"><i class="ri-user-smile-line circle-icon text-primary-600 w-auto"></i> Pelanggan</a>
</li>
<li>
    <a href="<?= site_url('paket') ?>" class="<?= (strpos($currentUri, 'paket') !== false) ? 'active' : '' ?>"><i class="ri-archive-line circle-icon text-primary-600 w-auto"></i> Paket Cucian</a>
</li>
        </ul>
    </li>

    <li class="sidebar-section mb-10">
        <div class="sidebar-section-header">
            <iconify-icon icon="solar:hand-pills-linear" class="menu-icon"></iconify-icon>
            <span>Transaksi</span>
        </div>
        <ul class="sidebar-submenu sidebar-open">
         <li>
    <a href="<?= site_url('faktur') ?>" class="<?= (strpos($currentUri, 'faktur') !== false) ? 'active' : '' ?>"><i class="ri-calendar-check-line circle-icon text-primary-600 w-auto"></i> Reservasi</a>
</li>
<li>
    <a href="<?= site_url('selesai') ?>" class="<?= (strpos($currentUri, 'selesai') !== false) ? 'active' : '' ?>"><i class="ri-car-washing-line circle-icon text-primary-600 w-auto"></i> Kendaraan Selesai</a>
</li>
        </ul>
    </li>

    <?php endif; ?>

    <?php if ($userRole == 'admin' || $userRole == 'pimpinan') : ?>
    <li class="sidebar-section mb-10">
        <div class="sidebar-section-header">
            <iconify-icon icon="mingcute:print-line" class="menu-icon"></iconify-icon>
            <span>Laporan</span>
        </div>
        <ul class="sidebar-submenu sidebar-open">
        <li>
    <a href="<?= site_url('laporan-master/pelanggan') ?>" class="<?= (strpos($currentUri, 'laporan-master/pelanggan') !== false) ? 'active' : '' ?>"><i class="ri-user-smile-line circle-icon text-primary-600 w-auto"></i> Pelanggan</a>
</li>
<li>
    <a href="<?= site_url('laporan-master/paket') ?>" class="<?= (strpos($currentUri, 'laporan-master/paket') !== false) ? 'active' : '' ?>"><i class="ri-archive-line circle-icon text-primary-600 w-auto"></i> Paket Cucian</a>
</li>
<li>
    <a href="<?= site_url('laporan-master/karyawan') ?>" class="<?= (strpos($currentUri, 'laporan-master/karyawan') !== false) ? 'active' : '' ?>"><i class="ri-user-line circle-icon text-primary-600 w-auto"></i> Karyawan</a>
</li>
<li>
    <a href="<?= site_url('laporan-transaksi/pencucian') ?>" class="<?= (strpos($currentUri, 'laporan-transaksi/pencucian') !== false) ? 'active' : '' ?>"><i class="ri-checkbox-circle-line circle-icon text-primary-600 w-auto"></i> Cucian Selesai</a>
</li>
<li>
    <a href="<?= site_url('laporan-transaksi/selesai') ?>" class="<?= (strpos($currentUri, 'laporan-transaksi/selesai') !== false) ? 'active' : '' ?>"><i class="ri-money-dollar-circle-line circle-icon text-primary-600 w-auto"></i> Laporan Pendapatan</a>
</li>
<li>
    <a href="<?= site_url('laporan-transaksi/slip-gaji') ?>" class="<?= (strpos($currentUri, 'laporan-transaksi/slip-gaji') !== false) ? 'active' : '' ?>"><i class="ri-wallet-3-line circle-icon text-primary-600 w-auto"></i> Gaji Karyawan</a>
</li>                
    </ul>
    </li>
    <?php endif; ?>
</ul>
