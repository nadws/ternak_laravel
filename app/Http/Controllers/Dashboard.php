<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Dashboard'
        ];

        return view('welcome', $data);
    }
}
