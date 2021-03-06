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
$routes->post('/backoffice/doLogin', 'backoffice\User::doLogin');


$routes->get('/detail_form2', 'Customer::detail_form2');
$routes->get('/cek_jadwal', 'Customer::jadwal_available');
$routes->get('/menu', 'Customer::getMenu');
$routes->get('/select-test', 'Customer::getSelectedTest');
$routes->get("/select-test-corporate", "Customer::select_test_corporate");
$routes->get('/home-service', 'Customer::home_service');
$routes->post('/api/registration', 'Customer::registrasi');
$routes->post('/api/get_server_key', 'Customer::get_server_key');
$routes->post('/api/update_status', 'Customer::update_data_customer_registration');
$routes->post('/api/getQRByOrderId', 'Customer::get_qr_by_order_id');
$routes->get('/api/hadir/(:num)', 'backoffice\Peserta::kehadiran_by_scanning_qr/$1');
$routes->get("/api/get_antrian_swabber", "backoffice\Swabber::get_antrian_swabber");
// $routes->get('/api/marketings', '')
// $routes->post('/api/midtrans_notification', 'Customer::midtrans_notification');
$routes->add('/api/notification', 'Midtrans_handlers::index');
$routes->get("api/check-payment-id/(:any)", "backoffice\Midtrans::get_status_midtrans/$1");
$routes->add('/api/redirection-handler', 'Midtrans_handlers::redirection_handler');
$routes->add('/api/test-email/(:any)', 'Midtrans_handlers::CobaSendEmail/$1');
$routes->get('/api/check_no_registration', 'Customer::validasi_no_registrasi');
$routes->get("/api/direct-print-barcode/(:any)", "backoffice\Layanan::direct_print_barcode/$1");
$routes->get("/api/detail-paket-pemeriksaan", "backoffice\Settings::detail_paket_pemeriksaan");
$routes->post("/api/home-service", "backoffice\Home_service::save");
$routes->post("/api/kirim_hasil", "backoffice\layanan::kirim_hasil");
$routes->get("/api/antrian", "Antrian::get_data_antrian");
$routes->get("/api/on_call", "Antrian::get_data_on_call");

$routes->get("/api/print_invoice/no-ttd/(:any)", "backoffice\Finance::print_invoice/no-ttd/$1");
$routes->get("/resepsionis/bilik/(:num)", "backoffice\Frontoffice::manajemen_antrian/$1");
$routes->get("/api/get-antrian-panggilan", "backoffice\Frontoffice::antrian_panggilan");

$routes->get('detail_form2', 'Customer::detail_form2');

$routes->get("/api/get-print-pdf-peserta/(:num)", "backoffice\Layanan::print_pdf/$1");
$routes->get("/api/get_hasil_lab/(:num)", "backoffice\Laboratorium::print_hasil/$1");
$routes->get("/api/get-hasil-lab/(:num)", "backoffice\Laboratorium::print_hasil/$1");
$routes->get("/api/send-hasil-lab/(:num)", "backoffice\Laboratorium::send_hasil_peserta/$1");


// $routes->get('/backoffice/peserta/edit/(:num)', 'backoffice\Registrasi::edit_peserta/$1');

$routes->get('/backoffice/print/barcode/(:any)', 'backoffice\Layanan::printbarcode/$1');
$routes->get('/backoffice/print/barcodev2/(:any)', 'backoffice\Layanan::printbarcodev2/$1');
$routes->get('/backoffice/print/qrcode/(:num)', 'backoffice\Layanan::print_qrcode/$1');
$routes->get('/backoffice/print/pdf/(:num)', 'backoffice\Layanan::print_pdf/$1');

$routes->post("/api/verifikasi-selesa-cetak", "backoffice/Swabber::do_update_customer_been_printed");

$routes->get('/backoffice/instansi', 'backoffice\Instansi::index');
$routes->add('/backoffice/instansi/(:num)', 'backoffice\Instansi::detail_instansi/$1');
$routes->get('/backoffice/instansi/create', 'backoffice\Instansi::create_instansi');
$routes->post('/backoffice/instansi/save', 'backoffice\Instansi::save_instansi');
$routes->get('/backoffice/instansi/edit/(:num)', 'backoffice\Instansi::edit_instansi/$1');
$routes->post('/backoffice/instansi/update/(:num)', 'backoffice\Instansi::update_instansi/$1');
$routes->get('/backoffice/instansi/delete/(:num)', 'backoffice\Instansi::delete_instansi/$1');
$routes->post('/backoffice/instansi/deleting', 'backoffice\Instansi::instansi/doDelete');

$routes->add('/backoffice/registrasi', 'backoffice\Peserta::index');
// $routes->post('/backoffice/registrasi', 'backoffice\Peserta::index');
$routes->get('/backoffice/peserta/create', 'backoffice\Peserta::create_peserta');
$routes->post('/backoffice/peserta/save', 'backoffice\Peserta::save');
$routes->get('/backoffice/peserta/(:num)', 'backoffice\Peserta::detail_peserta/$1');
$routes->get('/backoffice/peserta/hapus/(:num)', 'backoffice\Peserta::delete/$1');
$routes->post('/backoffice/peserta/doDelete/', 'backoffice\Peserta::doDelete');
// $routes->get('/backoffice/peserta/edit/(:num)', 'backoffice\Peserta::edit/$1');
// $routes->post('backoffice/peserta/update/(:num)', 'backoffice\Peserta::update_peserta/$1');
// $routes->get('/backoffice/peserta/delete/(:num)', 'backoffice\Peserta::delete_peserta/$1');
// $routes->post('/backoffice/peserta/do_delete/(:num)', 'backoffice\Peserta::do_delete/$1');
$routes->get('/backoffice/peserta_hadir/(:num)', 'backoffice\Peserta::peserta_hadir/$1');

$routes->get('/backoffice/pesert_overkuota/create', 'backoffice\Peserta_overkuota::index');
$routes->post('/backoffice/peserta_overkuota', 'backoffice\Peserta::save_customer_overkuota');

$routes->get('/backoffice/home_service', 'backoffice\Home_service::index');
$routes->add('/backoffice/home_service/(:num)', 'backoffice\Home_service::detail/$1');
// $routes->add('/backoffice/frontoffice/(:segment)', 'backoffice\Frontoffice::$1');
// $routes->add('/backoffice/frontoffice/(:segment)/(:num)/(:any)/(:num)', 'backoffice\Frontoffice::$1/$2/$3/$4');

// $routes->get('/backoffice/home_service', '')

$routes->get('/backoffice/dokter/(:num)', 'backoffice\Dokter::detail/$1');
$routes->post('/backoffice/dokter/save', 'backoffice\Dokter::save');

$routes->get('/backoffice/faskes', 'backoffice\Faskes::index');
$routes->add('/backoffice/faskes/(:segment)', 'backoffice\Faskes::$1');
$routes->add('/backoffice/faskes/(:segment)/(:num)', 'backoffice\Faskes::$1/$2');

$routes->get('/backoffice/frontoffice', 'backoffice\Frontoffice::index');
$routes->add('/backoffice/frontoffice/(:segment)', 'backoffice\Frontoffice::$1');
$routes->add('/backoffice/frontoffice/(:segment)/(:num)', 'backoffice\Frontoffice::$1/$2');

$routes->get('/backoffice/peserta', 'backoffice\Peserta::index');
$routes->add('/backoffice/peserta/(:segment)', 'backoffice\Peserta::$1');
$routes->add('/backoffice/peserta/(:segment)/(:num)', 'backoffice\Peserta::$1/$2');

$routes->get('/backoffice/dokter', 'backoffice\Dokter::index');
$routes->add('/backoffice/dokter/(:segment)', 'backoffice\Dokter::$1');
$routes->add('/backoffice/dokter/(:segment)/(:num)', 'backoffice\Dokter::$1/$2');

$routes->get('/backoffice/laboratorium', 'backoffice\Laboratorium::index');
$routes->add('/backoffice/laboratorium/(:segment)', 'backoffice\Laboratorium::$1');
$routes->add('/backoffice/laboratorium/(:segment)/(:num)', 'backoffice\Laboratorium::$1/$2');

$routes->get('/backoffice/petugas', 'backoffice\Petugas::index');
$routes->add('/backoffice/petugas/(:segment)', 'backoffice\Petugas::$1');
$routes->add('/backoffice/petugas/(:segment)/(:num)', 'backoffice\Petugas::$1/$2');

$routes->get('/backoffice/kota', 'backoffice\Kota::index');
$routes->add('/backoffice/kota/(:segment)', 'backoffice\Kota::$1');
$routes->add('/backoffice/kota/(:segment)/(:num)', 'backoffice\Kota::$1/$2');

$routes->get('/backoffice/lokasi_input', 'backoffice\Lokasi_input::index');
$routes->add('/backoffice/lokasi_input/(:segment)', 'backoffice\Lokasi_input::$1');
$routes->add('/backoffice/lokasi_input/(:segment)/(:num)', 'backoffice\Lokasi_input::$1/$2');

$routes->get('/backoffice/laporan', 'backoffice\Laporan::index');
$routes->get('/backoffice/laporan/(:segment)', 'backoffice\Laporan::$1');
$routes->add('/backoffice/laporan/(:segment)/(:num)', 'backoffice\Laporan::$1/$2');

$routes->get('/backoffice/finance', 'backoffice\Finance::index');
$routes->add('/backoffice/finance/(:segment)', 'backoffice\Finance::$1');
$routes->add("/backoffice/finance/instansi/(:num)", "backoffice\Finance::detail_finance_instansi/$1");
$routes->add('/backoffice/finance/(:segment)/(:num)', 'backoffice\Finance::$1/$2');

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
$routes->add('/backoffice/settings/(:segment)', 'backoffice\Settings::$1');
$routes->add('/backoffice/settings/(:segment)/(:num)', 'backoffice\Settings::$1/$2');

$routes->get('/backoffice/user', 'backoffice\User::index');
$routes->add('/backoffice/user/(:segment)', 'backoffice\User::$1');
$routes->add('/backoffice/user/(:segment)/(:num)', 'backoffice\User::$1/$2');

$routes->add('/backoffice/finance/(:segment)', 'backoffice\Finance::$1');
$routes->add('/backoffice/finance/print_invoice/(:segment)/(:any)', 'backoffice\Finance::print_invoice/$1/$2');
$routes->add('/backoffice/finance/(:segment)/(:num)', 'backoffice\Finance::$1/$2');

$routes->get('/marketing', 'backoffice\Marketing::index');
$routes->get('/marketing/(:num)', 'backoffice\Marketing::detail/$1');
$routes->add('/marketing/(:segment)', 'backoffice\Marketing::$1');
$routes->add('/marketing/(:segment)/(:num)', 'backoffice\Marketing::$1/$2');
$routes->add("/backoffice/laporan/hasil", "backoffice\Laboratorium::hasil");
$routes->get("/backoffice/logout", "backoffice\User::logout");

$routes->get("led/", "Antrian::bilik");
$routes->get("led/(:num)", "Antrian::bilik/$1");

$routes->get("/api/wa", "backoffice\Whatsapp_service::coba_wa");
$routes->post("/api/save-hs", "Customer::home_service_registration");
// $routes->post("/save-rujukan", "Afiliasi::save_rujukan");
$routes->add("/swabber", "backoffice\Swabber::index");
$routes->add("/swabber/(:segment)", "backoffice\Swabber::$1");
$routes->post("/api/print-barcode-swabber", "backoffice\Swabber::print_barcode");

$routes->get("/backoffice/reporting/(:segment)", "backoffice\Reporting::$1");


/**
 * API untuk afiliasi home services dan corporate, rujukan akan menyusul dalam pertimbangan
 */
$routes->get("/afiliasi-hs/(:num)", "Afiliasi::home_service/$1");
$routes->get("/corporate/(:num)", "Afiliasi::corporate/$1");

$routes->get("/rujukan/(:num)", "Rujukan::indexv2/$1");
$routes->add("/rujukan/(:segment)", "Rujukan::$1");
// $routes->post("/afiliasi-corporate/save", "Afiliasi::save_corporate");
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
