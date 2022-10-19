<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Piutang_kardus extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Piutang Kardus',
            'akun' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get(),
            'piutang' => DB::select("SELECT a.tgl, a.no_nota, sum(a.debit) AS debit, sum(a.kredit) AS kredit, c.nm_post, b.urutan, a.admin
            FROM tb_jurnal AS a
            LEFT JOIN (SELECT b.no_nota, b.urutan, b.id_post FROM invoice_ayam AS b GROUP BY b.no_nota ) AS b ON concat('K-',b.no_nota)  = a.no_nota
            LEFT JOIN tb_post_center AS c ON c.id_post = b.id_post
            WHERE a.id_akun = '54' 
            GROUP BY a.no_nota"),
        ];

        return view('piutang_kardus/index', $data);
    }

    public function bayar(Request $r)
    {
        $nota = $r->no_nota;

        $data = [
            'nota' => $nota,
            'akun' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get(),
        ];
        return view('Piutang_kardus/bayar', $data);
    }

    public function save_piutang_k(Request $r)
    {
        $no_nota = $r->no_nota;
        $kredit = $r->kredit;
        $tgl = $r->tgl;
        $id_akun = $r->id_akun;
        $debit = $r->debit;
        $kredit2 = $r->kredit2;
        $ket = $r->ket;
        $id_post = $r->id_post;
        $kredit_bayar = $r->kredit_bayar;
        $nota_invo = $r->nota_invo;



        $nota = 0;
        for ($x = 0; $x < count($no_nota); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_buku' => '1',
                'no_nota' => $no_nota[$x],
                'id_akun' => '54',
                'ket' => 'Pelunasan piutang',
                'kredit' => $kredit_bayar[$x],
                'id_post' => $id_post[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
            if ($kredit[$x] - $kredit_bayar[$x] < 1) {
                $data_invoice = [
                    'lunas' => 'Y'
                ];
                DB::table('invoice_kardus')->where('no_nota', $nota_invo[$x])->update($data_invoice);
            } else {
                # code...
            }
            $nota = $no_nota[$x];
        }
        for ($x = 0; $x < count($id_akun); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_buku' => '1',
                'no_nota' => $nota,
                'id_akun' => $id_akun[$x],
                'ket' => $ket[$x],
                'debit' => $debit[$x],
                'kredit' => $kredit2[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        return redirect()->route("p_kardus")->with('sukses', 'Sukses');
    }
}
