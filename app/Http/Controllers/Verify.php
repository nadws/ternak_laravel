<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Verify extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'is_active' => '1',
            'remember_token' => ''
        ];
        DB::table('users')->where([['email', $r->email], ['remember_token', $r->token]])->update($data);
        return redirect()->route('login');
    }
}
