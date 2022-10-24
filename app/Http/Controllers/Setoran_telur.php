<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function save_perencanaan_telur(Request $r)
    {
        $tgl = $r->tgl;
        $no_nota = $r->no_nota;
        $id_akun = $r->id_akun;
        $debit = $r->debit;

        $urutan = DB::selectOne("SELECT MAX(a.urutan) AS urutan
        FROM setoran_telur AS a where a.id_akun = '33'");

        if (empty($urutan->urutan)) {
            $urt = '1001';
        } else {
            $urt = $urutan->urutan + 1;
        }

        $urutan2 = DB::selectOne("SELECT MAX(a.urutan) AS urutan
        FROM setoran_telur AS a where a.id_akun = '32'");

        if (empty($urutan2->urutan)) {
            $urt2 = '1001';
        } else {
            $urt2 = $urutan->urutan + 1;
        }

        for ($x = 0; $x < count($no_nota); $x++) {

            if ($id_akun == '33') {
                $data = [
                    'no_nota' => $no_nota[$x],
                    'nota_setor' => 'T' . $urt,
                    'id_akun' => $id_akun[$x],
                    'tgl' => $tgl,
                    'debit' => $debit[$x],
                    'kredit' => '0',
                    'admin' => Auth::user()->name,
                    'urutan' => $urt
                ];

                DB::table('setoran_telur')->insert($data);
            } else {
                $data = [
                    'no_nota' => $no_nota[$x],
                    'nota_setor' => 'B' . $urt2,
                    'id_akun' => $id_akun[$x],
                    'tgl' => $tgl,
                    'debit' => $debit[$x],
                    'kredit' => '0',
                    'admin' => Auth::user()->name,
                    'urutan' => $urt
                ];

                DB::table('setoran_telur')->insert($data);
            }


            $data = [
                'setor' => 'Y'
            ];
            DB::table('tb_jurnal')->where('no_nota', $no_nota[$x])->where('id_akun', $id_akun[$x])->update($data);
        }

        return redirect()->route("setor_telur")->with('sukses', 'Perencanaan berhasil disimpan');
    }

    public function list_perencanaan(Request $r)
    {
        $list = DB::select("SELECT a.tgl, a.nota_setor, SUM(a.debit) AS debit, b.nm_akun
        FROM setoran_telur AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        where a.setuju = 'T'
        GROUP BY a.nota_setor");

        $data = [
            'list' => $list
        ];
        return view('setor_telur/list', $data);
    }
    public function detail_list_perencanaan(Request $r)
    {
        $nota = $r->nota;

        $list = DB::select("SELECT a.tgl, a.id_akun, a.nota_setor, a.no_nota, a.debit AS debit, b.nm_akun, c.nm_post, c.urutan
        FROM setoran_telur AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        left join (
            SELECT a.no_nota, a.urutan, b.nm_post
            FROM invoice_telur as a
            left join tb_post_center as b on b.id_post = a.id_post
            group by a.no_nota
        ) as c on concat('T-',c.no_nota) = a.no_nota
        where a.setuju = 'T' and a.nota_setor = '$nota'");

        $data = [
            'list' => $list,
            'nota' => $nota
        ];
        return view('setor_telur/detail_list', $data);
    }

    public function save_jurnal_setoran(Request $r)
    {
        $id_akun = $r->id_akun;
        $id_akun2 = $r->id_akun2;
        $no_nota = $r->no_nota;
        $keterangan = $r->keterangan;
        $rupiah = $r->rupiah;
        $tgl = $r->tgl;

        $data = [
            'tgl' => $tgl,
            'id_akun' => $id_akun,
            'id_buku' => '3',
            'no_nota' => $no_nota,
            'ket' => $keterangan,
            'debit' => $rupiah,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data);
        $data = [
            'tgl' => $tgl,
            'id_akun' => $id_akun2,
            'id_buku' => '3',
            'no_nota' => $no_nota,
            'ket' => $keterangan,
            'kredit' => $rupiah,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data);


        DB::table('setoran_telur')->where('nota_setor', $no_nota)->update(['setuju' => 'Y']);

        return redirect()->route("setor_telur")->with('sukses', 'Perencanaan berhasil disimpan');
    }
}
