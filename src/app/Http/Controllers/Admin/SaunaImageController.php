<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SaunaImage;

class SaunaImageController extends BaseImageController
{
    protected function storagePath(): string { return 'public/saunas'; }

    public function delete(Request $request)
    {
        $image = SaunaImage::find($request->id);

        if ($image) {
            // 2. 基底クラスのメソッドで物理ファイルを削除
            $this->processDelete($image->path);
            // 3. DBレコード削除
            $image->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
