<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TotonoiHistory extends Model
{
    use HasFactory;

    protected $table = 't_totonoi_histories';

    protected $fillable = [
        'sauna_id',
        'visit_date',
        'price',
        'comment',
    ];

    public function sauna(): BelongsTo
    {
        return $this->belongsTo(Sauna::class, 'sauna_id', 'id');
    }
}
