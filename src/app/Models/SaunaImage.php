<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaunaImage extends Model
{
    // テーブル名を明示（単数形・複数形のズレ防止）
    protected $table = 'sauna_images';

    // 一括代入を許可するカラム
    protected $fillable = [
        'sauna_id',
        'path',
        'sort_order',
    ];

    // 親のサウナへのリレーション
    public function sauna()
    {
        return $this->belongsTo(Sauna::class);
    }
}
