<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TitleController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category','index')->name('category.index');
        Route::get('/category/data','data')->name('category.data');
        Route::post('/category','store')->name('category.store');
        Route::get('/category/{id}/edit','edit')->name('category.edit');
        Route::put('/category/{id}/update','update')->name('category.update');
        Route::delete('/category/{id}/delete','delete')->name('category.delete');
    });

    Route::controller(TitleController::class)->group(function () {
        Route::get('/title','index')->name('title.index');
        Route::get('/title/data','data')->name('title.data');
        Route::post('/title','store')->name('title.store');
        Route::get('/title/{id}/edit','edit')->name('title.edit');
        Route::put('/title/{id}/update','update')->name('title.update');
        Route::delete('/title/{id}/delete','delete')->name('title.delete');
    });

});
