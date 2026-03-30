<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\TmpImage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['imageable_type', 'imageable_id', 'file_path', 'display_order'];

    /**
     * ポリモーフィックリレーションの定義
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * 一時保存から本番保存へ移動する共通ロジック
     * @param string $token アップロードトークン
     * @param Model $model 紐付け先のモデルインスタンス
     */
    public static function moveFromTmp($token, Model $model)
    {
        $tmpImages = TmpImage::where('token', $token)->get();
        $results = [];

        foreach ($tmpImages as $tmp) {
            $folder = strtolower(class_basename($model));
            $newPath = "{$folder}/{$model->id}/" . basename($tmp->file_path);

            if (Storage::disk('public')->exists($tmp->file_path)) {
                Storage::disk('public')->move($tmp->file_path, $newPath);

                $results[] = [
                    'old_url' => Storage::url($tmp->file_path),
                    'new_url' => Storage::url($newPath),
                ];

                $model->images()->create([
                    'file_path' => $newPath,
                    'display_order' => 0,
                ]);
                $tmp->delete();
            }
        }
        return $results;
    }
}
