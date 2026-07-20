<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



// Auth Routes
$routes->get('/', 'Home::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->post('auth/change-password', 'Auth::changePassword');

// Public Tracking Routes
$routes->get('tracking', 'Home::tracking');
$routes->get('faktur/tracking/(:segment)', 'FakturController::tracking/$1');

// Forgot Password dengan OTP
// $routes->get('auth/forgot-password', 'Auth::forgotPassword');
// $routes->post('auth/forgot-password', 'Auth::forgotPassword');
// $routes->post('auth/verify-forgot-password-otp', 'Auth::verifyForgotPasswordOTP');
// $routes->post('auth/reset-password', 'Auth::resetPassword');

// Resend OTP



// Admin dashboard (protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
});


$routes->group('pelanggan', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'PelangganController::index');
    $routes->get('viewPelanggan', 'PelangganController::viewPelanggan');
    $routes->get('formtambah', 'PelangganController::formtambah');
    $routes->post('save', 'PelangganController::save');
    $routes->get('formedit/(:segment)', 'PelangganController::formedit/$1');
    $routes->post('update', 'PelangganController::update');
    $routes->post('updatedata', 'PelangganController::updatedata');
    $routes->get('detail/(:segment)', 'PelangganController::detail/$1');
    $routes->post('delete', 'PelangganController::delete');
});
$routes->group('karyawan', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'KaryawanController::index');
    $routes->get('viewKaryawan', 'KaryawanController::viewKaryawan');
    $routes->get('formtambah', 'KaryawanController::formtambah');
    $routes->post('save', 'KaryawanController::save');
    $routes->get('formedit/(:segment)', 'KaryawanController::formedit/$1');
    $routes->post('updatedata', 'KaryawanController::updatedata');
    $routes->get('detail/(:segment)', 'KaryawanController::detail/$1');
    $routes->post('delete', 'KaryawanController::delete');
});


$routes->group('paket', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'PaketController::index');
    $routes->get('viewPaket', 'PaketController::viewPaket');
    $routes->get('formtambah', 'PaketController::formtambah');
    $routes->post('save', 'PaketController::save');
    $routes->get('formedit/(:segment)', 'PaketController::formedit/$1');
    $routes->post('updatedata', 'PaketController::updatedata');
    $routes->post('delete', 'PaketController::delete');
    $routes->get('detail/(:segment)', 'PaketController::detail/$1');
});

$routes->group('faktur', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'FakturController::index');
    $routes->get('viewFaktur', 'FakturController::viewFaktur');
    $routes->get('formtambah', 'FakturController::formtambah');
    $routes->post('save', 'FakturController::save');
    $routes->get('detail/(:segment)', 'FakturController::detail/$1');
    $routes->get('getpelanggan', 'FakturController::getPelanggan');
    $routes->get('viewgetpelanggan', 'FakturController::viewGetPelanggan');
    $routes->get('getpaket', 'FakturController::getPaket');
    $routes->get('viewgetpaket', 'FakturController::viewGetPaket');
    $routes->get('getkaryawan', 'FakturController::getKaryawan');
    $routes->get('viewgetkaryawan', 'FakturController::viewGetKaryawan');
    $routes->post('assignKaryawan', 'FakturController::assignKaryawan');
    $routes->post('ubahstatus', 'FakturController::ubahstatus');
    $routes->post('ubahbatal', 'FakturController::ubahbatal');
    $routes->post('delete', 'FakturController::delete');
    $routes->get('cetakAntrian/(:segment)', 'FakturController::cetakAntrian/$1');
    $routes->get('formedit/(:segment)', 'FakturController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'FakturController::updatedata/$1');
});

$routes->group('selesai', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'SelesaiController::index');
    $routes->get('viewSelesai', 'SelesaiController::viewSelesai');
    $routes->get('formtambah', 'SelesaiController::formtambah');
    $routes->post('save', 'SelesaiController::save');
    $routes->get('getpencuciandijemput', 'SelesaiController::getPencucianDijemput');
    $routes->get('viewgetpencuciandijemput', 'SelesaiController::viewGetPencucianDijemput');
    $routes->post('delete', 'SelesaiController::delete');
    $routes->get('formedit/(:segment)', 'SelesaiController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'SelesaiController::updatedata/$1');
    $routes->get('detail/(:segment)', 'SelesaiController::detail/$1');
});


//Laporan
$routes->group('laporan-master', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('pelanggan', 'Laporan\LaporanMaster::LaporanPelanggan');
    $routes->get('pelanggan/view', 'Laporan\LaporanMaster::viewallLaporanPelanggan');
    $routes->get('karyawan', 'Laporan\LaporanMaster::LaporanKaryawan');
    $routes->get('karyawan/view', 'Laporan\LaporanMaster::viewallLaporanKaryawan');
    $routes->get('paket', 'Laporan\LaporanMaster::LaporanPaket');
    $routes->get('paket/view', 'Laporan\LaporanMaster::viewallLaporanPaket');
});

$routes->group('laporan-transaksi', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('pencucian', 'Laporan\LaporanTransaksi::LaporanPencucian');
    $routes->get('pencucian/view', 'Laporan\LaporanTransaksi::viewallLaporanPencucian');
    $routes->post('pencucian/viewtanggal', 'Laporan\LaporanTransaksi::viewallLaporanPencucianTanggal');
    $routes->post('pencucian/viewbulan', 'Laporan\LaporanTransaksi::viewallLaporanPencucianBulan');
    $routes->post('pencucian/viewtahun', 'Laporan\LaporanTransaksi::viewallLaporanPencucianTahun');

    $routes->get('selesai', 'Laporan\LaporanTransaksi::LaporanSelesai');
    $routes->get('selesai/view', 'Laporan\LaporanTransaksi::viewallLaporanSelesai');
    $routes->post('selesai/viewtanggal', 'Laporan\LaporanTransaksi::viewallLaporanSelesaiTanggal');
    $routes->post('selesai/viewbulan', 'Laporan\LaporanTransaksi::viewallLaporanSelesaiBulan');
    $routes->post('selesai/viewtahun', 'Laporan\LaporanTransaksi::viewallLaporanSelesaiTahun');

    $routes->get('slip-gaji', 'Laporan\LaporanTransaksi::SlipGaji');
    $routes->post('slip-gaji/getkaryawan', 'Laporan\LaporanTransaksi::getKaryawanSlipGaji');
    $routes->post('slip-gaji/cetak', 'Laporan\LaporanTransaksi::cetakSlipGaji');
});




// $routes->post('checkin/debugNewId', 'CheckinController::debugNewId');
// $routes->post('online/debugNewId', 'OnlineController::debugNewId');
// $routes->get('online/debugDatabase', 'OnlineController::debugDatabase');