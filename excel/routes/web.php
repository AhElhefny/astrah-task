<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/',[UserController::class,'index'])->name('all-data');

Route::post('import-file',[UserController::class,'import'])->name('import-file');
Route::post('get-headings',[UserController::class,'getHeadings'])->name('get-headings');
