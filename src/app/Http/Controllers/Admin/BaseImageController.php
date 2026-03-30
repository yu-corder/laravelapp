<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ImageRequest;

abstract class BaseImageController extends Controller
{
    abstract protected function storagePath(): string;

    /**
     * アップロード共通処理
     */
    protected function processUpload(ImageRequest $request,$key = 'image')
    {
        $file = $request->file($key);
        return $file->store('tmp', 'public');
    }

    /**
     * 削除共通処理
     * @param string $path ストレージ上のパス（public/tmp/xxx.jpg など）
     */
    protected function processDelete(string $path)
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }
        return false;
    }
}
