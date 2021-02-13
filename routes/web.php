<?php

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

Route::get('/', [\App\Http\Controllers\BlogController::class, 'index']);
Route::get('/view-blog/{id}', [\App\Http\Controllers\BlogController::class, 'view'])->name('view.blog');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/create-blog', [\App\Http\Controllers\BlogController::class, 'create'])->name('create.blog');
