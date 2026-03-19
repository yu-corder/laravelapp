<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'contents';

    protected $fillable = [
        'sauna_id',
        'type',
        'title',
        'body',
        'image_path',
        'is_public',
    ];

    public function sauna()
    {
        return $this->belongsTo(Sauna::class, 'sauna_id');
    }
}
