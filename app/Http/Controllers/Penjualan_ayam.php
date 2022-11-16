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
        $invoice = DB::select("SELECT a.*,b.nm_post FROM invoice_ayam as a 
        left join tb_post_center as b on b.id_post = a.id_post
        where a.tgl between '$tgl1' and '$tgl2'
        group by a.no_nota
        order by a.no_nota DESC
         ");


        $data = [
            'title' => 'Penjualan Ayam',
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'invoice' => $invoice,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('penjualan_ayam.index', $data);
    }

    public function add_ayam(Request $r)
    {
        $data = [
            'title' => 'Penjualan Ayam',
            'costumer' => DB::table('tb_post_center')->where('id_akun', '19')->get(),
        ];

        return view('penjualan_ayam.add', $data);
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
            'admin' => Auth::user()->name,
            'lunas' => 'Y'
        ];
        DB::table('invoice_ayam')->insert($data);
        return redirect()->route("nota_ayam", ['nota' => $no_nota])->with('sukses', 'Data berhasil di input');
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
        $debit = $r->debit;


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

        for ($x = 0; $x < count($id_akun); $x++) {
            $id_akun2 = $id_akun[$x];
            $akun = DB::table('tb_akun')->where('id_akun', $id_akun2)->first();
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'A-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun[$x],
                'ket' => 'Penjualan ayam',
                'debit' => $debit[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);

            if ($akun->id_akun == '52') {
                DB::table('invoice_ayam')->where('no_nota', $no_nota)->update(['lunas' => 'T']);
            } else {
            }
        }

        return redirect()->route("pen_ayam")->with('sukses', 'Data berhasil di input');
    }
    public function tambah_pembayaran_ayam(Request $r)
    {
        $data = [
            'count' => $r->count,
            'akun' => DB::table('tb_akun')->where('id_akun', '52')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()
        ];
        return view('penjualan/tambah', $data);
    }

    public function export_invoice_ayam(Request $r)
    {
        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }
        $data = [
            'ayam' => DB::select("SELECT a.tgl, b.nm_post, a.urutan, 
            b.no_telpon, b.npwp, a.no_nota, 
            a.ekor, a.berat, a.harga, a.ttl_harga, c.nm_akun, e.tgl AS tgl_setor, e.nota_setor
            FROM invoice_ayam AS a
            LEFT JOIN tb_post_center AS b ON b.id_post = a.id_post
            LEFT JOIN (
            SELECT c.no_nota, d.nm_akun, c.debit
            FROM tb_jurnal AS c
            LEFT JOIN tb_akun AS d ON d.id_akun = c.id_akun
            WHERE c.kredit = 0 AND c.id_buku = '1' AND d.id_kategori = '1'
            ) AS c ON c.no_nota  = concat('A-', a.no_nota)
            
            LEFT JOIN setoran_ayam AS e ON e.no_nota = concat('A-', a.no_nota)
            WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
            GROUP BY a.no_nota")
        ];

        return view('penjualan_ayam.export_invoice', $data);
    }
}
