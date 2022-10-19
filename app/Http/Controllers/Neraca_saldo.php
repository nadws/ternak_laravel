<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Neraca_saldo extends Controller
{
    public function index(Request $r)
    {

        if (empty($r->month)) {
            $month = date('m');
            $year = date('Y');
        } else {
            $month = $r->month;
            $year = $r->year;
        }
        $data = [
            'title' => 'Neraca Saldo',
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'bulan' => $month,
            'tahun' => $year,
            's_tahun' => DB::select("SELECT a.tgl FROM tb_jurnal as a where a.id_buku = '6' group by YEAR(a.tgl)"),
            'saldo' => DB::select("SELECT a.*,b.nm_akun FROM tb_jurnal as a
            left join tb_akun as b on b.id_akun = a.id_akun where month(a.tgl) ='$month'
            and
            YEAR(a.tgl) ='$year'and a.id_buku = '6'
            "),
            'saldo2' => DB::select("SELECT * From tb_akun as a order by a.no_akun ASC")
        ];

        return view('Saldo/index', $data);
    }

    public function save_saldo(Request $r)
    {
        $id_akun = $r->id_akun;
        $tgl = $r->tgl;
        $debit = $r->debit;
        $kredit = $r->kredit;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '6'");
        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }
        for ($x = 0; $x < count($id_akun); $x++) {

            $data = [
                'id_akun' => $id_akun[$x],
                'tgl' => $tgl,
                'debit' => $debit[$x],
                'kredit' => $kredit[$x],
                'no_nota' => "SLD-$no_urutan",
                'urutan' => $no_urutan,
                'id_buku' => '6',
                'ket' => "Saldo Awal $tgl"
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        return redirect()->route("saldo")->with('sukses', 'Sukses');
    }

    public function get_penutup(Request $r)
    {
        $bulan = $r->bulan;
        $tahun = $r->tahun;

        $penutup = DB::select("SELECT MONTH(a.tgl) AS bulan, YEAR(a.tgl) AS tahun
        FROM tb_jurnal AS a
        WHERE  MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$tahun' and id_buku ='6'
        GROUP BY MONTH(a.tgl) , YEAR(a.tgl) ");

        if (empty($penutup)) {
            echo "";
        } else {
            echo "Neraca saldo sudah ada pada  $bulan - $tahun";
        }
    }

    public function edit_saldo(Request $r)
    {
        $id_jurnal = $r->id_jurnal;

        $debit = $r->debit;
        $kredit = $r->kredit;

        for ($x = 0; $x < count($id_jurnal); $x++) {

            $data = [
                'debit' => $debit[$x],
                'kredit' => $kredit[$x],
            ];
            DB::table('tb_jurnal')->where('id_jurnal', $id_jurnal[$x])->update($data);
        }
        return redirect()->route("saldo", ['month' => $r->bulan, 'year' => $r->tahun])->with('sukses', 'Sukses');
    }

    public function delete_saldo(Request $r)
    {
        DB::table('tb_jurnal')->whereMonth('tgl', $r->month)->whereYear('tgl', $r->year)->where('id_buku', '6')->delete();
        return redirect()->route("saldo", ['month' => $r->month, 'year' => $r->year])->with('sukses', 'Sukses');
    }
}
