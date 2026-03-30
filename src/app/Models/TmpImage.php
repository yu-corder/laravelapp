<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpImage extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'file_path'];
}
