<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Piutang_ayam extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Piutang Ayam',
            'akun' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get(),
            'piutang' => DB::select("SELECT a.tgl, a.no_nota, sum(a.debit) AS debit, sum(a.kredit) AS kredit, c.nm_post, b.urutan, a.admin
            FROM tb_jurnal AS a
            LEFT JOIN (SELECT b.no_nota, b.urutan, b.id_post FROM invoice_ayam AS b GROUP BY b.no_nota ) AS b ON concat('A-',b.no_nota)  = a.no_nota
            LEFT JOIN tb_post_center AS c ON c.id_post = b.id_post
            WHERE a.id_akun = '52' 
            GROUP BY a.no_nota"),
        ];

        return view('piutang_ayam/index', $data);
    }
}
