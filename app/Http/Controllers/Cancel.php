<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cancel extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Cancel Jurnal',
            'tgl' => DB::select("SELECT a.id_jurnal, MONTH(a.tgl) AS bulan, Year(tgl) AS tahun, a.id_buku
            FROM tb_jurnal AS a
            WHERE a.id_buku IN ('7','4','5')
            GROUP BY a.tgl  
            ORDER BY a.tgl ASC")
        ];

        return view('cancel.index', $data);
    }

    public function save_cancel(Request $r)
    {
        $month_penyesuaian = $r->month_penyesuaian;
        $year_penyesuaian = $r->year_penyesuaian;
        $month_penutup = $r->month_penutup;
        $year_penutup = $r->year_penutup;

        $last_month_penyesuaian = $r->last_month_penyesuaian;
        $last_year_penyesuaian = $r->last_year_penyesuaian;

        if (empty($month_penyesuaian)) {
            # code...
        } else {
            $tgl1_penyesuaian = date('Y-m-01', strtotime($year_penyesuaian . '-' . $month_penyesuaian . '-' . 01));
            $tgl2_penyesuaian = date('Y-m-t', strtotime($last_year_penyesuaian . '-' . $last_month_penyesuaian . '-' . 01));

            DB::table('tb_jurnal')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->update(['penyesuaian' => 'T', 'penutup' => 'T']);

            DB::table('tb_jurnal')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->whereIn('id_buku', ['4', '5', '7'])->delete();

            DB::table('tb_neraca_asset_umum')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->delete();
            DB::table('tb_neraca_asset_pv')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->delete();
            DB::table('tb_neraca_saldo')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->delete();
            DB::table('tb_saldo_tetap')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->delete();

            DB::table('tb_asset_umum')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->where('penyesuaian', 'Y')->delete();
            DB::table('tb_asset_pv')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->where('penyesuaian', 'Y')->delete();

            DB::table('aktiva')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->where('debit_aktiva', '0')->delete();
            DB::table('table_atk')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->where('qty_debit', '0')->delete();

            DB::table('tb_asset_umum')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->where('penyesuaian', 'T')->update(['disesuaikan' => 'T']);
            DB::table('tb_asset_pv')->whereBetween('tgl', [$tgl1_penyesuaian, $tgl2_penyesuaian])->where('penyesuaian', 'T')->update(['disesuaikan' => 'T']);
        }

        if (empty($month_penutup)) {
            # code...
        } else {
            $tgl1_penutup = date('Y-m-01', strtotime($year_penutup . '-' . $month_penutup . '-' . 01));
            $tgl2_penutup = date('Y-m-t', strtotime($last_year_penyesuaian . '-' . $last_month_penyesuaian . '-' . 01));

            DB::table('tb_jurnal')->whereBetween('tgl', [$tgl1_penutup, $tgl2_penutup])->update(['penutup' => 'T']);
            DB::table('tb_jurnal')->whereBetween('tgl', [$tgl1_penutup, $tgl2_penutup])->where('id_buku', '7')->delete();
            DB::table('tb_neraca_saldo')->whereBetween('tgl', [$tgl1_penutup, $tgl2_penutup])->delete();
            DB::table('tb_saldo_tetap')->whereBetween('tgl', [$tgl1_penutup, $tgl2_penutup])->delete();
        }

        return redirect()->route("cancel_jurnal")->with('sukses', 'Data berhasil di input');
    }
}
