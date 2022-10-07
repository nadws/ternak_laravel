<?php

use App\Http\Controllers\AksesConttroller;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Buku_besar;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Jurnal_pemasukan;
use App\Http\Controllers\Jurnal_pengeluaran;
use App\Http\Controllers\Neraca_saldo;
use App\Http\Controllers\Penjualan;
use App\Http\Controllers\Piutang_telur;
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
Route::post('/save_akun', [AkunController::class, 'add_akun'])->middleware(['auth', 'verified'])->name('save_akun');


// Sidebar
Route::get('/sidebar', [AksesConttroller::class, 'index'])->middleware(['auth', 'verified'])->name('sidebar');
Route::post('/save_submenu', [AksesConttroller::class, 'save_sub_menu'])->middleware(['auth', 'verified'])->name('save_submenu');
Route::post('/save_menu', [AksesConttroller::class, 'save_menu'])->middleware(['auth', 'verified'])->name('save_menu');
Route::post('/save_urutan', [AksesConttroller::class, 'save_urutan'])->middleware(['auth', 'verified'])->name('save_urutan');

// Jurnal Pengeluaran
Route::get('/jurnal_pengeluaran', [Jurnal_pengeluaran::class, 'index'])->middleware(['auth', 'verified'])->name('jurnal_pengeluaran');
Route::get('/get_isi_jurnal', [Jurnal_pengeluaran::class, 'get_isi_jurnal'])->middleware(['auth', 'verified'])->name('get_isi_jurnal');
Route::get('/akun_kredit', [Jurnal_pengeluaran::class, 'akun_kredit'])->middleware(['auth', 'verified'])->name('akun_kredit');
Route::get('/tambah_jurnal', [Jurnal_pengeluaran::class, 'tambah_jurnal'])->middleware(['auth', 'verified'])->name('tambah_jurnal');
Route::get('/tambah_umum', [Jurnal_pengeluaran::class, 'tambah_umum'])->middleware(['auth', 'verified'])->name('tambah_umum');
Route::get('/get_save_jurnal', [Jurnal_pengeluaran::class, 'get_save_jurnal'])->middleware(['auth', 'verified'])->name('get_save_jurnal');
Route::get('/delete_jurnal', [Jurnal_pengeluaran::class, 'delete_jurnal'])->middleware(['auth', 'verified'])->name('delete_jurnal');

// Save Jurnal pengeluaran
Route::post('/save_jurnal_biaya', [Jurnal_pengeluaran::class, 'save_jurnal_biaya'])->middleware(['auth', 'verified'])->name('save_jurnal_biaya');
Route::post('/save_jurnal_umum', [Jurnal_pengeluaran::class, 'save_jurnal_umum'])->middleware(['auth', 'verified'])->name('save_jurnal_umum');

// user
Route::get('/user', [User::class, 'index'])->middleware(['auth', 'verified'])->name('user');
Route::get('/permission', [User::class, 'permission'])->name('permission');
Route::post('/updatepermission', [User::class, 'updatepermission'])->name('updatepermission');


// Neraca Saldo
Route::get('/saldo', [Neraca_saldo::class, 'index'])->middleware(['auth', 'verified'])->name('saldo');

// Buku Besar
Route::get('/buku_besar', [Buku_besar::class, 'index'])->middleware(['auth', 'verified'])->name('buku_besar');

// Penjualan
Route::get('/p_telur', [Penjualan::class, 'index'])->middleware(['auth', 'verified'])->name('p_telur');
Route::get('/add_telur', [Penjualan::class, 'add'])->middleware(['auth', 'verified'])->name('add_telur');
Route::post('/save_kg', [Penjualan::class, 'save_kg'])->middleware(['auth', 'verified'])->name('save_kg');
Route::post('/save_jurnal', [Penjualan::class, 'save_jurnal'])->middleware(['auth', 'verified'])->name('save_jurnal');
Route::get('/nota', [Penjualan::class, 'nota'])->middleware(['auth', 'verified'])->name('nota');
Route::post('/tb_post', [Penjualan::class, 'tb_post'])->middleware(['auth', 'verified'])->name('tb_post');
Route::get('/delete_p', [Penjualan::class, 'delete'])->middleware(['auth', 'verified'])->name('delete_p');
Route::get('/edit_telur', [Penjualan::class, 'edit_telur'])->middleware(['auth', 'verified'])->name('edit_telur');

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






require __DIR__ . '/auth.php';
