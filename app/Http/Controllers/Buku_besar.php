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
            'buku' => DB::select("SELECT b.id_akun, b.no_akun, b.nm_akun, sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.tgl between '$tgl1' and '$tgl2' group by a.id_akun order by b.no_akun ASC"),
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where  a.tgl between '$tgl1' and '$tgl2'  "),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];

        return view('buku_besar/index', $data);
    }

    public function detail(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $id_akun = $r->id_akun;
        $data = [
            'title' => 'Detail buku besar',
            'buku' => DB::select("SELECT a.tgl, b.id_akun, b.no_akun, a.no_nota, a.ket, b.nm_akun, a.debit, a.kredit 
            FROM tb_jurnal as a 
            left join tb_akun as b on b.id_akun = a.id_akun 
            where a.tgl BETWEEN '$tgl1' AND '$tgl2' and a.id_akun ='$id_akun'  
            order by a.tgl ASC"),
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where  a.tgl between '$tgl1' and '$tgl2' and a.id_akun = '$id_akun'"),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'akun' => DB::table('tb_akun')->where('id_akun', $id_akun)->first()
        ];

        return view('buku_besar/detail', $data);
    }
}
