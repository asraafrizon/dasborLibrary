<?php

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
    return view('dashboard.dashboard');
});

// Route::get('koleksi', function () {
//     return view('koleksi');
// });



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function() {

Route::resource('koleksi', 'KoleksiController');
Route::resource('inventori', 'InventoriController');
Route::resource('layanan', 'LayananController');

Route::get('api/koleksi', 'KoleksiController@apiKoleksi')->name('api.koleksi');
Route::get('api/inventori', 'InventoriController@apiInventori')->name('api.inventori');
Route::get('api/layanan', 'LayananController@apiLayanan')->name('api.layanan');


Route::get('/asra', function() {return view('dashboard.inven');})->name('asra');
Route::get('/dashboard', function () {return view('dashboard.dashboard');});



Route::get('exportInventori', 'InventoriController@inventoriExport')->name('inventori.export');
Route::post('importInventori', 'InventoriController@inventoriImport')->name('inventori.import');
Route::get('exportKoleksi', 'KoleksiController@koleksiExport')->name('koleksi.export');
Route::post('importKoleksi', 'KoleksiController@koleksiImport')->name('koleksi.import');
Route::get('exportLayanan', 'LayananController@layananExport')->name('layanan.export');
Route::post('importLayanan', 'LayananController@layananImport')->name('layanan.import');

Route::get('/data', function() {return view('export');})->name('data');



});


Route::get('koleks', 'dashboardController@koleksi');
Route::get('inven', 'dashboardController@inventori');
Route::get('layan', 'dashboardController@layanan');