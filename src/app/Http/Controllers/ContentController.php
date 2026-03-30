<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    public function show($id)
    {
        $content = Content::with('sauna')
            ->where('is_public', true)
            ->findOrFail($id);

        return view('content.show', compact('content'));
    }
}
