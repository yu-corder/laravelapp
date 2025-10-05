<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController; //追記

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

Route::get('/item', [ItemController::class, 'index']);


Route::get('/item/edit/{id}', [ItemController::class, 'showEdit']);

Route::post('/item/edit/{id}', [ItemController::class, 'edit']);

Route::get('/item/add', [ItemController::class, 'showAdd']);

Route::post('/item/add', [ItemController::class, 'add']);

Route::post('/item/delete/{id}', [ItemController::class, 'delete']);


// Route::get('/item', function () {
//     return view("item.index");
// });
