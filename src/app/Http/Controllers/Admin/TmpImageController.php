<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TmpSaunaImage;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ImageRequest;

class TmpImageController extends BaseImageController
{
    protected function storagePath(): string { return 'public/tmp'; }

    public function upload(ImageRequest $request)
    {

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $this->processUpload($request);

            $tmp = TmpSaunaImage::create([
                'upload_token' => $request->upload_token,
                'path' => $path,
            ]);

            return response()->json([
                'status' => 'success',
                'path' => $path,
                'url' => Storage::url($path),
                'id' => $tmp->id,
                'msg' => '画像を一時保存しました',
            ]);
        }

        return response()->json(['status' => 'error', 'msg' => 'アップロード失敗'], 400);
    }

    public function delete(ImageRequest $request)
    {
        $tmpImage = TmpSaunaImage::find($request->id);

        if ($tmpImage) {
            // 2. 基底クラスのメソッドで物理ファイルを削除
            $this->processDelete($tmpImage->path);
            // 3. DBレコード削除
            $tmpImage->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
