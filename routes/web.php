<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProjekController;
use App\Http\Controllers\BprojekController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('suratjalan/surat', function () {
    return view ("suratjalan.suratjalan");
});


Route::get('suratjalan/cetak', [SuratJalanController::class, 'cetak']);
Route::post('suratjalan/fetch', [SuratJalanController::class, 'barang']);
Route::get('suratjalan/data', [SuratJalanController::class, 'data']);
Route::group(['middleware' => 'auth'] , function() {

    // $this->middleware

    Route::get('/analytics', function() {
        // $category_name = '';
        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'analytics',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,
        ];
        // $pageName = 'analytics';
        return view('dashboard')->with($data);
    });
    
    Route::get('/dashboard', [HomeController::class, 'index']);

    // Barang
    Route::get('barang/data-show/{id}', [BarangController::class, 'data_show']);
    Route::resource('barang', BarangController::class);
    // Route::prefix('barang')->group(function () {
    //     Route::get('/', [BarangController::class, 'index']);
    //     Route::post('/store', [BarangController::class, 'store'])->name('barang.store');
    //     Route::post('/update/{barang}', [BarangController::class, 'update'])->name('barang.update');
    // });

    // Transaksi
    Route::get('transaksi/history', 'TransaksiController@history');
    Route::post('transaksi/fetch', [TransaksiController::class, 'barang']);
    Route::post('transaksi/fetch/project', [TransaksiController::class, 'project']);
    Route::get('transaksi/data', [TransaksiController::class, 'data']);
    Route::resource('transaksi', TransaksiController::class);
    


    // Projek
    Route::resource('project', ProjectController::class);

    // Barang projek
    Route::resource('bproject', BprojectController::class);

    // Surat Jalan
    Route::get('suratjalan/history', 'SuratJalanController@history');
    Route::get('suratjalan/cetak', 'SuratJalanController@cetak');
    Route::resource('suratjalan', SuratJalanController::class);

});

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/', function() {
    return redirect('/dashboard');    
});