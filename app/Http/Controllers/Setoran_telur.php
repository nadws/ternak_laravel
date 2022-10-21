<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Setoran_telur extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Setoran Telur',
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'setor' => DB::select("SELECT a.no_nota as nota_telur, b.id_akun, d.nm_post, a.urutan, b.no_nota, b.tgl,c.nm_akun, b.debit
           FROM invoice_telur AS a
           LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('T-',a.no_nota)
           LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
           LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post 
           WHERE b.id_buku = '1' AND b.id_akun IN ('33','32') AND b.setor = 'T'
           GROUP BY a.no_nota
           order by a.id_invoice_telur ASC")
        ];

        return view('setor_telur/index', $data);
    }

    public function rencana_telur(Request $r)
    {
        $nota = $r->no_nota;

        $data = [
            'nota' => $nota,
        ];
        return view('setor_telur/perencanaan', $data);
    }
}
