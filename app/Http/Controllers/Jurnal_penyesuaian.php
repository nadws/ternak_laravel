<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Jurnal_penyesuaian extends Controller
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
        $jurnal = DB::select("SELECT * FROM tb_jurnal as a left join tb_akun as b on a.id_akun = b.id_akun where a.id_buku = '4' and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");
        $data = [
            'title' => 'Jurnal Penyesuaian',
            'akun' => DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->get(),
            'jurnal' => $jurnal,
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where a.id_buku = '4' and a.tgl between '$tgl1' and '$tgl2' "),
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'akun_asset_pv' => DB::table('tb_akun as a')->where('a.id_penyesuaian', '4')->get(),
        ];
        return view('jurnal_penyesuaian/index', $data);
    }

    public function penyesuaian_stok(Request $r)
    {
        $tgl = DB::select("SELECT a.id_akun, min(a.tgl) AS tgl
        FROM tb_asset_umum AS a
        WHERE a.disesuaikan = 'T'
        GROUP BY a.id_akun");



        $data = [
            'tgl' => $tgl
        ];
        return view('jurnal_penyesuaian/p_stok', $data);
    }

    public function save_penyesuaian_stok(Request $r)
    {
        $tgl = $r->tgl;
        $qty_aktual = $r->qty_aktual;
        $selisih = $r->selisih;
        $id_akun = $r->id_akun;
        $id_akun2 = $r->id_akun2;
        $debit = $r->debit;
        $nm_akun = $r->nm_akun;


        for ($x = 0; $x < count($tgl); $x++) {

            $tgl1 = date('Y-m-01', strtotime($tgl[$x]));
            $tgl2 = date('Y-m-t', strtotime($tgl[$x]));

            $tgl3 = date('Y-m-d', strtotime('first day of next month', strtotime($tgl1)));


            $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '4'");

            if (empty($urutan->urutan)) {
                $no_urutan = '1001';
            } else {
                $no_urutan = $urutan->urutan + 1;
            }
            $data = [
                'tgl' => $tgl[$x],
                'id_buku' => '4',
                'id_akun' => $id_akun[$x],
                'debit' => $debit[$x],
                'ket' => 'Penyesuaian ' . $nm_akun[$x],
                'urutan' => $no_urutan,
                'no_nota' => 'PNY-' . $no_urutan,
                'admin' =>  Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
            $data = [
                'tgl' => $tgl[$x],
                'id_buku' => '4',
                'id_akun' => $id_akun2[$x],
                'kredit' => $debit[$x],
                'ket' => 'Penyesuaian ' . $nm_akun[$x],
                'no_nota' => 'PNY-' . $no_urutan,
                'urutan' => $no_urutan,
                'admin' =>  Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);

            $data = [
                'disesuaikan' => 'Y',
            ];
            DB::table('tb_asset_umum')->where('id_akun', $id_akun2[$x])->whereBetween('tgl', [$tgl1, $tgl2])->update($data);

            $data = [
                'id_akun' => $id_akun2[$x],
                'tgl' => $tgl[$x],
                'stok' => $qty_aktual[$x],
                'no_nota' => 'PNY-' . $no_urutan,
                'admin' =>  Auth::user()->name
            ];
            DB::table('tb_neraca_asset_umum')->insert($data);

            $data = [
                'id_akun' => $id_akun2[$x],
                'tgl' => $tgl3,
                'kredit' => $selisih[$x],
                'no_nota' => 'PNY-' . $no_urutan,
                'admin' =>  Auth::user()->name
            ];
            DB::table('tb_asset_umum')->insert($data);
        }

        return redirect()->route("j_penyesuaian")->with('sukses', 'Sukses');
    }

    public function pakan_stok(Request $r)
    {
        $id_akun = $r->id_akun;
        $tgl = DB::select("SELECT a.id_akun, min(a.tgl) AS tgl
        FROM tb_asset_umum AS a
        WHERE a.disesuaikan = 'T'
        GROUP BY a.id_akun");

        $akun = DB::selectOne("SELECT a.id_akun, b.nm_akun, a.id_relation_debit, c.nm_akun AS akun2
        FROM tb_relasi_akun AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        LEFT JOIN tb_akun AS c ON c.id_akun = a.id_relation_debit
        WHERE a.id_akun = '$id_akun'");



        $data = [
            'tgl' => $tgl,
            'id_akun' => $id_akun,
            'akun' => $akun
        ];
        return view('jurnal_penyesuaian/pakan_stok', $data);
    }
}
