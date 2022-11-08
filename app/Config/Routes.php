<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Routes Ke views dan controller Akses
$routes->get('/', 'masterAkses::index');
//routes Akses Aplikasi
$routes->post('/login', 'masterAkses::open');
// routes Ke ganti Password default
$routes->post('/gantiPasswordDefault', 'masterAkses::gantiPasswordDefault');
//routes Logout
$routes->get('/logout', 'masterAkses::logout');
//Routes Ke views dan controller Dashboard
$routes->get('/dashboard', 'masterDashboard::index');

//Routes Ke views dan controller Dashboard
$routes->get('/rincianKegiatanPegawai', 'masterRencanaKegiatan::rencanaKegiatan');
$routes->post('/tambahRencanaKegiatan', 'masterRencanaKegiatan::tambahRencanaKegiatan');
$routes->get('/updateStatusRincian/(:segment)', 'masterRencanaKegiatan::updateStatusRincian/$1');
$routes->get('/hapusStatusRincian/(:segment)', 'masterRencanaKegiatan::hapusStatusRincian/$1');
$routes->get('/riwayatRencanaKegiatan', 'masterRencanaKegiatan::riwayatRencanaKegiatan');

//Routes Ke method Catatan
$routes->post('/tambahCatatan', 'masterDashboard::tambahCatatan');
$routes->post('/updateCatatan', 'masterDashboard::updateCatatan');
$routes->get('/hapusCatatan/(:segment)', 'masterDashboard::hapusCatatan/$1');

//Routes Ke views dan controller Dashboard Data Pegawai
$routes->get('/dataPegawai', 'masterDashboard::dataPegawai');
//routes untuk membuka detail di dashboard
$routes->get('/showDetailLaporanHarianOnDashboard/(:segment)', 'masterDashboard::showDetailLaporanHarianOnDashboard/$1');
//rutes untuk show calender per pegawai
$routes->get('/showKegiatanPegawai/(:segment)', 'masterDashboard::showKegiatanPegawai/$1');
//Routes Ke views dan controller Dashboard
$routes->get('/profile', 'masterUser::profile');


//routes ke update data user by user
$routes->post('/updateProfileByUser', 'masterUser::updateProfileByUser');
//Routes ke ganti password user
$routes->post('/gantiPasswordByUser', 'masterUser::gantiPasswordByUser');


//Routes Ke views dan controller list Laporan dan Input Kegiatan
$routes->get('/listLaporan', 'masterLaporanHarian::listLaporan');
$routes->get('/inputKegiatan', 'masterLaporanHarian::inputKegiatan');
$routes->get('/detailKegiatan', 'masterLaporanHarian::detailKegiatan');
//Routes ke save laporan harian dan controller save laporan harian
$routes->post('/saveLaporanHarian', 'masterLaporanHarian::saveLaporanHarian');
//Routes ke save laporan harian dan controller save laporan harian
$routes->post('/updateLaporanHarian', 'masterLaporanHarian::updateLaporanHarian');
//routes ke edit laporan
$routes->get('/showEditLaporanHarian/(:segment)', 'masterLaporanHarian::showEditLaporanHarian/$1');
//routes ke detail laporan
$routes->get('/showDetailLaporanHarian/(:segment)', 'masterLaporanHarian::showDetailLaporanHarian/$1');
//Routes hapus Bukti Dukung
$routes->post('/hapusBuktiDukung', 'masterLaporanHarian::hapusBuktiDukung');
//Routes ke cetak Laporam
$routes->post('/cetakLaporan', 'masterLaporanHarian::cetakLaporan');
$routes->post('/cetakLaporanByPimpinan', 'masterLaporanHarian::cetakLaporanByPimpinan');
$routes->post('/cetakLaporanByBidang', 'masterLaporanHarian::cetakLaporanByBidang');
//routes tambah cuti
$routes->post('/inputCuti', 'masterLaporanHarian::inputCuti');

//Routes Ke views dan controller Kelola Master
$routes->get('/masterUser', 'masterKelolaMaster::masterUser');
$routes->get('/masterPegawai', 'masterKelolaMaster::masterPegawai');
$routes->get('/masterKegiatan', 'masterKelolaMaster::masterKegiatan');
$routes->get('/masterUser/get_autofillPegawai', 'masterKelolaMaster::get_autofillPegawai');
//Routes untuk menampilkan data berdasarkan data user yang dipilih
$routes->get('/showDataUser/(:segment)', 'masterKelolaMaster::showDataUser/$1');
//routes update level dan aktivasi pada user
$routes->post('/updateRoleAktivasi', 'masterKelolaMaster::updateRoleAktivasi');
//routes update level dan tambah level user
$routes->post('/tambahLevelUser', 'masterKelolaMaster::tambahLevelUser');
//routes untuk reset password user
$routes->post('/resetPasswordUser', 'masterKelolaMaster::resetPasswordUser');
//routes untuk hapus level user
$routes->post('/hapusLevelUser', 'masterKelolaMaster::hapusLevelUser');
//Routes  controller Kelola Master Tambah user
$routes->post('/tambahUser', 'masterKelolaMaster::tambahUser');
//rotes ke save data pegawai baru
$routes->post('/savePegawai', 'masterKelolaMaster::savePegawai');
//routes ke update pegawai
$routes->post('/updatePegawai', 'masterKelolaMaster::updatePegawai');
//routes ke views edit pegawai
$routes->get('/showEditPegawai/(:segment)', 'masterKelolaMaster::showEditPegawai/$1');
//routes ke views detail pegawai
$routes->get('/showDetailPegawai/(:segment)', 'masterKelolaMaster::showDetailPegawai/$1');

//Routes Ke views dan controller Sistem
$routes->get('/kelolaLevel', 'masterSistem::kelolaLevel');
//routes ke editKelolaMenu bagi level tertentu
$routes->get('/editKelolaLevel/(:segment)', 'masterSistem::editKelolaLevel/$1');
$routes->post('/updateKelolaLevel/(:segment)', 'masterSistem::updateKelolaLevel/$1');
//routes ke save level baru yang dibuat
$routes->post('/saveLevel', 'masterSistem::saveLevel');
//routes ke update nama level yang ada di list
$routes->post('/updateNamaLevel', 'masterSistem::updateNamaLevel');

$routes->get('/kelolaMenu', 'masterSistem::kelolaMenu');
$routes->get('/kelolaSubMenu', 'masterSistem::kelolaSubMenu');

//Routes ke update dan controller sistem
$routes->post('/updateMenu', 'masterSistem::updateMenu');
$routes->post('/updateSubmenu', 'masterSistem::updateSubmenu');

//Routes ke save dan controller sistem
$routes->post('/saveMenu', 'masterSistem::saveMenu');
$routes->post('/saveSubmenu', 'masterSistem::saveSubmenu');


//routes ke switch level akun dan controller master akses
$routes->post('/switchLevel', 'masterAkses::switchLevel');

// routes ke Detail Catatan
$routes->get('/detailCatatan', 'masterDashboard::detailCatatan');



/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
