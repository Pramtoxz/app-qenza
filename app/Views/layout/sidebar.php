<?php
$session = session();
$userRole = $session->get('role');
$currentUri = service('uri')->getPath();
?>

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
    <li class="dropdown mb-10">
        <a href="javascript:void(0)">
            <iconify-icon icon="solar:database-outline" class="menu-icon"></iconify-icon>
            <span>Master</span>
        </a>
        <ul class="sidebar-submenu">
            <li>
                <a href="<?= site_url('karyawan') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Karyawan</a>
            </li>
            <li>
                <a href="<?= site_url('pelanggan') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Pelanggan</a>
            </li>
            <li>
                <a href="<?= site_url('paket') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Paket Cucian</a>
            </li>
        </ul>
    </li>

    <li class="dropdown mb-10">
        <a href="javascript:void(0)">
            <iconify-icon icon="solar:hand-pills-linear" class="menu-icon"></iconify-icon>
            <span>Transaksi</span>
        </a>
        <ul class="sidebar-submenu">
            <li>
                <a href="<?= site_url('pencucian') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Reservasi</a>
            </li>
            <li>
                <a href="<?= site_url('selesai') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Kendaraan Selesai</a>
            </li>
        </ul>
    </li>

    <li class="mb-10">
        <a href="<?= site_url('gaji') ?>">
            <iconify-icon icon="solar:dollar-linear" class="menu-icon"></iconify-icon>
            <span>Gaji Karyawan</span>
        </a>
    </li>
    <?php endif; ?>

    <?php if ($userRole == 'admin' || $userRole == 'pimpinan') : ?>
    <li class="dropdown mb-10">
        <a href="javascript:void(0)">
            <iconify-icon icon="mingcute:print-line" class="menu-icon"></iconify-icon>
            <span>Laporan</span>
        </a>
        <ul class="sidebar-submenu">
            <li>
                <a href="<?= site_url('laporan-master/pelanggan') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Pelanggan</a>
            </li>
            <li>
                <a href="<?= site_url('laporan-master/paket') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Paket Cucian</a>
            </li>
            <li>
                <a href="<?= site_url('laporan-master/karyawan') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Karyawan</a>
            </li>
            <li>
                <a href="<?= site_url('laporan-transaksi/pencucian') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Pencucian</a>
            </li>
            <li>
                <a href="<?= site_url('laporan-transaksi/selesai') ?>"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Selesai</a>
            </li>
        </ul>
    </li>
    <?php endif; ?>
</ul>
