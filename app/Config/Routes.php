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
$routes->get('/backoffice/peserta/add', 'backoffice\Registrasi::create_peserta');
$routes->get('/backoffice/peserta/(:num)', 'backoffice\Registrasi::detail_peserta/$1');
$routes->get('/backoffice/peserta/edit/(:num)', 'backoffice\Registrasi::edit_peserta/$1');
$routes->get('/backoffice/peserta/hapus/(:num)', 'backoffice\Registrasi::hapus_peserta/$1');
$routes->get('/backoffice/peserta/hadir/(:num)', 'backoffice\Registrasi::hadir_peserta/$1');
$routes->get('/backoffice/print/barcode/(:num)', 'backoffice\Layanan::print_barcode/$1');
$routes->get('/backoffice/print/qrcode/(:num)', 'backoffice\Layanan::print_qrcode/$1');
$routes->get('/backoffice/print/pdf/(:num)', 'backoffice\Layanan::print_pdf/$1');

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
