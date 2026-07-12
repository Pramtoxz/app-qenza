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
$routes->get('pencucian/tracking/(:segment)', 'PencucianController::tracking/$1');

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

$routes->group('pencucian', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'PencucianController::index');
    $routes->get('viewCucian', 'PencucianController::viewCucian');
    $routes->get('formtambah', 'PencucianController::formtambah');
    $routes->post('save', 'PencucianController::save');
    $routes->get('formedit/(:segment)', 'PencucianController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PencucianController::updatedata/$1');
    $routes->get('detail/(:segment)', 'PencucianController::detail/$1');
    $routes->get('cetakAntrian/(:segment)', 'PencucianController::cetakAntrian/$1');
    $routes->get('getpelanggan', 'PencucianController::getPelanggan');
    $routes->get('viewgetpelanggan', 'PencucianController::viewGetPelanggan');
    $routes->get('getpaket', 'PencucianController::getPaket');
    $routes->get('viewgetpaket', 'PencucianController::viewGetPaket');
    $routes->get('getkaryawan', 'PencucianController::getKaryawan');
    $routes->get('viewgetkaryawan', 'PencucianController::viewGetKaryawan');
    $routes->post('delete', 'PencucianController::delete');
    $routes->post('ubahstatus', 'PencucianController::ubahstatus');
    $routes->post('ubahbatal', 'PencucianController::ubahbatal');
    $routes->post('assignKaryawan', 'PencucianController::assignKaryawan');
});

$routes->group('checkout', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'CheckoutController::index');
    $routes->get('viewcheckout', 'CheckoutController::viewCheckout');
    $routes->get('formtambah', 'CheckoutController::formtambah');
    $routes->post('save', 'CheckoutController::save');
    $routes->get('getcheckin', 'CheckoutController::getCheckin');
    $routes->get('viewgetcheckin', 'CheckoutController::viewGetCheckin');
    $routes->post('delete', 'CheckoutController::delete');
    $routes->get('detail/(:segment)', 'CheckoutController::detail/$1');
    $routes->get('faktur/(:segment)', 'CheckoutController::faktur/$1');
    $routes->get('formedit/(:segment)', 'CheckoutController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'CheckoutController::updatedata/$1');
});

$routes->group('gaji', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'GajiController::index');
    $routes->get('viewGaji', 'GajiController::viewGaji');
    $routes->get('formtambah', 'GajiController::formtambah');
    $routes->get('getkaryawan', 'GajiController::getKaryawan');
    $routes->get('viewgetkaryawan', 'GajiController::viewGetKaryawan');
    $routes->post('save', 'GajiController::save');
    $routes->post('hitungUpah', 'GajiController::hitungUpah');
    $routes->get('detail/(:segment)', 'GajiController::detail/$1');
    $routes->get('slip/(:segment)', 'GajiController::slip/$1');
    $routes->get('formedit/(:segment)', 'GajiController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'GajiController::updatedata/$1');
    $routes->post('delete', 'GajiController::delete');
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

    $routes->get('selesai', 'Laporan\LaporanTransaksi::LaporanSelesai');
    $routes->get('selesai/view', 'Laporan\LaporanTransaksi::viewallLaporanSelesai');
    $routes->post('selesai/viewtanggal', 'Laporan\LaporanTransaksi::viewallLaporanSelesaiTanggal');
    $routes->post('selesai/viewbulan', 'Laporan\LaporanTransaksi::viewallLaporanSelesaiBulan');
});




// $routes->post('checkin/debugNewId', 'CheckinController::debugNewId');
// $routes->post('online/debugNewId', 'OnlineController::debugNewId');
// $routes->get('online/debugDatabase', 'OnlineController::debugDatabase');