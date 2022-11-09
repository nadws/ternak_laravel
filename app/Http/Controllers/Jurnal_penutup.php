<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Jurnal_penutup extends Controller
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
        $jurnal = DB::select("SELECT * FROM tb_jurnal as a left join tb_akun as b on a.id_akun = b.id_akun where a.id_buku = '7' and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");
        $data = [
            'title' => 'Jurnal Penutup',
            'akun' => DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->get(),
            'jurnal' => $jurnal,
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where a.id_buku = '7' and a.tgl between '$tgl1' and '$tgl2' "),
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];
        return view('jurnal_penutup/index', $data);
    }

    public function isi_penutup(Request $r)
    {
        $tgl_penjualan = DB::selectOne("SELECT a.no_nota, min(a.tgl) AS tanggal, b.nm_akun, a.debit, a.kredit
        FROM tb_jurnal AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        WHERE a.penutup = 'T' and a.id_buku in('1','3','4','5') and b.id_kategori in('4','5')
        GROUP BY b.id_kategori");


        if (empty($tgl_penjualan->tanggal)) {
            $tgl1 =  '0';
            $tgl2 =  '0';
        } else {
            $tgl1 =  date('Y-m-01', strtotime($tgl_penjualan->tanggal));
            $tgl2 =  date('Y-m-t', strtotime($tgl_penjualan->tanggal));
        }






        $data = [
            'akun_penjualan' => DB::select("SELECT a.id_akun,b.nm_akun,  SUM(a.debit) AS debit, SUM(a.kredit) AS kredit
            FROM tb_jurnal AS a
            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS c ON c.id_akun = a.id_akun
            WHERE b.id_kategori = '4' AND a.penutup = 'T' AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
            GROUP BY a.id_akun"),

            'akun_biaya' => DB::select("SELECT a.id_akun,b.nm_akun,  SUM(a.debit) AS debit, SUM(a.kredit) AS kredit
            FROM tb_jurnal AS a
            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS c ON c.id_akun = a.id_akun
            WHERE b.id_kategori = '5' AND a.penutup = 'T' AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
            GROUP BY a.id_akun"),

            'tgl1' => $tgl1,
            'tgl2' => $tgl2


        ];
        return view('jurnal_penutup/isi_penutup', $data);
    }

    public function save_penutup(Request $r)
    {
        $tgl_pendapatan = $r->tgl_pendapatan;
        $id_akun_debit_penjualan = $r->id_akun_debit_penjualan;
        $debit_penjualan = $r->debit_penjualan;
        $id_akun_kredit_penjualan = $r->id_akun_kredit_penjualan;
        $kredit_penjualan = $r->kredit_penjualan;



        if (empty($id_akun_debit_penjualan)) {
            # code...
        } else {
            for ($x = 0; $x < count($id_akun_debit_penjualan); $x++) {
                $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '7'");
                if (empty($urutan->urutan)) {
                    $no_urutan = '1001';
                } else {
                    $no_urutan = $urutan->urutan + 1;
                }
                $akun = DB::table('tb_akun')->where('id_akun', $id_akun_debit_penjualan[$x])->first();
                $data = [
                    'id_akun' => $id_akun_kredit_penjualan[$x],
                    'id_buku' => '7',
                    'urutan' => $no_urutan,
                    'no_nota' => 'PEN-' . $no_urutan,
                    'tgl' => $tgl_pendapatan[$x],
                    'ket' => 'Penutup' . ' ' . $akun->nm_akun,
                    'kredit' => $kredit_penjualan[$x],
                    'admin' => Auth::user()->name
                ];
                DB::table('tb_jurnal')->insert($data);
                $data = [
                    'id_akun' => $id_akun_debit_penjualan[$x],
                    'id_buku' => '7',
                    'urutan' => $no_urutan,
                    'no_nota' => 'PEN-' . $no_urutan,
                    'tgl' => $tgl_pendapatan[$x],
                    'ket' => 'Ikhtisar laba rugi',
                    'debit' => $debit_penjualan[$x],
                    'admin' => Auth::user()->name
                ];
                DB::table('tb_jurnal')->insert($data);
            }
        }



        $tgl_biaya = $r->tgl_biaya;
        $id_akun_debit_biaya = $r->id_akun_debit_biaya;
        $debit_biaya = $r->debit_biaya;
        $id_akun_kredit_biaya = $r->id_akun_kredit_biaya;
        $kredit_biaya = $r->kredit_biaya;

        if (empty($id_akun_debit_biaya)) {
            # code...
        } else {
            for ($x = 0; $x < count($id_akun_debit_biaya); $x++) {
                $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '7'");
                if (empty($urutan->urutan)) {
                    $no_urutan = '1001';
                } else {
                    $no_urutan = $urutan->urutan + 1;
                }
                $akun = DB::table('tb_akun')->where('id_akun', $id_akun_debit_biaya[$x])->first();
                $data = [
                    'id_akun' => $id_akun_kredit_biaya[$x],
                    'id_buku' => '7',
                    'urutan' => $no_urutan,
                    'no_nota' => 'PEN-' . $no_urutan,
                    'tgl' => $tgl_biaya[$x],
                    'ket' => 'Ikhtisar laba rugi',
                    'kredit' => $kredit_biaya[$x],
                    'admin' => Auth::user()->name
                ];
                DB::table('tb_jurnal')->insert($data);
                $data = [
                    'id_akun' => $id_akun_debit_biaya[$x],
                    'id_buku' => '7',
                    'urutan' => $no_urutan,
                    'no_nota' => 'PEN-' . $no_urutan,
                    'tgl' => $tgl_biaya[$x],
                    'ket' => 'Penutup' . ' ' . $akun->nm_akun,
                    'debit' => $debit_biaya[$x],
                    'admin' => Auth::user()->name
                ];
                DB::table('tb_jurnal')->insert($data);


                $akun_id = $id_akun_kredit_biaya[$x];
                $month = date('m', strtotime($tgl_biaya[$x]));
                $year = date('Y', strtotime($tgl_biaya[$x]));

                $jurnal = DB::selectOne("SELECT a.no_nota FROM tb_jurnal as a where a.id_akun = '$akun_id' and MONTH(a.tgl) = '$month' and YEAR(a.tgl) = '$year'");
                DB::table('tb_jurnal')->where('no_nota', $jurnal->no_nota)->update(['penutup' => 'Y']);
            }
        }




        $tgl_modal = $r->tgl_modal;
        $id_akun_debit_modal = $r->id_akun_debit_modal;
        $debit_modal = $r->debit_modal;
        $id_akun_kredit_modal = $r->id_akun_kredit_modal;
        $kredit_modal = $r->kredit_modal;

        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '7'");
        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }
        $akun = DB::table('tb_akun')->where('id_akun', $id_akun_debit_modal)->first();

        if ($debit_modal == 0) {
            # code...
        } else {
            $data = [
                'id_akun' => $id_akun_kredit_modal,
                'id_buku' => '7',
                'urutan' => $no_urutan,
                'no_nota' => 'PEN-' . $no_urutan,
                'tgl' => $tgl_modal,
                'ket' => 'Penutup' . ' ' . $akun->nm_akun,
                'kredit' => $kredit_modal,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
            $data = [
                'id_akun' => $id_akun_debit_modal,
                'id_buku' => '7',
                'urutan' => $no_urutan,
                'no_nota' => 'PEN-' . $no_urutan,
                'tgl' => $tgl_modal,
                'ket' => 'Penutup' . ' ' . $akun->nm_akun,
                'debit' => $debit_modal,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
        }



        $tgl_prive = $r->tgl_prive;
        $id_akun_debit_prive = $r->id_akun_debit_prive;
        $debit_prive = $r->debit_prive;
        $id_akun_kredit_prive = $r->id_akun_kredit_prive;
        $kredit_prive = $r->kredit_prive;


        if (empty($debit_prive)) {
            # code...
        } else {
            $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '7'");
            if (empty($urutan->urutan)) {
                $no_urutan = '1001';
            } else {
                $no_urutan = $urutan->urutan + 1;
            }
            $akun = DB::table('tb_akun')->where('id_akun', $id_akun_debit_prive)->first();

            $data = [
                'id_akun' => $id_akun_kredit_prive,
                'id_buku' => '7',
                'urutan' => $no_urutan,
                'no_nota' => 'PEN-' . $no_urutan,
                'tgl' => $tgl_prive,
                'ket' => 'Penutup' . ' ' . $akun->nm_akun,
                'kredit' => $kredit_prive,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
            $data = [
                'id_akun' => $id_akun_debit_prive,
                'id_buku' => '7',
                'urutan' => $no_urutan,
                'no_nota' => 'PEN-' . $no_urutan,
                'tgl' => $tgl_prive,
                'ket' => 'Penutup' . ' ' . $akun->nm_akun,
                'debit' => $debit_prive,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
        }

        $tgl1 = date('Y-m-01', strtotime($tgl_prive));
        $bulan_sebelum = date('Y-m-d', strtotime('last day of -1 month', strtotime($tgl_prive)));

        if ($debit_modal == 0) {
            return redirect()->route("j_penutup")->with('eror', 'Data gagal di input');
        } else {

            $neraca = DB::selectOne("SELECT a.id_neraca_saldo FROM tb_neraca_saldo as a");

            if (empty($neraca)) {
                $buku = DB::select("SELECT b.id_akun, b.no_akun, b.nm_akun, sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.tgl between '2022-01-01' and '$tgl_prive' group by a.id_akun order by b.no_akun ASC");
            } else {
                $buku = DB::select("SELECT a.no_nota, a.id_akun, SUM(a.debit) AS debit, SUM(a.kredit) AS kredit, b.debit_saldo, b.kredit_saldo
               FROM tb_jurnal AS a
               LEFT JOIN (
               SELECT b.id_akun, SUM(b.debit_saldo) AS debit_saldo, SUM(b.kredit_saldo) AS kredit_saldo
               FROM tb_neraca_saldo AS b 
               WHERE b.tgl = '$bulan_sebelum'
               GROUP BY b.id_akun
               ) AS b ON b.id_akun = a.id_akun
               WHERE a.tgl BETWEEN '$tgl1' AND '$tgl_prive' 
               GROUP BY a.id_akun");
            }

            $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_neraca_saldo as a");
            if (empty($urutan->urutan)) {
                $no_urutan = '1001';
            } else {
                $no_urutan = $urutan->urutan + 1;
            }



            if (empty($neraca)) {
                foreach ($buku as $b) {
                    $data = [
                        'no_nota' => 'SP' . $no_urutan,
                        'tgl' => $tgl_prive,
                        'debit_saldo' => $b->debit,
                        'kredit_saldo' => $b->kredit,
                        'id_akun' => $b->id_akun,
                        'penutup' => 'Y',
                        'urutan' => $no_urutan
                    ];
                    DB::table('tb_neraca_saldo')->insert($data);
                }
            } else {
                foreach ($buku as $b) {
                    $data = [
                        'no_nota' => 'SP' . $no_urutan,
                        'tgl' => $tgl_prive,
                        'debit_saldo' => $b->debit + $b->debit_saldo,
                        'kredit_saldo' => $b->kredit + $b->kredit_saldo,
                        'id_akun' => $b->id_akun,
                        'penutup' => 'Y',
                        'urutan' => $no_urutan
                    ];
                    DB::table('tb_neraca_saldo')->insert($data);
                }
            }

            $saldo = DB::select("SELECT a.id_akun, SUM(a.debit) AS debit , SUM(a.kredit) AS kredit
            FROM tb_jurnal AS a
            WHERE a.tgl BETWEEN '$tgl1' AND '$tgl_prive'
            GROUP BY a.id_akun");

            $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_saldo_tetap as a");
            if (empty($urutan->urutan)) {
                $no_urutan = '1001';
            } else {
                $no_urutan = $urutan->urutan + 1;
            }
            foreach ($saldo as $s) {
                $data = [
                    'no_nota' => 'SP' . $no_urutan,
                    'tgl' => $tgl_prive,
                    'debit_saldo' => $s->debit,
                    'kredit_saldo' => $s->kredit,
                    'id_akun' => $s->id_akun,
                    'penutup' => 'Y',
                    'urutan' => $no_urutan
                ];
                DB::table('tb_saldo_tetap')->insert($data);
            }

            DB::table('tb_jurnal')->whereBetween('tgl', [$tgl1, $tgl_prive])->update(['penutup' => 'Y']);

            return redirect()->route("j_penutup", ['tgl1' => $tgl1, 'tgl2' => $tgl_prive])->with('sukses', 'Data berhasil di input');
        }
    }
}
