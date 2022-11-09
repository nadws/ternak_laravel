<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Laba_rugi extends Controller
{
    public function index(Request $r)
    {

        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-t');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $penjualan = DB::select("SELECT b.nm_akun, SUM(a.kredit) AS penjualan
        FROM tb_jurnal AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        WHERE b.id_kategori ='4' AND a.id_buku ='1' AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id_akun");
        $biaya = DB::select("SELECT b.nm_akun, SUM(a.debit) AS d_biaya, SUM(a.kredit) AS k_biaya
        FROM tb_jurnal AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        WHERE b.id_kategori ='5' AND a.id_buku in('3','4','5') AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id_akun");
        $data = [
            'title' => 'laporan Laba Rugi',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'penjualan' => $penjualan,
            'biaya' => $biaya
        ];
        return view('laba_rugi/index', $data);
    }
}
