<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Buku_besar extends Controller
{
    public function index(Request $r)
    {
        $jurnal = DB::selectOne("SELECT min(a.tgl) as tgl FROM tb_jurnal as a");
        if (empty($r->tgl1)) {
            $tgl1 = $jurnal->tgl;
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }
        $data = [
            'title' => 'Buku besar',
            'buku' => DB::select("SELECT b.no_akun, b.nm_akun, sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.tgl between '$tgl1' and '$tgl2' group by a.id_akun order by b.no_akun ASC"),
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where  a.tgl between '$tgl1' and '$tgl2'  "),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];

        return view('buku_besar/index', $data);
    }
}
