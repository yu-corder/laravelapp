<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TmpImage;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ImageRequest;

class TmpImageController extends BaseImageController
{
    protected function storagePath(): string { return 'public/tmp'; }

    public function upload(ImageRequest $request)
    {
        $fileKey = $request->hasFile('upload') ? 'upload' : 'image';

        if ($request->hasFile($fileKey)) {
            $path = $this->processUpload($request, $fileKey);

            $tmp = TmpImage::create([
                'token' => $request->upload_token,
                'file_path' => $path,
            ]);

            return response()->json([
                'status'  => 'success',
                'uploaded' => true,
                'path'    => $path,
                'url'     => Storage::url($path),
                'id'      => $tmp->id,
                'msg'     => '画像を一時保存しました',
            ]);
        }

        return response()->json(['status' => 'error', 'msg' => 'アップロード失敗'], 400);
    }

    public function delete(ImageRequest $request)
    {
        $tmpImage = TmpImage::find($request->id);

        if ($tmpImage) {
            $this->processDelete($tmpImage->path);
            $tmpImage->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
