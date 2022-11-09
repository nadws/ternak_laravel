<?php

use App\Http\Controllers\AksesConttroller;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Buku_besar;
use App\Http\Controllers\Cancel;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Home;
use App\Http\Controllers\Isi_jurnalpengeluaran;
use App\Http\Controllers\Jurnal_pemasukan;
use App\Http\Controllers\Jurnal_pengeluaran;
use App\Http\Controllers\Jurnal_penutup;
use App\Http\Controllers\Jurnal_penyesuaian;
use App\Http\Controllers\Jurnal_penyesuaian2;
use App\Http\Controllers\Laba_rugi;
use App\Http\Controllers\Neraca_saldo;
use App\Http\Controllers\Penjualan;
use App\Http\Controllers\Penjualan_ayam;
use App\Http\Controllers\Penjualan_kardus;
use App\Http\Controllers\Penjualan_pupuk;
use App\Http\Controllers\Piutang_ayam;
use App\Http\Controllers\Piutang_kardus;
use App\Http\Controllers\Piutang_pupuk;
use App\Http\Controllers\Piutang_telur;
use App\Http\Controllers\Setoran_ayam;
use App\Http\Controllers\Setoran_telur;
use App\Http\Controllers\User;
use App\Http\Controllers\Verify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login_new');
})->name('signin');

Route::has('password.request');

Route::get('/verify', [Verify::class, 'index'])->name('verify');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/buku_besar', [Dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('buku_besar');


Route::get('/sidebar', [Dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('sidebar');


// Akun

Route::get('/akun', [AkunController::class, 'index'])->middleware(['auth', 'verified'])->name('akun');
Route::get('/delete_akun', [AkunController::class, 'delete'])->middleware(['auth', 'verified'])->name('delete_akun');
Route::get('/get_no_akun', [AkunController::class, 'get_no_akun'])->middleware(['auth', 'verified'])->name('get_no_akun');
Route::get('/post_center_akun', [AkunController::class, 'post_center_akun'])->middleware(['auth', 'verified'])->name('post_center_akun');
Route::get('/tambah_post', [AkunController::class, 'tambah_post'])->middleware(['auth', 'verified'])->name('tambah_post');
Route::get('/tambah_kelompok_aktiva', [AkunController::class, 'tambah_kelompok_aktiva'])->middleware(['auth', 'verified'])->name('tambah_kelompok_aktiva');
Route::post('/save_akun', [AkunController::class, 'add_akun'])->middleware(['auth', 'verified'])->name('save_akun');
Route::get('/kelompok_akun', [AkunController::class, 'kelompok_akun'])->middleware(['auth', 'verified'])->name('kelompok_akun');
Route::get('/save_kelompok_baru', [AkunController::class, 'save_kelompok_baru'])->middleware(['auth', 'verified'])->name('save_kelompok_baru');
Route::get('/delete_kelompok_baru', [AkunController::class, 'delete_kelompok_baru'])->middleware(['auth', 'verified'])->name('delete_kelompok_baru');


// Sidebar
Route::get('/sidebar', [AksesConttroller::class, 'index'])->middleware(['auth', 'verified'])->name('sidebar');
Route::post('/save_submenu', [AksesConttroller::class, 'save_sub_menu'])->middleware(['auth', 'verified'])->name('save_submenu');
Route::post('/save_menu', [AksesConttroller::class, 'save_menu'])->middleware(['auth', 'verified'])->name('save_menu');
Route::post('/save_urutan', [AksesConttroller::class, 'save_urutan'])->middleware(['auth', 'verified'])->name('save_urutan');

// Jurnal Pengeluaran
Route::get('/jurnal_pengeluaran', [Jurnal_pengeluaran::class, 'index'])->middleware(['auth', 'verified'])->name('jurnal_pengeluaran');
Route::get('/get_isi_jurnal', [Jurnal_pengeluaran::class, 'get_isi_jurnal'])->middleware(['auth', 'verified'])->name('get_isi_jurnal');
Route::get('/akun_kredit', [Jurnal_pengeluaran::class, 'akun_kredit'])->middleware(['auth', 'verified'])->name('akun_kredit');

Route::get('/get_save_jurnal', [Jurnal_pengeluaran::class, 'get_save_jurnal'])->middleware(['auth', 'verified'])->name('get_save_jurnal');
Route::get('/delete_jurnal', [Jurnal_pengeluaran::class, 'delete_jurnal'])->middleware(['auth', 'verified'])->name('delete_jurnal');
Route::get('/get_barang', [Jurnal_pengeluaran::class, 'get_barang'])->middleware(['auth', 'verified'])->name('get_barang');

Route::get('/print_j', [Jurnal_pengeluaran::class, 'print_jurnal'])->middleware(['auth', 'verified'])->name('print_j');
Route::get('/print_jurnal2', [Jurnal_pengeluaran::class, 'print_jurnal2'])->middleware(['auth', 'verified'])->name('print_jurnal2');
Route::get('/get_post_aktiva', [Jurnal_pengeluaran::class, 'get_post_aktiva'])->middleware(['auth', 'verified'])->name('get_post_aktiva');
Route::get('/get_ttl_aktiva', [Jurnal_pengeluaran::class, 'get_ttl_aktiva'])->middleware(['auth', 'verified'])->name('get_ttl_aktiva');
Route::get('/get_post_atk', [Jurnal_pengeluaran::class, 'get_post_atk'])->middleware(['auth', 'verified'])->name('get_post_atk');
Route::get('/get_ttl_atk', [Jurnal_pengeluaran::class, 'get_ttl_atk'])->middleware(['auth', 'verified'])->name('get_ttl_atk');


// Save Jurnal pengeluaran
Route::post('/save_jurnal_biaya', [Isi_jurnalpengeluaran::class, 'save_jurnal_biaya'])->middleware(['auth', 'verified'])->name('save_jurnal_biaya');
Route::post('/save_jurnal_umum', [Isi_jurnalpengeluaran::class, 'save_jurnal_umum'])->middleware(['auth', 'verified'])->name('save_jurnal_umum');
Route::post('/save_jurnal_pv', [Isi_jurnalpengeluaran::class, 'save_jurnal_pv'])->middleware(['auth', 'verified'])->name('save_jurnal_pv');
Route::post('/save_aktiva', [Isi_jurnalpengeluaran::class, 'save_aktiva'])->middleware(['auth', 'verified'])->name('save_aktiva');
Route::post('/save_atk', [Isi_jurnalpengeluaran::class, 'save_atk'])->middleware(['auth', 'verified'])->name('save_atk');

// Tambah Jurnal

Route::get('/tambah_jurnal', [Isi_jurnalpengeluaran::class, 'tambah_jurnal'])->middleware(['auth', 'verified'])->name('tambah_jurnal');
Route::get('/tambah_umum', [Isi_jurnalpengeluaran::class, 'tambah_umum'])->middleware(['auth', 'verified'])->name('tambah_umum');
Route::get('/tambah_input_vitamin', [Isi_jurnalpengeluaran::class, 'tambah_input_vitamin'])->middleware(['auth', 'verified'])->name('tambah_input_vitamin');
Route::get('/tambah_input_atk', [Isi_jurnalpengeluaran::class, 'tambah_input_atk'])->middleware(['auth', 'verified'])->name('tambah_input_atk');


// Edit Jurnal
Route::get('/edit_jurnal', [Isi_jurnalpengeluaran::class, 'edit_jurnal'])->middleware(['auth', 'verified'])->name('edit_jurnal');
Route::post('/edit_jurnal_biaya', [Isi_jurnalpengeluaran::class, 'edit_jurnal_biaya'])->middleware(['auth', 'verified'])->name('edit_jurnal_biaya');
Route::post('/edit_jurnal_pakan', [Isi_jurnalpengeluaran::class, 'edit_jurnal_pakan'])->middleware(['auth', 'verified'])->name('edit_jurnal_pakan');
Route::post('/edit_jurnal_aktiva', [Isi_jurnalpengeluaran::class, 'edit_jurnal_aktiva'])->middleware(['auth', 'verified'])->name('edit_jurnal_aktiva');

// user
Route::get('/user', [User::class, 'index'])->middleware(['auth', 'verified'])->name('user');
Route::get('/permission', [User::class, 'permission'])->name('permission');
Route::post('/updatepermission', [User::class, 'updatepermission'])->name('updatepermission');


// Neraca Saldo
Route::get('/saldo', [Neraca_saldo::class, 'index'])->middleware(['auth', 'verified'])->name('saldo');
Route::post('/save_saldo', [Neraca_saldo::class, 'save_saldo'])->middleware(['auth', 'verified'])->name('save_saldo');
Route::get('/get_penutup', [Neraca_saldo::class, 'get_penutup'])->middleware(['auth', 'verified'])->name('get_penutup');
Route::post('/edit_saldo', [Neraca_saldo::class, 'edit_saldo'])->middleware(['auth', 'verified'])->name('edit_saldo');
Route::get('/delete_saldo', [Neraca_saldo::class, 'delete_saldo'])->middleware(['auth', 'verified'])->name('delete_saldo');

Route::get('/saldo_penutupan', [Neraca_saldo::class, 'index'])->middleware(['auth', 'verified'])->name('saldo_penutupan');

// Buku Besar
Route::get('/buku_besar', [Buku_besar::class, 'index'])->middleware(['auth', 'verified'])->name('buku_besar');
Route::get('/detail_buku_besar', [Buku_besar::class, 'detail'])->middleware(['auth', 'verified'])->name('detail_buku_besar');

// Penjualan
Route::get('/p_telur', [Penjualan::class, 'index'])->middleware(['auth', 'verified'])->name('p_telur');
Route::get('/add_telur', [Penjualan::class, 'add'])->middleware(['auth', 'verified'])->name('add_telur');
Route::post('/save_kg', [Penjualan::class, 'save_kg'])->middleware(['auth', 'verified'])->name('save_kg');
Route::post('/save_pcs', [Penjualan::class, 'save_pcs'])->middleware(['auth', 'verified'])->name('save_pcs');
Route::post('/save_jurnal', [Penjualan::class, 'save_jurnal'])->middleware(['auth', 'verified'])->name('save_jurnal');
Route::get('/nota', [Penjualan::class, 'nota'])->middleware(['auth', 'verified'])->name('nota');
Route::post('/tb_post', [Penjualan::class, 'tb_post'])->middleware(['auth', 'verified'])->name('tb_post');
Route::get('/delete_p', [Penjualan::class, 'delete'])->middleware(['auth', 'verified'])->name('delete_p');
Route::get('/edit_telur', [Penjualan::class, 'edit_telur'])->middleware(['auth', 'verified'])->name('edit_telur');

Route::get('/tambah_pembayaran', [Penjualan::class, 'tambah_pembayaran'])->middleware(['auth', 'verified'])->name('tambah_pembayaran');
Route::get('/tambah_pembayaran_kardus', [Penjualan_kardus::class, 'tambah_pembayaran_kardus'])->middleware(['auth', 'verified'])->name('tambah_pembayaran_kardus');
Route::get('/tambah_pembayaran_ayam', [Penjualan_ayam::class, 'tambah_pembayaran_ayam'])->middleware(['auth', 'verified'])->name('tambah_pembayaran_ayam');
Route::get('/tambah_pembayaran_pupuk', [Penjualan_pupuk::class, 'tambah_pembayaran_pupuk'])->middleware(['auth', 'verified'])->name('tambah_pembayaran_pupuk');

Route::post('/edit_kg', [Penjualan::class, 'edit_kg'])->middleware(['auth', 'verified'])->name('edit_kg');
Route::get('/nota2', [Penjualan::class, 'nota2'])->middleware(['auth', 'verified'])->name('nota2');
Route::post('/save_jurnal2', [Penjualan::class, 'save_jurnal2'])->middleware(['auth', 'verified'])->name('save_jurnal2');

// Jurnal Pemasukan
Route::get('/j_pemasukan', [Jurnal_pemasukan::class, 'index'])->middleware(['auth', 'verified'])->name('j_pemasukan');

// Piutang telur
Route::get('/piutang_telur', [Piutang_telur::class, 'index'])->middleware(['auth', 'verified'])->name('piutang_telur');
Route::get('/bayar_telur', [Piutang_telur::class, 'bayar'])->middleware(['auth', 'verified'])->name('bayar_telur');
Route::get('/tambah_piutang', [Piutang_telur::class, 'tambah_piutang'])->middleware(['auth', 'verified'])->name('tambah_piutang');
Route::post('/save_piutang_t', [Piutang_telur::class, 'save_piutang_t'])->middleware(['auth', 'verified'])->name('save_piutang_t');

// Jurnal Penyesuaian
Route::get('/j_penyesuaian', [Jurnal_penyesuaian::class, 'index'])->middleware(['auth', 'verified'])->name('j_penyesuaian');
Route::get('/p_stok', [Jurnal_penyesuaian::class, 'penyesuaian_stok'])->middleware(['auth', 'verified'])->name('p_stok');
Route::get('/pakan_stok', [Jurnal_penyesuaian::class, 'pakan_stok'])->middleware(['auth', 'verified'])->name('pakan_stok');
Route::post('/save_penyesuaian_stok', [Jurnal_penyesuaian::class, 'save_penyesuaian_stok'])->middleware(['auth', 'verified'])->name('save_penyesuaian_stok');
Route::post('/save_pv', [Jurnal_penyesuaian::class, 'save_pv'])->middleware(['auth', 'verified'])->name('save_pv');
Route::get('/delete_penyesuaian', [Jurnal_penyesuaian::class, 'delete_penyesuaian'])->middleware(['auth', 'verified'])->name('delete_penyesuaian');

Route::get('/atk_stok', [Jurnal_penyesuaian::class, 'atk_stok'])->middleware(['auth', 'verified'])->name('atk_stok');
Route::post('/save_penyesuaian_atk', [Jurnal_penyesuaian::class, 'save_atk'])->middleware(['auth', 'verified'])->name('save_penyesuaian_atk');


// Jurnal penyesuaian2
Route::get('/j_penyesuaian2', [Jurnal_penyesuaian2::class, 'index'])->middleware(['auth', 'verified'])->name('j_penyesuaian2');
Route::get('/aktiva_penyesuaian', [Jurnal_penyesuaian2::class, 'aktiva_penyesuaian'])->middleware(['auth', 'verified'])->name('aktiva_penyesuaian');
Route::post('/save_aktiva_penyesuaian', [Jurnal_penyesuaian2::class, 'save_aktiva'])->middleware(['auth', 'verified'])->name('save_aktiva_penyesuaian');

// Jurnal Penutup
Route::get('/j_penutup', [Jurnal_penutup::class, 'index'])->middleware(['auth', 'verified'])->name('j_penutup');
Route::get('/isi_penutup', [Jurnal_penutup::class, 'isi_penutup'])->middleware(['auth', 'verified'])->name('isi_penutup');
Route::post('/save_penutup', [Jurnal_penutup::class, 'save_penutup'])->middleware(['auth', 'verified'])->name('save_penutup');


// Penjualan Ayam
Route::get('/pen_ayam', [Penjualan_ayam::class, 'index'])->middleware(['auth', 'verified'])->name('pen_ayam');
Route::get('/add_ayam', [Penjualan_ayam::class, 'add_ayam'])->middleware(['auth', 'verified'])->name('add_ayam');
Route::post('/save_ayam', [Penjualan_ayam::class, 'save_ayam'])->middleware(['auth', 'verified'])->name('save_ayam');
Route::get('/nota_ayam', [Penjualan_ayam::class, 'nota_ayam'])->middleware(['auth', 'verified'])->name('nota_ayam');
Route::post('/save_jurnal_ayam', [Penjualan_ayam::class, 'save_jurnal'])->middleware(['auth', 'verified'])->name('save_jurnal_ayam');

// Piutang Ayam
Route::get('/piutang_ayam', [Piutang_ayam::class, 'index'])->middleware(['auth', 'verified'])->name('piutang_ayam');
Route::get('/bayar_ayam', [Piutang_ayam::class, 'bayar'])->middleware(['auth', 'verified'])->name('bayar_ayam');
Route::post('/save_piutang_a', [Piutang_ayam::class, 'save_piutang_a'])->middleware(['auth', 'verified'])->name('save_piutang_a');

// Penjualan Pupuk
Route::get('/pen_pupuk', [Penjualan_pupuk::class, 'index'])->middleware(['auth', 'verified'])->name('pen_pupuk');
Route::get('/add_pupuk', [Penjualan_pupuk::class, 'add_pupuk'])->middleware(['auth', 'verified'])->name('add_pupuk');
Route::post('/save_pupuk', [Penjualan_pupuk::class, 'save_pupuk'])->middleware(['auth', 'verified'])->name('save_pupuk');
Route::get('/nota_pupuk', [Penjualan_pupuk::class, 'nota_pupuk'])->middleware(['auth', 'verified'])->name('nota_pupuk');
Route::post('/save_jurnal_pupuk', [Penjualan_pupuk::class, 'save_jurnal_pupuk'])->middleware(['auth', 'verified'])->name('save_jurnal_pupuk');

// penjualan kardus
Route::get('/pen_kardus', [Penjualan_kardus::class, 'index'])->middleware(['auth', 'verified'])->name('pen_kardus');
Route::get('/add_kardus', [Penjualan_kardus::class, 'add_kardus'])->middleware(['auth', 'verified'])->name('add_kardus');
Route::post('/save_kardus', [Penjualan_kardus::class, 'save_kardus'])->middleware(['auth', 'verified'])->name('save_kardus');
Route::get('/nota_kardus', [Penjualan_kardus::class, 'nota_kardus'])->middleware(['auth', 'verified'])->name('nota_kardus');
Route::post('/save_jurnal_kardus', [Penjualan_kardus::class, 'save_jurnal_kardus'])->middleware(['auth', 'verified'])->name('save_jurnal_kardus');

// Piutang Pupuk
Route::get('/p_pupuk', [Piutang_pupuk::class, 'index'])->middleware(['auth', 'verified'])->name('p_pupuk');
Route::get('/bayar_pupuk', [Piutang_pupuk::class, 'bayar'])->middleware(['auth', 'verified'])->name('bayar_pupuk');
Route::post('/save_piutang_p', [Piutang_pupuk::class, 'save_piutang_p'])->middleware(['auth', 'verified'])->name('save_piutang_p');

// Piutang Kardus
Route::get('/p_kardus', [Piutang_kardus::class, 'index'])->middleware(['auth', 'verified'])->name('p_kardus');
Route::get('/bayar_kardus', [Piutang_kardus::class, 'bayar'])->middleware(['auth', 'verified'])->name('bayar_kardus');
Route::post('/save_piutang_k', [Piutang_kardus::class, 'save_piutang_p'])->middleware(['auth', 'verified'])->name('save_piutang_k');

// Penyetoran Telur
Route::get('/setor_telur', [Setoran_telur::class, 'index'])->middleware(['auth', 'verified'])->name('setor_telur');
Route::get('/rencana_telur', [Setoran_telur::class, 'rencana_telur'])->middleware(['auth', 'verified'])->name('rencana_telur');
Route::get('/list_perencanaan', [Setoran_telur::class, 'list_perencanaan'])->middleware(['auth', 'verified'])->name('list_perencanaan');
Route::get('/detail_list_perencanaan', [Setoran_telur::class, 'detail_list_perencanaan'])->middleware(['auth', 'verified'])->name('detail_list_perencanaan');
Route::post('/save_perencanaan_telur', [Setoran_telur::class, 'save_perencanaan_telur'])->middleware(['auth', 'verified'])->name('save_perencanaan_telur');
Route::post('/save_jurnal_setoran', [Setoran_telur::class, 'save_jurnal_setoran'])->middleware(['auth', 'verified'])->name('save_jurnal_setoran');
Route::get('/data_invoice_setoran', [Setoran_telur::class, 'data_invoice_setoran'])->middleware(['auth', 'verified'])->name('data_invoice_setoran');
Route::get('/detail_set_telur', [Setoran_telur::class, 'detail_set_telur'])->middleware(['auth', 'verified'])->name('detail_set_telur');

// Penyetroran Ayam
Route::get('/setor_ayam', [Setoran_ayam::class, 'index'])->middleware(['auth', 'verified'])->name('setor_ayam');
Route::get('/rencana_ayam', [Setoran_ayam::class, 'rencana_ayam'])->middleware(['auth', 'verified'])->name('rencana_ayam');
Route::post('/save_perencanaan_ayam', [Setoran_ayam::class, 'save_perencanaan_ayam'])->middleware(['auth', 'verified'])->name('save_perencanaan_ayam');
Route::get('/list_perencanaan_ayam', [Setoran_ayam::class, 'list_perencanaan_ayam'])->middleware(['auth', 'verified'])->name('list_perencanaan_ayam');
Route::get('/detail_list_perencanaan_ayam', [Setoran_ayam::class, 'detail_list_perencanaan_ayam'])->middleware(['auth', 'verified'])->name('detail_list_perencanaan_ayam');
Route::post('/save_jurnal_setoran_ayam', [Setoran_ayam::class, 'save_jurnal_setoran_ayam'])->middleware(['auth', 'verified'])->name('save_jurnal_setoran_ayam');
// Penyetroran Pupuk
Route::get('/setor_pupuk', [Piutang_kardus::class, 'save_piutang_p'])->middleware(['auth', 'verified'])->name('setor_pupuk');
// Penyetroran kardus
Route::get('/setor_kardus', [Piutang_kardus::class, 'save_piutang_p'])->middleware(['auth', 'verified'])->name('setor_kardus');


// home 
Route::get('/home', [Home::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/view_jurnal_laporan_bulanan', [Home::class, 'view_jurnal_laporan_bulanan'])->middleware(['auth', 'verified'])->name('view_jurnal_laporan_bulanan');
Route::get('/cash_flow', [Home::class, 'index'])->middleware(['auth', 'verified'])->name('cash_flow');
Route::get('/profit', [Home::class, 'index'])->middleware(['auth', 'verified'])->name('profit');

// Cancel
Route::get('/cancel_jurnal', [Cancel::class, 'index'])->middleware(['auth', 'verified'])->name('cancel_jurnal');
Route::post('/save_cancel_jurnal', [Cancel::class, 'save_cancel'])->middleware(['auth', 'verified'])->name('save_cancel_jurnal');

// Laporan laba rugi
Route::get('/laba_rugi', [Laba_rugi::class, 'index'])->middleware(['auth', 'verified'])->name('laba_rugi');





require __DIR__ . '/auth.php';
