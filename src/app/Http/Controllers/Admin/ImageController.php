<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Requests\Admin\ImageRequest;
use Illuminate\Support\Facades\Log;

class ImageController extends BaseImageController
{
    protected function storagePath(): string { return 'saunas'; }

    public function delete(ImageRequest $request)
    {
        $image = Image::find($request->id);

        if ($image) {
            $this->processDelete($image->file_path);
            $image->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
