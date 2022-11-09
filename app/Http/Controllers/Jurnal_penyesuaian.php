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
            'atk' => DB::table('tb_akun as a')->where('a.id_penyesuaian', '3')->get(),
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
            $akun_id = $id_akun2[$x];
            $jurnal = DB::selectOne("SELECT a.no_nota FROM tb_jurnal as a where a.id_akun = '$akun_id' and a.tgl between '$tgl1' and '$tgl2'");
            $data = [
                'penyesuaian' => 'Y',
            ];
            DB::table('tb_jurnal')->where('no_nota',  $jurnal->no_nota)->update($data);

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
                'admin' =>  Auth::user()->name,
                'penyesuaian' => 'Y'
            ];
            DB::table('tb_asset_umum')->insert($data);
        }

        return redirect()->route("j_penyesuaian")->with('sukses', 'Sukses');
    }

    public function pakan_stok(Request $r)
    {
        $id_akun = $r->id_akun;

        $akun = DB::selectOne("SELECT a.id_akun, b.nm_akun, a.id_relation_debit, c.nm_akun AS akun2
        FROM tb_relasi_akun AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        LEFT JOIN tb_akun AS c ON c.id_akun = a.id_relation_debit
        WHERE a.id_akun = '$id_akun'");

        $jurnal_penyesuaian = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_jurnal AS a
        WHERE a.id_buku = '4'  AND a.id_akun ='$id_akun'");

        $jurnal_umum = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_jurnal AS a
        WHERE a.id_buku = '3' AND a.penyesuaian = 'T'  AND a.id_akun ='$id_akun'");

        if (empty($jurnal_penyesuaian->tgl)) {
            $tgl = date('Y-m-t', strtotime($jurnal_umum->tgl));
        } else {
            $tgl = date('Y-m-d', strtotime('last day of next month', strtotime($jurnal_penyesuaian->tgl)));;
        }

        $barang = DB::select("SELECT b.id_barang , b.nm_barang, SUM(a.debit) AS debit, SUM(a.kredit) AS kredit, c.d_jurnal , c.qty
        FROM tb_asset_pv AS a
        LEFT JOIN tb_barang_pv AS b ON b.id_barang = a.id_barang
        
        LEFT JOIN (SELECT c.id_akun, c.id_barang_pv ,SUM(c.debit) AS d_jurnal , SUM(c.qty) AS qty
        FROM tb_jurnal AS c 
        WHERE c.id_buku='3' and c.id_akun = '$id_akun' AND c.debit != '0' AND c.tgl BETWEEN '2022-01-01' AND '$tgl'
        GROUP BY c.id_barang_pv) AS c ON c.id_barang_pv = a.id_barang
        
        WHERE a.id_akun = ' $id_akun' AND a.tgl BETWEEN '2022-01-01' AND '$tgl'
        GROUP BY a.id_barang");





        $data = [
            'tgl' => $tgl,
            'id_akun' => $id_akun,
            'akun' => $akun,
            'barang' => $barang,
            'id_akun' => $id_akun
        ];
        return view('jurnal_penyesuaian/pakan_stok', $data);
    }

    public function save_pv(Request $r)
    {
        $tgl_pv = $r->tgl_pv;
        $id_akun_debit_pv = $r->id_akun_debit_pv;
        $debit_pv = $r->debit_pv;
        $id_akun_kredit_pv = $r->id_akun_kredit_pv;
        $kredit_pv = $r->kredit_pv;
        $nm_akun_debit_pv = $r->nm_akun_debit_pv;
        $nm_akun_kredit_pv = $r->nm_akun_kredit_pv;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '4'");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }
        $data = [
            'tgl' => $tgl_pv,
            'id_buku' => '4',
            'urutan' => $no_urutan,
            'no_nota' => 'PNY-' . $no_urutan,
            'id_akun' => $id_akun_kredit_pv,
            'kredit' => $kredit_pv,
            'ket' => 'Penyesuaian ' . $nm_akun_kredit_pv,
            'admin' =>  Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);

        $data = [
            'tgl' => $tgl_pv,
            'id_buku' => '4',
            'urutan' => $no_urutan,
            'no_nota' => 'PNY-' . $no_urutan,
            'id_akun' => $id_akun_debit_pv,
            'debit' => $debit_pv,
            'ket' => 'Penyesuaian ' . $nm_akun_debit_pv,
            'admin' =>  Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);



        $id_barang = $r->id_barang;
        $qty_pv = $r->qty_pv;
        $selisih_pv = $r->selisih_pv;
        $h_satuan_pv = $r->h_satuan_pv;


        for ($x = 0; $x < count($id_barang); $x++) {
            $data = [
                'id_akun' => $id_akun_kredit_pv,
                'tgl' => $tgl_pv,
                'kredit' => $selisih_pv[$x],
                'no_nota' =>  'PNY-' . $no_urutan,
                'id_barang' => $id_barang[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_asset_pv')->insert($data);

            $data = [
                'id_barang' => $id_barang[$x],
                'id_akun' => $id_akun_kredit_pv,
                'saldo' => $qty_pv[$x],
                'tgl' => $tgl_pv,
                'no_nota' =>  'PNY-' . $no_urutan,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_neraca_asset_pv')->insert($data);
        }

        $tgl1 = date('Y-m-01', strtotime($tgl_pv));
        $akun_id = $r->pakan_id;
        $jurnal = DB::selectOne("SELECT a.no_nota FROM tb_jurnal as a where a.id_akun = '$akun_id' and a.tgl between '$tgl1' and '$tgl_pv'");
        $data = [
            'penyesuaian' => 'Y',
        ];
        DB::table('tb_jurnal')->where('no_nota',  $jurnal->no_nota)->update($data);
        return redirect()->route("j_penyesuaian", ['tgl1' => $tgl1, 'tgl2' => $tgl_pv])->with('sukses', 'Data berhasil di input');
    }



    public function atk_stok(Request $r)
    {
        $id_akun = $r->id_akun;

        $akun = DB::selectOne("SELECT a.id_akun, b.nm_akun, a.id_relation_debit, c.nm_akun AS akun2
        FROM tb_relasi_akun AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        LEFT JOIN tb_akun AS c ON c.id_akun = a.id_relation_debit
        WHERE a.id_akun = '$id_akun'");

        $jurnal_penyesuaian = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_jurnal AS a
        WHERE a.id_buku = '4'  AND a.id_akun ='$id_akun'");

        $jurnal_umum = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_jurnal AS a
        WHERE a.id_buku = '3' AND a.penyesuaian = 'T'  AND a.id_akun ='$id_akun'");

        if (empty($jurnal_penyesuaian->tgl)) {
            $tgl = date('Y-m-t', strtotime($jurnal_umum->tgl));
        } else {
            $tgl = date('Y-m-d', strtotime('last day of next month', strtotime($jurnal_penyesuaian->tgl)));;
        }

        $barang = DB::select("SELECT b.nm_post, a.id_post, SUM(a.qty_debit) AS qty_debit, SUM(a.qty_kredit) AS qty_kredit, a.h_satuan
        FROM table_atk AS a
        LEFT JOIN tb_post_center AS b ON b.id_post = a.id_post
        WHERE a.id_akun = '$id_akun' AND a.tgl BETWEEN '2022-01-01' AND '$tgl'
        GROUP BY a.id_post");
        $data = [
            'tgl' => $tgl,
            'id_akun' => $id_akun,
            'akun' => $akun,
            'barang' => $barang
        ];
        return view('jurnal_penyesuaian/atk_stok', $data);
    }

    public function save_atk(Request $r)
    {
        $tgl_atk = $r->tgl_atk;
        $id_akun_debit_atk = $r->id_akun_debit_atk;
        $debit_atk = $r->debit_atk;
        $id_akun_kredit_atk = $r->id_akun_kredit_atk;
        $kredit_atk = $r->kredit_atk;
        $nm_akun_debit_atk = $r->nm_akun_debit_atk;
        $nm_akun_kredit_atk = $r->nm_akun_kredit_atk;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '4'");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }
        $data = [
            'tgl' => $tgl_atk,
            'id_buku' => '4',
            'urutan' => $no_urutan,
            'no_nota' => 'PNY-' . $no_urutan,
            'id_akun' => $id_akun_kredit_atk,
            'kredit' => $kredit_atk,
            'ket' => 'Penyesuaian ' . $nm_akun_kredit_atk,
            'admin' =>  Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);

        $data = [
            'tgl' => $tgl_atk,
            'id_buku' => '4',
            'urutan' => $no_urutan,
            'no_nota' => 'PNY-' . $no_urutan,
            'id_akun' => $id_akun_debit_atk,
            'debit' => $debit_atk,
            'ket' => 'Penyesuaian ' . $nm_akun_kredit_atk,
            'admin' =>  Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);



        $id_post = $r->id_post;
        $qty_pv = $r->qty_pv;
        $selisih_atk = $r->selisih_atk;
        $h_satuan_atk = $r->h_satuan_atk;


        for ($x = 0; $x < count($id_post); $x++) {
            $data = [
                'id_akun' => $id_akun_kredit_atk,
                'tgl' => $tgl_atk,
                'qty_kredit' => $selisih_atk[$x],
                'no_nota' =>  'PNY-' . $no_urutan,
                'id_post' => $id_post[$x],
                'admin' => Auth::user()->name,
                'h_satuan' => $h_satuan_atk[$x]
            ];
            DB::table('table_atk')->insert($data);

            // $data = [
            //     'id_barang' => $id_barang[$x],
            //     'id_akun' => $id_akun_kredit_pv,
            //     'saldo' => $qty_pv[$x],
            //     'tgl' => $tgl_pv,
            //     'no_nota' =>  'PNY-' . $no_urutan,
            //     'admin' => Auth::user()->name
            // ];
            // DB::table('tb_neraca_asset_pv')->insert($data);
        }

        $tgl1 = date('Y-m-01', strtotime($tgl_atk));
        return redirect()->route("j_penyesuaian", ['tgl1' => $tgl1, 'tgl2' => $tgl_atk])->with('sukses', 'Data berhasil di input');
    }

    public function delete_penyesuaian(Request $r)
    {
        DB::table('tb_jurnal')->where('no_nota', $r->no_nota)->delete();
        DB::table('tb_asset_pv')->where('no_nota', $r->no_nota)->delete();
        DB::table('tb_neraca_asset_pv')->where('no_nota', $r->no_nota)->delete();
        DB::table('tb_asset_umum')->where('no_nota', $r->no_nota)->delete();
        DB::table('tb_neraca_asset_umum')->where('no_nota', $r->no_nota)->delete();
        DB::table('table_atk')->where('no_nota', $r->no_nota)->delete();

        return redirect()->route("j_penyesuaian")->with('sukses', 'Data berhasil dihapus');
    }
}
