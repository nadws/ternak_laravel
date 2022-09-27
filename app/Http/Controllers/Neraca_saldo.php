<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Neraca_saldo extends Controller
{
    public function index(Request $r)
    {

        if (empty($r->month)) {
            $month = date('m');
            $year = date('Y');
        } else {
            $month = $r->month;
            $year = $r->year;
        }
        $data = [
            'title' => 'Neraca Saldo',
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'bulan' => $month,
            'tahun' => $year,
            's_tahun' => DB::select("SELECT a.tgl FROM tb_neraca_saldo as a group by YEAR(a.tgl)")
        ];

        return view('Saldo/index', $data);
    }
}
