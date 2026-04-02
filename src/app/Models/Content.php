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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($content) {
            foreach ($content->images as $image) {
                if ($image->file_path && \Storage::disk('public')->exists($image->file_path)) {
                    \Storage::disk('public')->delete($image->file_path);
                }
                $image->delete();
            }

            $pattern = '/storage\/(content\/' . $content->id . '\/.*?\.(jpg|jpeg|png|gif|webp))/i';
            if (preg_match_all($pattern, $content->body, $matches)) {
                foreach ($matches[1] as $path) {
                    \Storage::disk('public')->delete($path);
                }
            }

            $directory = "content/{$content->id}";
            if (\Storage::disk('public')->exists($directory)) {
                \Storage::disk('public')->deleteDirectory($directory);
            }
        });
    }
}
