<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    public function index(Request $r)
    {
        if (empty($r->bulan1)) {
            $tgl_akhir = date('Y-m-d');
            $tgl_awal = date('Y-m-d', strtotime('-4 month', strtotime($tgl_akhir)));
        } else {
            $bulan1 = $r->bulan1;
            $tahun1 = $r->tahun1;
            $bulan2 = $r->bulan2;
            $tahun2 = $r->tahun2;
            $h1 = date('t');


            $tgl_akhir = $tahun2 . '-' . $bulan2 . '-' . $h1;
            $tgl_awal =  $tahun1 . '-' . $bulan1 . '-' . 01;
        }

        $tahun = DB::select("SELECT a.tgl
        FROM tb_jurnal AS a
        WHERE a.tgl BETWEEN '$tgl_awal' and '$tgl_akhir'
        GROUP BY MONTH(a.tgl) , YEAR(a.tgl)
        ORDER BY a.tgl ASC");

        $data = [
            'title' => 'Laporan Bulanan',
            'akun_pendapatan' => DB::table('tb_akun')->where('id_kategori', 4)->get(),
            'akun_biaya_disesuaiakan' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun, b.id_relation_debit
            FROM tb_akun AS a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            WHERE b.id_relation_debit IS NOT null"),

            'akun_biaya' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun, b.id_relation_debit
            FROM tb_akun AS a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            WHERE b.id_relation_debit IS NULL AND a.id_kategori='5'"),

            'asset' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun
            FROM tb_akun AS a
            WHERE  a.id_kategori='1' and a.id_penyesuaian != 0"),

            'tahun' => $tahun,
            's_bulan' => DB::table('bulan')->get(),
            's_tahun' => DB::select("SELECT a.tgl FROM tb_jurnal as a group by YEAR(a.tgl)"),
        ];

        return view('home.index', $data);
    }

    public function view_jurnal_laporan_bulanan(Request $r)
    {
        $id_akun = $r->id_akun;
        $bulan = $r->bulan;
        $tahun = $r->tahun;

        $jurnal = DB::select("SELECT a.id_buku, a.tgl,a.no_nota, b.nm_akun, a.debit, a.kredit, a.ket, c.nm_post
        FROM tb_jurnal AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        left join tb_post_center as c on c.id_post = a.id_post
        
        WHERE a.id_buku not in('7','6') and a.id_akun = '$id_akun' AND MONTH(a.tgl) = '$bulan' AND YEAR(a.tgl) = '$tahun'
        order by a.tgl ASC");

        $data = [
            'jurnal' => $jurnal,
            'akun' => DB::table('tb_akun')->where('id_akun', $id_akun)->first(),
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        return view('home.view', $data);
    }
}
