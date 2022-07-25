<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserrController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PelindoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ChangePasswordController;
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
// php artisan serve --host 192.168.10.2 --port 8000
// C:\Windows\System32\drivers\etc
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

Auth::routes();
// Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

// change-password
Route::get('change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

    // hak akses untuk admin
    Route::group(['middleware' => 'admin'], function() {

    // server
    Route::get('/server', [ServerController::class,'index'])->name('server');
    Route::post('/insert_server', [ServerController::class,'insert']);
    Route::get('/update_serverr/',[ServerController::class,'update_serverr']);
    Route::get('/update_server/{id}',[ServerController::class,'status_update']);
    Route::get('/delete_server/{id}',[ServerController::class,'delete_server']);

    // user
    Route::get('/userr', [UserrController::class,'index'])->name('userr');
    Route::post('/insert_userr', [UserrController::class,'insert']);
    Route::get('/delete_userr/{id}',[UserrController::class,'delete']);

    // upload
    Route::get('/upload', [UploadController::class,'index'])->name('upload');
    Route::post('/insert_upload', [UploadController::class,'insert']);
    Route::post('/delete_upload/{id}', [UploadController::class,'delete_upload']);
    Route::get('/update_upload/{id}',[UploadController::class,'upload_update']);

    // cetak tanggal upload
    Route::get('/cetak_tanggal_upload', [UploadController::class,'cetak_tanggal_upload'])->name('cetak_tanggal_upload');
    Route::get('delete_upload/{id}', [UploadController::class,'delete_upload']);
    });
