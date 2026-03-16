<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TmpSaunaImage;

class SaunaImage extends Model
{
    /**
     * テーブル名の明示
     */
    protected $table = 'sauna_images';

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'sauna_id',
        'path',
        'sort_order',
    ];

    /**
     * リレーション
     */
    public function sauna()
    {
        return $this->belongsTo(Sauna::class);
    }

    public static function createFromTmpToken(int $saunaId, string $token)
    {
        $tmpImages = TmpSaunaImage::where('upload_token', $token)->get();

        foreach ($tmpImages as $tmpImage) {
            $newPath = str_replace('public/tmp/', 'public/saunas/', $tmpImage->path);
            \Storage::move($tmpImage->path, $newPath);

            self::create([
                'sauna_id' => $saunaId,
                'path'     => $newPath,
            ]);
            $tmpImage->delete();
        }
    }
}
