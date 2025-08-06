<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

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

Route::get('/', [ContactController::class, 'index'])->name('contact.form');
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);
Route::post('/contacts', [ContactController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'index'])->name('admin');
});
Route::get('/admin/search', [AuthController::class, 'search'])->name('admin.search');
Route::get('/export-user', [AuthController::class, 'export'])->name('export-user');
Route::get('/login',[AuthController::class, 'showLogin']);
Route::delete('/admin/delete', [AuthController::class, 'delete'])->name('admin.delete');