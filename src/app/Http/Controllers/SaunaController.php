<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sauna;

class SaunaController extends Controller
{
    public function index()
    {
        $saunas = Sauna::with('firstImage')->get();

        return view('sauna.index', compact('saunas'));
    }
}
