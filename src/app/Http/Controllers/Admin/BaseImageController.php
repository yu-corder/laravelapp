<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ImageRequest;
use Illuminate\Support\Facades\Log;

abstract class BaseImageController extends Controller
{
    abstract protected function storagePath(): string;

    /**
     * アップロード共通処理
     */
    protected function processUpload(ImageRequest $request,$key = 'image')
    {
        $file = $request->file($key);
        return $file->store($this->storagePath(), 'public');
    }

    /**
     * 削除共通処理
     * @param string $path ストレージ上のパス（public/tmp/xxx.jpg など）
     */
    protected function processDelete(string $path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}
