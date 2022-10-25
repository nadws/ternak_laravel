<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('setor_ayam.index', $data);
    }

    public function rencana_ayam(Request $r)
    {
        $nota = $r->no_nota;

        $data = [
            'nota' => $nota,
        ];
        return view('setor_ayam.perencanaan', $data);
    }

    public function save_perencanaan_ayam(Request $r)
    {
        $tgl = $r->tgl;
        $no_nota = $r->no_nota;
        $id_akun = $r->id_akun;
        $debit = $r->debit;
        
        $urutan = DB::selectOne("SELECT MAX(a.urutan) AS urutan
        FROM setoran_ayam AS a where a.id_akun = '33'");

        $urt = empty($urutan->urutan) ? '1001' : $urutan->urutan + 1;

        $urutan2 = DB::selectOne("SELECT MAX(a.urutan) AS urutan
        FROM setoran_ayam AS a where a.id_akun = '32'");

        $urt2 = empty($urutan2->urutan) ? '1001' : $urutan2->urutan + 1;

        for ($x = 0; $x < count($no_nota); $x++) {

            $data = [
                'no_nota' => $no_nota[$x],
                'nota_setor' => $id_akun[$x] == '33' ? "T$urt" : "B$urt2",
                'id_akun' => $id_akun[$x],
                'tgl' => $tgl,
                'debit' => $debit[$x],
                'kredit' => '0',
                'admin' => Auth::user()->name,
                'urutan' => $id_akun[$x] == '33' ? $urt : $urt2
            ];

            DB::table('setoran_ayam')->insert($data);

            $data = [
                'setor' => 'Y'
            ];
            DB::table('tb_jurnal')->where([
                    ['no_nota', $no_nota[$x]],
                    ['id_akun', $id_akun[$x]]
                ])->update($data);
            
        }
        return redirect()->route("setor_ayam")->with('sukses', 'Perencanaan berhasil disimpan');
    }

    public function list_perencanaan_ayam(Request $r)
    {
        $list = DB::select("SELECT a.tgl, a.nota_setor, SUM(a.debit) AS debit, b.nm_akun
        FROM setoran_ayam AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        where a.setuju = 'T'
        GROUP BY a.nota_setor");

        $data = [
            'list' => $list
        ];
        return view('setor_ayam/list', $data);
    }

    public function detail_list_perencanaan_ayam(Request $r)
    {
        $nota = $r->nota;

        $list = DB::select("SELECT a.tgl, a.id_akun, a.nota_setor, a.no_nota, a.debit AS debit, b.nm_akun, c.nm_post, c.urutan
        FROM setoran_ayam AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        left join (
            SELECT a.no_nota, a.urutan, b.nm_post
            FROM invoice_ayam as a
            left join tb_post_center as b on b.id_post = a.id_post
            group by a.no_nota
        ) as c on concat('T-',c.no_nota) = a.no_nota
        where a.setuju = 'T' and a.nota_setor = '$nota'");

        $data = [
            'list' => $list,
            'nota' => $nota
        ];
        return view('setor_ayam/detail_list', $data);
    }

    public function save_jurnal_setoran_ayam(Request $r)
    {
        $id_akun = $r->id_akun;
        $id_akun2 = $r->id_akun2;
        $no_nota = $r->no_nota;
        $keterangan = $r->keterangan;
        $rupiah = $r->rupiah;
        $tgl = $r->tgl;
        
        if ($id_akun2 == '33') {
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
            $data_setor = [
                'tgl' => $tgl,
                'id_akun' => $id_akun2,
                'no_nota' => $no_nota,
                'nota_setor' => $no_nota,
                'kredit' => $rupiah,
                'admin' => Auth::user()->name,
            ];
            DB::table('setoran_ayam')->insert($data_setor);

            DB::table('setoran_ayam')->where('nota_setor', $no_nota)->update(['setuju' => 'Y']);
        } else {
            $data_setor = [
                'tgl' => $tgl,
                'id_akun' => $id_akun2,
                'no_nota' => $no_nota,
                'nota_setor' => $no_nota,
                'kredit' => $rupiah,
                'admin' => Auth::user()->name,
            ];
            DB::table('setoran_ayam')->insert($data_setor);

            DB::table('setoran_ayam')->where('nota_setor', $no_nota)->update(['setuju' => 'Y']);
        }
        return redirect()->route("setor_ayam")->with('sukses', 'Penyetoran berhasil disimpan');
    }

    public function data_invoice_setoran(Request $r)
    {
        $tgl1 =  $r->tgl1;
        $tgl2 =  $r->tgl2;

        $invoice = DB::select("SELECT a.nota_setor, a.no_nota, b.nm_akun, sum(a.debit) as debit, a.admin, a.setuju FROM setoran_telur as a 
        left join tb_akun as b on b.id_akun = a.id_akun
        where a.tgl between '$tgl1' and '$tgl2'
        group by a.nota_setor");
        $data = [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'invoice' => $invoice
        ];

        return view('setor_telur/data_invoice', $data);
    }

    public function detail_set_telur(Request $r)
    {
        $nota = $r->nota;

        $data = [
            'nota' => $nota,
            'no_nota' => DB::select("SELECT *
            FROM setoran_telur AS a
            left join tb_akun as b on b.id_akun = a.id_akun
            WHERE a.nota_setor = '$nota'")
        ];
        return view('setor_telur/detail_invoice', $data);
    }
}
