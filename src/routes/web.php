<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaunaController; //追記

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

// 一般ユーザー向け（ログイン不要な範囲）
Route::get('/', function () {
    return redirect()->route('saunas.index');
});
Route::get('/saunas', [App\Http\Controllers\SaunaController::class, 'index'])->name('saunas.index');

require __DIR__.'/auth.php';
