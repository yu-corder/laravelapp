<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sauna;

class SaunaController extends Controller
{
    public function index()
    {
        $saunas = Sauna::select('saunas.*')
        ->leftJoin('ratings', 'saunas.id', '=', 'ratings.sauna_id')
        ->with(['firstImage', 'rating', 'contents' => function($query) {
            $query->where('is_public', true)->latest();
        }])
        ->orderByDesc('ratings.total_score')
        ->get();

        return view('sauna.index', compact('saunas'));
    }
}
