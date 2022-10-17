<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Penjualan_ayam extends Controller
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


        $data = [
            'title' => 'Penjualan Ayam',
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'invoice' => DB::table("invoice_ayam as a")->join('tb_post_center as b', 'a.id_post', 'b.id_post')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('penjualan_ayam/index', $data);
    }

    public function add_ayam(Request $r)
    {
        $data = [
            'title' => 'Penjualan Ayam',
            'costumer' => DB::table('tb_post_center')->where('id_akun', '18')->get(),
        ];

        return view('penjualan_ayam/add', $data);
    }

    public function save_ayam(Request $r)
    {
        $tgl = $r->tgl;
        $id_post = $r->id_post;
        $driver = $r->driver;

        $berat = $r->berat;
        $ekor = $r->ekor;
        $h_satuan = $r->h_satuan;

        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM invoice_ayam as a");
        $rutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM invoice_ayam as a where a.id_post = '$id_post'");
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

        $data = [
            'tgl' => $tgl,
            'id_post' => $id_post,
            'driver' => $driver,
            'no_nota' => $no_nota,
            'urutan' => $urutan,
            'berat' => $berat,
            'ekor' => $ekor,
            'harga' => $h_satuan,
            'ttl_harga' => $h_satuan * $ekor,
            'admin' => Auth::user()->name
        ];
        DB::table('invoice_ayam')->insert($data);
        return redirect()->route("nota_ayam", ['nota' => $no_nota])->with('sukses', 'Sukses');
    }

    public function nota_ayam(Request $r)
    {
        $data = [
            'title' => 'Nota Ayam',
            'nota' => DB::selectOne("SELECT a.tgl, a.id_post, a.no_nota, a.urutan, b.nm_post, a.driver,a.ekor, a.berat, a.harga, a.ttl_harga, a.admin
            FROM invoice_ayam as a 
            left join tb_post_center as b on b.id_post = a.id_post
            where a.no_nota = '$r->nota' 
            group by a.no_nota"),
            'akun' => DB::table('tb_akun')->where('id_akun', '52')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()
        ];

        return view('penjualan_ayam/nota', $data);
    }

    public function save_jurnal(Request $r)
    {
        $id_akun = $r->id_akun;
        $total = $r->total;
        $no_nota = $r->no_nota;
        $tgl = $r->tgl;
        $id_post = $r->id_post;

        if ($id_akun == '52') {
            $data_kredit = [
                'tgl' => $tgl,
                'no_nota' => 'A-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => '19',
                'ket' => 'Piutang ayam',
                'kredit' => $total,
                'id_post' => $id_post,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_kredit);
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'A-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun,
                'ket' => 'Piutang ayam',
                'debit' => $total,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);
        } else {
            $data_kredit = [
                'tgl' => $tgl,
                'no_nota' => 'A-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => '19',
                'ket' => 'Penjualan ayam',
                'kredit' => $total,
                'id_post' => $id_post,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_kredit);
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'A-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun,
                'ket' => 'Penjualan ayam',
                'debit' => $total,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);

            DB::table('invoice_ayam')->where('no_nota', $no_nota)->update(['lunas' => 'Y']);
        }
        return redirect()->route("pen_ayam")->with('sukses', 'Sukses');
    }
}
