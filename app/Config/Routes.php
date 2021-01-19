<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Customer');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Customer::index');
$routes->add('/backoffice', 'backoffice\Home::index');
$routes->get('/backoffice/login', 'backoffice\User::login');
$routes->post('/backoffice/login', 'backoffice\User::doLogin');


$routes->get('/detail_form2', 'Customer::detail_form2');
$routes->get('/cek_jadwal', 'Customer::jadwal_available');
$routes->get('/menu', 'Customer::getMenu');
$routes->post('/api/registration', 'Customer::registrasi');
$routes->post('/api/get_server_key', 'Customer::get_server_key');
$routes->post('/api/update_status', 'Customer::update_data_customer_registration');
$routes->post('/api/getQRByOrderId', 'Customer::get_qr_by_order_id');
$routes->get('/api/hadir/(:num)', 'backoffice\Peserta::kehadiran_by_scanning_qr/$1');
// $routes->post('/api/midtrans_notification', 'Customer::midtrans_notification');
$routes->add('/api/notification', 'Midtrans_handlers::index');
$routes->add('/api/redirection-handler', 'Midtrans_handlers::redirection_handler');
$routes->add('/api/test-email/(:any)', 'Midtrans_handlers::CobaSendEmail/$1');

$routes->get('detail_form2', 'Customer::detail_form2');


// $routes->get('/backoffice/peserta/edit/(:num)', 'backoffice\Registrasi::edit_peserta/$1');

$routes->get('/backoffice/print/barcode/(:any)', 'backoffice\Layanan::printbarcode/$1');
$routes->get('/backoffice/print/qrcode/(:num)', 'backoffice\Layanan::print_qrcode/$1');
$routes->get('/backoffice/print/pdf/(:num)', 'backoffice\Layanan::print_pdf/$1');

$routes->get('/backoffice/instansi', 'backoffice\Instansi::index');
$routes->get('/backoffice/instansi/(:num)', 'backoffice\Instansi::detail_instansi/$1');
$routes->get('/backoffice/instansi/create', 'backoffice\Instansi::create_instansi');
$routes->post('/backoffice/instansi/save', 'backoffice\Instansi::save_instansi');
$routes->get('/backoffice/instansi/edit/(:num)', 'backoffice\Instansi::edit_instansi/$1');
$routes->post('/backoffice/instansi/update/(:num)', 'backoffice\Instansi::update_instansi/$1');
$routes->get('/backoffice/instansi/delete/(:num)', 'backoffice\Instansi::delete_instansi/$1');
$routes->post('/backoffice/instansi/deleting', 'backoffice\Instansi::instansi/doDelete');

$routes->add('/backoffice/registrasi', 'backoffice\Peserta::index');
// $routes->post('/backoffice/registrasi', 'backoffice\Peserta::index');
$routes->get('/backoffice/peserta/create', 'backoffice\Peserta::create_peserta');
$routes->post('/backoffice/peserta/save', 'backoffice\Peserta::save_peserta');
$routes->get('/backoffice/peserta/(:num)', 'backoffice\Peserta::detail_peserta/$1');
$routes->get('/backoffice/peserta/hapus/(:num)', 'backoffice\Registrasi::hapus_peserta/$1');
// $routes->get('/backoffice/peserta/edit/(:num)', 'backoffice\Peserta::edit/$1');
// $routes->post('backoffice/peserta/update/(:num)', 'backoffice\Peserta::update_peserta/$1');
// $routes->get('/backoffice/peserta/delete/(:num)', 'backoffice\Peserta::delete_peserta/$1');
// $routes->post('/backoffice/peserta/do_delete/(:num)', 'backoffice\Peserta::do_delete/$1');
$routes->get('/backoffice/peserta_hadir/(:num)', 'backoffice\Peserta::peserta_hadir/$1');

$routes->get('/backoffice/pesert_overkuota/create', 'backoffice\Peserta_overkuota::index');
$routes->post('/backoffice/peserta_overkuota', 'backoffice\Peserta::save_customer_overkuota');

$routes->get('/backoffice/frontoffice/home_service', 'backoffice\Home_service::index');

$routes->get('/backoffice/dokter/(:num)', 'backoffice\Dokter::detail/$1');
$routes->post('/backoffice/dokter/save', 'backoffice\Dokter::save');

$routes->get('/backoffice/faskes', 'backoffice\Faskes::index');
$routes->get('/backoffice/faskes/(:segment)', 'backoffice\Faskes::$1');
$routes->post('/backoffice/faskes/(:segment)', 'backoffice\Faskes::$1');
$routes->get('/backoffice/faskes/(:segment)/(:num)', 'backoffice\Faskes::$1/$2');
$routes->post('/backoffice/faskes/(:segment)/(:num)', 'backoffice\Faskes::$1/$2');

$routes->get('/backoffice/frontoffice', 'backoffice\Frontoffice::index');
$routes->get('/backoffice/frontoffice/(:segment)', 'backoffice\Frontoffice::$1');
$routes->get('/backoffice/frontoffice/(:segment)/(:num)', 'backoffice\Frontoffice::$1/$2');
$routes->post('/backoffice/frontoffice/(:segment)/(:num)', 'backoffice\Frontoffice::$1/$2');

$routes->get('/backoffice/peserta', 'backoffice\Peserta::index');
$routes->get('/backoffice/peserta/(:segment)', 'backoffice\Peserta::$1');
$routes->get('/backoffice/peserta/(:segment)/(:num)', 'backoffice\Peserta::$1/$2');
$routes->post('/backoffice/peserta/(:segment)/(:num)', 'backoffice\Peserta::$1/$2');

$routes->get('/backoffice/dokter', 'backoffice\Dokter::index');
$routes->get('/backoffice/dokter/(:segment)', 'backoffice\Dokter::$1');
$routes->get('/backoffice/dokter/(:segment)/(:num)', 'backoffice\Dokter::$1/$2');
$routes->post('/backoffice/dokter/(:segment)/(:num)', 'backoffice\Dokter::$1/$2');

$routes->get('/backoffice/laboratorium', 'backoffice\Laboratorium::index');
$routes->get('/backoffice/laboratorium/(:segment)', 'backoffice\Laboratorium::$1');
$routes->get('/backoffice/laboratorium/(:segment)/(:num)', 'backoffice\Laboratorium::$1/$2');
$routes->post('/backoffice/laboratorium/(:segment)/(:num)', 'backoffice\Laboratorium::$1/$2');

$routes->get('/backoffice/petugas', 'backoffice\Petugas::index');
$routes->get('/backoffice/petugas/(:segment)', 'backoffice\Petugas::$1');
$routes->get('/backoffice/petugas/(:segment)/(:num)', 'backoffice\Petugas::$1/$2');
$routes->post('/backoffice/petugas/(:segment)/(:num)', 'backoffice\Petugas::$1/$2');

$routes->get('/backoffice/kota', 'backoffice\Kota::index');
$routes->get('/backoffice/kota/(:segment)', 'backoffice\Kota::$1');
$routes->get('/backoffice/kota/(:segment)/(:num)', 'backoffice\Kota::$1/$2');
$routes->post('/backoffice/kota/(:segment)/(:num)', 'backoffice\Kota::$1/$2');

$routes->get('/backoffice/lokasi_input', 'backoffice\Lokasi_input::index');
$routes->get('/backoffice/lokasi_input/(:segment)', 'backoffice\Lokasi_input::$1');
$routes->get('/backoffice/lokasi_input/(:segment)/(:num)', 'backoffice\Lokasi_input::$1/$2');
$routes->post('/backoffice/lokasi_input/(:segment)/(:num)', 'backoffice\Lokasi_input::$1/$2');

$routes->get('/backoffice/laporan', 'backoffice\Laporan::index');
$routes->get('/backoffice/laporan/(:segment)', 'backoffice\Laporan::$1');
$routes->get('/backoffice/laporan/(:segment)/(:num)', 'backoffice\Laporan::$1/$2');
$routes->post('/backoffice/laporan/(:segment)/(:num)', 'backoffice\Laporan::$1/$2');

$routes->get('/backoffice/finance', 'backoffice\Finance::index');
$routes->get('/backoffice/finance/(:segment)', 'backoffice\Finance::$1');
$routes->get('/backoffice/finance/(:segment)/(:num)', 'backoffice\Finance::$1/$2');
$routes->post('/backoffice/finance/(:segment)/(:num)', 'backoffice\Finance::$1/$2');

$routes->get('/backoffice/gudang', 'backoffice\Gudang::index');
$routes->get('/backoffice/gudang/(:num)', 'backoffice\Gudang::detail/$1');
$routes->get('/backoffice/gudang/(:segment)', 'backoffice\Gudang::$1');
$routes->get('/backoffice/gudang/(:segment)/(:num)', 'backoffice\Gudang::$1/$2');
$routes->post('/backoffice/gudang/(:segment)/(:num)', 'backoffice\Gudang::$1/$2');

$routes->get('/backoffice/kategori_gudang', 'backoffice\Kategori_gudang::index');
$routes->get('/backoffice/kategori_gudang/(:segment)', 'backoffice\Kategori_gudang::$1');
$routes->get('/backoffice/kategori_gudang/(:segment)/(:num)', 'backoffice\Kategori_gudang::$1/$2');
$routes->post('/backoffice/kategori_gudang/(:segment)/(:num)', 'backoffice\Kategori_gudang::$1/$2');

$routes->get('/backoffice/settings', 'backoffice\Settings::index');
$routes->get('/backoffice/settings/(:segment)', 'backoffice\Settings::$1');
$routes->get('/backoffice/settings/(:segment)/(:num)', 'backoffice\Settings::$1/$2');
$routes->post('/backoffice/settings/(:segment)/(:num)', 'backoffice\Settings::$1/$2');

$routes->get('/backoffice/user', 'backoffice\User::index');
$routes->get('/backoffice/user/(:segment)', 'backoffice\User::$1');
$routes->post('/backoffice/user/(:segment)', 'backoffice\User::$1');
$routes->get('/backoffice/user/(:segment)/(:num)', 'backoffice\User::$1/$2');
$routes->post('/backoffice/user/(:segment)/(:num)', 'backoffice\User::$1/$2');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
