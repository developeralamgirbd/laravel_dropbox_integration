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

Route::get('/', [\App\Http\Controllers\DropboxController::class, 'index'])->name('dropbox.index');
Route::get('dropbox/configuration', [\App\Http\Controllers\DropboxController::class, 'settings'])->name('dropbox.settings');
Route::post('dropbox/configuration', [\App\Http\Controllers\DropboxController::class, 'store'])->name('dropbox.store');
Route::get('dropbox-authorize', [\App\Http\Controllers\DropboxController::class, 'refreshToken'])->name('dropbox.refresh-token');
Route::get('dropbox/chooser-upload', [\App\Http\Controllers\DropboxChooserController::class, 'dropboxChooser'])->name('dropbox.chooser');
Route::post('dropbox/chooser', [\App\Http\Controllers\DropboxChooserController::class, 'store'])->name('dropbox.chooser.store');
//Dropbox CRUD
Route::get('dropbox/image-table', [\App\Http\Controllers\DropboxCrudController::class, 'index'])->name('dropbox.image.index');
Route::post('dropbox/image-store', [\App\Http\Controllers\DropboxCrudController::class, 'store'])->middleware('throttle:dropboxCrud')->name('dropbox.image.store');
Route::delete('dropbox/image-delete/{id}', [\App\Http\Controllers\DropboxCrudController::class, 'destroy'])->middleware('throttle:dropboxCrud')->name('dropbox.image-delete');
Route::get('dropbox/image-restore/{image}', [\App\Http\Controllers\DropboxCrudController::class, 'restore'])->middleware('throttle:dropboxCrud')->name('dropbox.image-restore');

Route::get('trash', [\App\Http\Controllers\DropboxCrudController::class, 'trash'])->name('dropbox.image.trash');

