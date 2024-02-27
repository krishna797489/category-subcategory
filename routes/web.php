<?php

use App\Http\Controllers\CategoryController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [CategoryController::class, 'index'])->name('index');
Route::get('/subcategory', [CategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
