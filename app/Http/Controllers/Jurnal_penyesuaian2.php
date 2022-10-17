<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Jurnal_penyesuaian2 extends Controller
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
        $jurnal = DB::select("SELECT * FROM tb_jurnal as a left join tb_akun as b on a.id_akun = b.id_akun where a.id_buku = '5' and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");
        $data = [
            'title' => 'Jurnal Penyesuaian',
            'akun' => DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->get(),
            'jurnal' => $jurnal,
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where a.id_buku = '5' and a.tgl between '$tgl1' and '$tgl2' "),
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'akun_aktiva' => DB::table('tb_akun as a')->where('a.id_penyesuaian', '2')->get(),
        ];
        return view('jurnal_penyesuaian2/index', $data);
    }

    public function aktiva_penyesuaian(Request $r)
    {
        $id_akun = $r->id_akun;

        $akun = DB::selectOne("SELECT a.id_akun, b.nm_akun, a.id_relation_debit, c.nm_akun AS akun2
        FROM tb_relasi_akun AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        LEFT JOIN tb_akun AS c ON c.id_akun = a.id_relation_debit
        WHERE a.id_akun = '$id_akun'");

        $jurnal_penyesuaian = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_jurnal AS a
        WHERE a.id_buku = '5'  AND a.id_akun ='$id_akun'");

        $jurnal_umum = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_jurnal AS a
        WHERE a.id_buku = '3' AND a.penyesuaian = 'T'  AND a.id_akun ='$id_akun'");

        if (empty($jurnal_penyesuaian->tgl)) {
            $tgl = date('Y-m-t', strtotime($jurnal_umum->tgl));
        } else {
            $tgl = date('Y-m-d', strtotime('last day of next month', strtotime($jurnal_penyesuaian->tgl)));;
        }

        $aktiva = DB::select("SELECT a.id_post, a.tgl,  b.nm_post, b.id_akun, SUM(a.debit_aktiva) AS debit , 
        SUM(a.kredit_aktiva) AS kredit,a.b_penyusutan
        FROM aktiva AS a
        LEFT JOIN tb_post_center AS b ON b.id_post = a.id_post
        WHERE a.id_akun ='$id_akun' AND a.tgl < '$tgl' 
        GROUP BY a.id_post");

        $data = [
            'tgl' => $tgl,
            'id_akun' => $id_akun,
            'akun' => $akun,
            'aktiva' => $aktiva
        ];
        return view('jurnal_penyesuaian2/aktiva', $data);
    }

    public function save_aktiva(Request $r)
    {
        $id_akun_debit = $r->id_akun_debit;
        $debit = $r->debit;
        $id_akun_kredit = $r->id_akun_kredit;
        $kredit = $r->kredit;
        $tgl = $r->tgl;
        $nm_akun_debit = $r->nm_akun_debit;
        $nm_akun_kredit = $r->nm_akun_kredit;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '5'");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }
        $data = [
            'tgl' => $tgl,
            'id_buku' => '5',
            'urutan' => $no_urutan,
            'no_nota' => 'PNY-' . $no_urutan,
            'id_akun' => $id_akun_kredit,
            'kredit' => $kredit,
            'ket' => 'Penyesuaian ' . $nm_akun_kredit,
            'admin' =>  Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);
        $data = [
            'tgl' => $tgl,
            'id_buku' => '5',
            'urutan' => $no_urutan,
            'no_nota' => 'PNY-' . $no_urutan,
            'id_akun' => $id_akun_debit,
            'debit' => $debit,
            'ket' => 'Penyesuaian ' . $nm_akun_debit,
            'admin' =>  Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);


        $id_post = $r->id_post;
        $b_penyusutan = $r->b_penyusutan;

        for ($x = 0; $x < count($id_post); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_post' => $id_post[$x],
                'no_nota' => 'PNY-' . $no_urutan,
                'id_post' => $id_post[$x],
                'kredit_aktiva' => $b_penyusutan[$x],
                'id_akun' => $id_akun_kredit,
                'admin' =>  Auth::user()->name
            ];
            DB::table('aktiva')->insert($data);
        }
        $tgl1 = date('Y-m-01', strtotime($tgl));
        return redirect()->route("j_penyesuaian2", ['tgl1' => $tgl1, 'tgl2' => $tgl])->with('sukses', 'Sukses');
    }
}
