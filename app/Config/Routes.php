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
$routes->get('/backoffice', 'backoffice\Home::index');
$routes->get('/backoffice/login', 'backoffice\User::login');
$routes->post('/backoffice/login', 'backoffice\User::doLogin');
$routes->get('/backoffice/user', 'backoffice\User::detailById');
$routes->post('/backoffice/user', 'backoffice\User::doCreate');
$routes->get('/detail_form2', 'Customer::detail_form2');
$routes->get('/cek_jadwal', 'Customer::jadwal_available');
$routes->get('/menu', 'Customer::getMenu');
$routes->post('/api/registration', 'Customer::registrasi');

$routes->get('detail_form2', 'Customer::detail_form2');


// $routes->get('/backoffice/peserta/edit/(:num)', 'backoffice\Registrasi::edit_peserta/$1');

$routes->get('/backoffice/print/barcode/(:num)', 'backoffice\Layanan::print_barcode/$1');
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

$routes->get('/backoffice/registrasi', 'backoffice\Peserta::index');
$routes->get('/backoffice/peserta/create', 'backoffice\Peserta::create_peserta');
$routes->get('/backoffice/peserta/save', 'backoffice\Peserta::save_peserta');
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
