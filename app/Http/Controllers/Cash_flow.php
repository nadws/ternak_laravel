<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cash_flow extends Controller
{
    public function index(Request $r)
    {
        if (empty($r->bulan1)) {
            $tgl_awal = date('Y-m-01');
            $tgl_akhir = date('Y-m-t');
            $tgl_awal2 = date('Y-m-01', strtotime('-1 month', strtotime($tgl_akhir)));
            $tgl_akhir2 = date('Y-m-t', strtotime('-1 month', strtotime($tgl_akhir)));
            $bulan1 = date('m');
            $tahun1 = date('Y');
            $bulan2 = date('m');
            $tahun2 = date('Y');
        } else {
            $bulan1 = $r->bulan1;
            $tahun1 = $r->tahun1;
            $bulan2 = $r->bulan2;
            $tahun2 = $r->tahun2;
            $h1 = date('t');
            $tgl_akhir2 = $tahun2 . '-' . $bulan2 . '-' . $h1;
            $tgl_awal2 =  $tahun1 . '-' . $bulan1 . '-' . 01;
            $tgl_awal = date('Y-m-01', strtotime('-1 month', strtotime($tgl_akhir2)));
            $tgl_akhir = date('Y-m-t', strtotime('-1 month', strtotime($tgl_akhir2)));
        }

        $tahun = DB::select("SELECT a.tgl
        FROM tb_jurnal AS a
        WHERE a.tgl BETWEEN '$tgl_awal' and '$tgl_akhir'
        GROUP BY MONTH(a.tgl) , YEAR(a.tgl)
        ORDER BY a.tgl ASC");

        $tahun2 = DB::select("SELECT a.tgl
        FROM tb_jurnal AS a
        WHERE a.tgl BETWEEN '$tgl_awal2' and '$tgl_akhir2'
        GROUP BY MONTH(a.tgl) , YEAR(a.tgl)
        ORDER BY a.tgl ASC");

        $data = [
            'title' => 'Cash Flow',
            'akun_pendapatan' => DB::table('tb_akun')->where('id_kategori', 4)->get(),

            'uang_keluar' => DB::select("SELECT a.id_akun, b.nm_akun
            FROM tb_jurnal AS a
            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
            LEFT JOIN tb_akun AS c ON c.id_akun = a.id_akun_kredit
            WHERE a.id_buku = '3' AND c.id_kategori = '1' AND c.id_penyesuaian = '0'
            GROUP BY a.id_akun"),

            'liabilities' => DB::select("SELECT a.id_akun, b.nm_akun, SUM(a.debit) AS debit, SUM(a.kredit) AS kredit
            FROM tb_jurnal AS a
            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
            WHERE b.id_kategori ='1' AND b.id_penyesuaian = '0' AND a.id_buku = '3' 
            GROUP BY a.id_akun"),


            'tahun' => $tahun,
            's_bulan' => DB::table('bulan')->get(),
            's_tahun' => DB::select("SELECT a.tgl FROM tb_jurnal as a group by YEAR(a.tgl)"),
            'bulan1' => $bulan1,
            'bulan2' => $bulan2,
            'tahun1' => $tahun1,
            'tahun2' => $tahun2,
        ];

        return view('cashflow.index', $data);
    }
}
