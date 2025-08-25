<?php

namespace App\Http\Controllers;

use App\Models\QurbanEvent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $activeQurbanEvent = QurbanEvent::where('registration_deadline', '>=', today())
            ->latest()->first();

        return view('guest.welcome', compact('activeQurbanEvent'));
    }
}
