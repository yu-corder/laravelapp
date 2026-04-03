<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    public function show($id)
    {
        $content = Content::with(['sauna.images' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->where('is_public', true)
        ->findOrFail($id);

        $saunaImage = $content->sauna->images->first();

        return view('content.show', compact('content', 'saunaImage'));
    }
}
