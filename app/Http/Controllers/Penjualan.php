<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Penjualan extends Controller
{

    public function index(Request $r)
    {
        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $invoice = DB::select("SELECT a.no_nota, a.tgl, b.nm_post, a.urutan, sum(a.rp_kg) as ttl_rp FROM invoice_telur as a 
        left join tb_post_center as b on b.id_post = a.id_post
        where a.tgl between '$tgl1' and '$tgl2'
        group by a.no_nota
         ");
        $data = [
            'title' => 'Penjualan Telur',
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'invoice' => $invoice,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('penjualan/index', $data);
    }
    public function add(Request $r)
    {

        $data = [
            'title' => 'Add Penjualan Telur',
            'costumer' => DB::table('tb_post_center')->where('id_akun', '18')->get(),
            'jenis' => DB::table('tb_jenis_telur')->get(),
        ];

        return view('penjualan/add', $data);
    }

    public function save_kg(Request $r)
    {
        $tgl = $r->tgl;
        $id_post = $r->id_post;
        $driver = $r->driver;

        $pcs = $r->pcs;
        $kg = $r->kg;
        $kg_jual = $r->kg_jual;
        $rupiah = $r->rupiah;
        $rp_kg = $r->rp_kg;
        $id_jenis_telur = $r->id_jenis_telur;

        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM invoice_telur as a");
        $rutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM invoice_telur as a where a.id_post = '$id_post'");
        if (empty($nota->nota)) {
            $no_nota = '1001';
        } else {
            $no_nota = $nota->nota + 1;
        }
        if (empty($rutan->urutan)) {
            $urutan = '1';
        } else {
            $urutan = $rutan->urutan + 1;
        }

        for ($x = 0; $x < count($pcs); $x++) {
            if ($pcs[$x] == 0) {
                # code...
            } else {
                $data = [
                    'tgl' => $tgl,
                    'id_post' => $id_post,
                    'driver' => $driver,
                    'no_nota' => $no_nota,
                    'pcs' => $pcs[$x],
                    'kg' => $kg[$x],
                    'kg_jual' => $kg_jual[$x],
                    'rupiah' => $rupiah[$x],
                    'rp_kg' => $rp_kg[$x],
                    'urutan' => $urutan,
                    'id_jenis_telur' => $id_jenis_telur[$x],
                    'jenis_penjualan' => 'kg',
                ];
                DB::table('invoice_telur')->insert($data);
            }
        }
    }
}
