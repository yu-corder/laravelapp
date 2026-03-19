<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SaunaController;
use App\Http\Controllers\Admin\TmpImageController;
use App\Http\Controllers\Admin\SaunaImageController;
use App\Http\Controllers\Admin\TotonoiHistoryController;
use App\Http\Controllers\Admin\ContentController;


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

// 商品管理システムにアクセスした時はログインページを表示
Route::get('/admin/sauna', function () {
    return view('auth.login');
});

// ログイン認証がされている状態の時のみ
Route::middleware('auth')->group(function () {
    Route::get('/admin/sauna', [SaunaController::class, 'index']);

    Route::post('/admin/sauna/upload-tmp', [TmpImageController::class, 'upload'])->name('admin.sauna.upload_tmp');
    Route::post('/admin/sauna/delete-tmp', [TmpImageController::class, 'delete'])->name('admin.sauna.delete_tmp');

    Route::post('/admin/sauna/delete-img', [SaunaImageController::class, 'delete'])->name('admin.sauna.delete_img');

    Route::get('/admin/sauna/add', [SaunaController::class, 'showAdd']);
    Route::post('/admin/sauna/add', [SaunaController::class, 'add']);

    Route::get('/admin/sauna/edit/{id}', [SaunaController::class, 'showEdit']);
    Route::patch('/admin/sauna/edit/{id}', [SaunaController::class, 'edit']);

    Route::post('/admin/sauna/delete/{id}', [SaunaController::class, 'delete']);

    Route::get('/admin/totonoi-history', [TotonoiHistoryController::class, 'index'])->name('admin.totonoi_history.index');

    Route::get('/admin/totonoi-history/add', [TotonoiHistoryController::class, 'showAdd'])->name('admin.totonoi_history.add');
    Route::post('/admin/totonoi-history/add', [TotonoiHistoryController::class, 'add']);

    Route::get('/admin/totonoi-history/edit/{id}', [TotonoiHistoryController::class, 'showEdit'])->name('admin.totonoi_history.edit');
    Route::post('/admin/totonoi-history/edit/{id}', [TotonoiHistoryController::class, 'edit']);

    Route::post('/admin/totonoi-history/delete/{id}', [TotonoiHistoryController::class, 'delete']);

    Route::get('/admin/contents', [ContentController::class, 'index']);
    Route::get('/admin/content/add', [ContentController::class, 'showAdd']);
    Route::post('/admin/content/add', [ContentController::class, 'add']);

    Route::post('/admin/content/image-upload', [ContentController::class, 'uploadImage'])->name('admin.content.image.upload');
});


require __DIR__.'/auth.php';
