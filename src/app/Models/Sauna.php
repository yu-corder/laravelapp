<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sauna extends Model
{
    use HasFactory;

    // 保存を許可するカラムを指定
    protected $fillable = [
        'name',
        'postcode',
        'prefecture',
        'city',
        'address',
        'sauna_temp',
        'water_temp',
        'has_loyly',
        'description',
        'price',
        'weekend_price',
    ];

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function images()
    {
        return $this->hasMany(SaunaImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(SaunaImage::class)->oldestOfMany();
    }

}
