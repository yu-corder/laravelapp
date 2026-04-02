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
        return $this->morphMany(Image::class, 'imageable');
    }

    public function firstImage()
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany('display_order');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($sauna) {
            foreach ($sauna->images as $image) {
                if ($image->file_path && \Storage::disk('public')->exists($image->file_path)) {
                    \Storage::disk('public')->delete($image->file_path);
                }
                $image->delete();
            }

            foreach ($sauna->contents as $content) {
                $content->delete();
            }

            if ($sauna->rating) {
                $sauna->rating()->delete();
            }
        });
    }

}
