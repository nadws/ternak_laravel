<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Setoran_ayam extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Setoran Ayam',
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'setor' => DB::select("SELECT a.no_nota as nota_ayam, b.id_akun, d.nm_post, a.urutan, b.no_nota, b.tgl,c.nm_akun, b.debit
            FROM invoice_ayam AS a
            LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('A-',a.no_nota)
            LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
            LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post 
            WHERE b.id_buku = '1' AND b.id_akun IN ('33','32') AND b.setor = 'T'
            order by a.id_invoice_ayam ASC")
        ];

        return view('setor_ayam/index', $data);
    }

    public function rencana_ayam(Request $r)
    {
        $nota = $r->no_nota;

        $data = [
            'nota' => $nota,
        ];
        return view('setor_ayam/perencanaan', $data);
    }
}
