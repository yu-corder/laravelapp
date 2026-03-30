<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sauna;

class SaunaController extends Controller
{
    public function index()
    {
        $saunas = Sauna::with(['firstImage', 'contents' => function($query) {
            $query->where('is_public', true)->latest();
        }])->get();

        return view('sauna.index', compact('saunas'));
    }
}
