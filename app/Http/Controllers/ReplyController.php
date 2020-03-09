<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Content;

class ReplyController extends Controller
{
    

    public function show(Request $request, int $id) {
        $content = Content::findOrFail($id);
        
        return view('replies.show', compact('content'));
    }
}
