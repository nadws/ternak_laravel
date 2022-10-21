<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Penjualan_pupuk extends Controller
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
        $invoice = DB::select("SELECT a.*,b.nm_post FROM invoice_pupuk as a 
        left join tb_post_center as b on b.id_post = a.id_post
        where a.tgl between '$tgl1' and '$tgl2'
        group by a.no_nota
        order by a.no_nota DESC
         ");


        $data = [
            'title' => 'Penjualan Pupuk',
            'invoice' => $invoice,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('penjualan_pupuk/index', $data);
    }
    public function add_pupuk(Request $r)
    {
        $data = [
            'title' => 'Penjualan Pupuk',
            'costumer' => DB::table('tb_post_center')->where('id_akun', '18')->get(),
        ];

        return view('penjualan_pupuk/add', $data);
    }

    public function save_pupuk(Request $r)
    {
        $tgl = $r->tgl;
        $id_post = $r->id_post;
        $driver = $r->driver;

        $full = $r->full;
        $h_full = $r->h_full;
        $setengah = $r->setengah;
        $h_setengah = $r->h_setengah;
        $ttl = $r->ttl;

        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM invoice_pupuk as a");
        $rutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM invoice_pupuk as a where a.id_post = '$id_post'");
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
            'no_nota' => $no_nota,
            'urutan' => $urutan,
            'full' => $full,
            'h_full' => $h_full,
            'setengah' => $setengah,
            'h_setengah' => $h_setengah,
            'ttl_harga' => $ttl,
            'admin' => Auth::user()->name,
            'lunas' => 'Y'
        ];
        DB::table('invoice_pupuk')->insert($data);
        return redirect()->route("nota_pupuk", ['nota' => $no_nota])->with('sukses', 'Data berhasil di input');
    }

    public function nota_pupuk(Request $r)
    {
        $data = [
            'title' => 'Nota Pupuk',
            'nota' => DB::selectOne("SELECT a.tgl, a.id_post, a.no_nota, a.urutan, b.nm_post,a.full, a.h_full, a.setengah,a.h_setengah, a.admin, a.ttl_harga
            FROM invoice_pupuk as a 
            left join tb_post_center as b on b.id_post = a.id_post
            where a.no_nota = '$r->nota' 
            group by a.no_nota"),
            'akun' => DB::table('tb_akun')->where('id_akun', '53')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()
        ];

        return view('penjualan_pupuk/nota', $data);
    }

    public function save_jurnal_pupuk(Request $r)
    {
        $id_akun = $r->id_akun;
        $total = $r->total;
        $no_nota = $r->no_nota;
        $tgl = $r->tgl;
        $id_post = $r->id_post;
        $debit = $r->debit;


        $data_kredit = [
            'tgl' => $tgl,
            'no_nota' => 'P-' . $no_nota,
            'id_buku' => '1',
            'id_akun' => '20',
            'ket' => 'Penjualan Pupuk',
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
                'no_nota' => 'P-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun[$x],
                'ket' => 'Penjualan Pupuk',
                'debit' => $debit[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);

            if ($akun->id_akun == '53') {
                DB::table('invoice_pupuk')->where('no_nota', $no_nota)->update(['lunas' => 'T']);
            } else {
            }
        }


        return redirect()->route("pen_pupuk")->with('sukses', 'Data berhasil di input');
    }

    public function tambah_pembayaran_pupuk(Request $r)
    {
        $data = [
            'count' => $r->count,
            'akun' => DB::table('tb_akun')->where('id_akun', '53')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()
        ];
        return view('penjualan/tambah', $data);
    }
}
