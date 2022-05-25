<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CripsController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\TransactionController;
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
        Route::get('/title/{id}/process', 'process')->name('title.process');
    });

    Route::controller(AlternativeController::class)->group(function () {
        Route::get('/alternative/{titleId}/data','data')->name('alternative.data');
        Route::post('/alternative/store','store')->name('alternative.store');
        Route::get('/alternative/{id}/edit','edit')->name('alternative.edit');
        Route::put('/alternative/{id}/update','update')->name('alternative.update');
        Route::delete('/alternative/{id}/delete','delete')->name('alternative.delete');
    });

    Route::controller(CriteriaController::class)->group(function () {
        Route::get('/criteria/{titleId}/data','data')->name('criteria.data');
        Route::get('/criteria/{titleId}/create','create')->name('criteria.create');
        Route::post('/criteria/store','store')->name('criteria.store');
        Route::get('/criteria/{id}/edit','edit')->name('criteria.edit');
        Route::put('/criteria/{id}/update','update')->name('criteria.update');
        Route::delete('/criteria/{id}/delete','delete')->name('criteria.delete');
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transaction/{titleId}/data','data')->name('transaction.data');
        Route::put('/transaction/{titleId}/generate','generate')->name('transction.generate');
        Route::get('/transaction/{titleId}/column','columTransaction')->name('transaction.column');
        Route::get('/transaction/{titleId}/create','formTransaction')->name('transaction.create');
        Route::post('/trasanction/','store')->name('transaction.store');
        Route::get('/transaction/{titleId}/{alternativeId}/edit','formEditTransaction')->name('transaction.edit');
        Route::post('/transaction/update','update')->name('transaction.update');
        Route::delete('/transaction/{titleId}/{alternativeId}/delete')->name('transaction.delete');
    });

    Route::controller(CripsController::class)->group(function () {
        Route::get('/crips/{titleId}/create','create')->name('crips.create');
    });
});
