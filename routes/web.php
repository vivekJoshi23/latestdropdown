<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/images', [ImageController::class, 'index'])->name('image.index');
Route::get('/images/create', [ImageController::class, 'create'])->name('image.create');
Route::post('/images', [ImageController::class, 'store'])->name('image.store');
Route::get('/images/{id}/edit', [ImageController::class, 'edit'])->name('image.edit');
Route::put('/images/{id}', [ImageController::class, 'update'])->name('image.update');
