<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\PrasenceController;
use App\Http\Controllers\prasenceDetailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});


Route::group(['middleware' => 'auth'],function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('prasence',PrasenceController::class);
    Route::delete('prasence-detail/{id}', [prasenceDetailController::class, 'destroy'])->name('prasence-detail.destroy');
    Route::get('prasence-detail/export-pdf/{id}', [prasenceDetailController::class, 'exportPDF'])->name('prasence-detail.exportPDF');
});


//Public
Route::get('absen/{slug}',[AbsenController::class,'index'])->name('absen.index');
Route::post('absen/save/{id}', [AbsenController::class, 'save'])->name('absen.save');

Auth::routes();
