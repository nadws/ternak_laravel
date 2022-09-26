<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\Dashboard;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/buku_besar', [Dashboard::class, 'index'])->name('buku_besar');
Route::get('/user', [Dashboard::class, 'index'])->name('user');
Route::get('/sidebar', [Dashboard::class, 'index'])->name('sidebar');


// Akun

Route::get('/akun', [AkunController::class, 'index'])->name('akun');
Route::get('/get_no_akun', [AkunController::class, 'get_no_akun'])->name('get_no_akun');
Route::get('/post_center_akun', [AkunController::class, 'post_center_akun'])->name('post_center_akun');
Route::get('/tambah_post', [AkunController::class, 'tambah_post'])->name('tambah_post');
Route::post('/save_akun', [AkunController::class, 'add_akun'])->name('save_akun');

require __DIR__ . '/auth.php';
