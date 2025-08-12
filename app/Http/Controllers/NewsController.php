<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        $articles = Cache::get('top_headlines', []);
        return view('berita.index', ['articles' => $articles]);
    }
}