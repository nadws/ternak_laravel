<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Penjualan_kardus extends Controller
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
        $invoice = DB::select("SELECT a.*,b.nm_post FROM invoice_kardus as a 
        left join tb_post_center as b on b.id_post = a.id_post
        where a.tgl between '$tgl1' and '$tgl2'
        group by a.no_nota
        order by a.no_nota DESC
         ");

        $data = [
            'title' => 'Penjualan Kardus',
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'invoice' => $invoice,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('penjualan_kardus/index', $data);
    }

    public function add_kardus(Request $r)
    {
        $data = [
            'title' => 'Penjualan Kardus',
            'costumer' => DB::table('tb_post_center')->where('id_akun', '18')->get(),
        ];

        return view('penjualan_kardus/add', $data);
    }
    public function save_kardus(Request $r)
    {
        $tgl = $r->tgl;
        $id_post = $r->id_post;

        $berat = $r->berat;
        $type = $r->type;
        $h_satuan = $r->h_satuan;
        $total = $r->total;



        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM invoice_kardus as a");
        $rutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM invoice_kardus as a where a.id_post = '$id_post'");
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
            'berat' => $berat,
            'type' => $type,
            'h_satuan' => $h_satuan,
            'total' => $total,
            'admin' => Auth::user()->name
        ];
        DB::table('invoice_kardus')->insert($data);
        return redirect()->route("nota_kardus", ['nota' => $no_nota])->with('sukses', 'Sukses');
    }

    public function nota_kardus(Request $r)
    {
        $data = [
            'title' => 'Nota Kardus',
            'nota' => DB::selectOne("SELECT a.tgl, a.id_post, a.no_nota, a.urutan, b.nm_post, a.admin, a.berat, a.type, a.h_satuan,a.total, c.nm_type
            FROM invoice_kardus as a 
            left join tb_post_center as b on b.id_post = a.id_post
            left join type_kardus as c on c.id_type_kardus = a.type
            where a.no_nota = '$r->nota' 
            group by a.no_nota"),
            'akun' => DB::table('tb_akun')->where('id_akun', '54')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()
        ];

        return view('penjualan_kardus/nota', $data);
    }

    public function save_jurnal_kardus(Request $r)
    {
        $id_akun = $r->id_akun;
        $total = $r->total;
        $no_nota = $r->no_nota;
        $tgl = $r->tgl;
        $id_post = $r->id_post;

        if ($id_akun == '54') {
            $data_kredit = [
                'tgl' => $tgl,
                'no_nota' => 'K-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => '21',
                'ket' => 'Piutang Kardus',
                'kredit' => $total,
                'id_post' => $id_post,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_kredit);
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'K-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun,
                'ket' => 'Piutang Kardus',
                'debit' => $total,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);
        } else {
            $data_kredit = [
                'tgl' => $tgl,
                'no_nota' => 'K-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => '21',
                'ket' => 'Penjualan Kardus',
                'kredit' => $total,
                'id_post' => $id_post,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_kredit);
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'K-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun,
                'ket' => 'Penjualan Kardus',
                'debit' => $total,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);

            DB::table('invoice_kardus')->where('no_nota', $no_nota)->update(['lunas' => 'Y']);
        }
        return redirect()->route("pen_kardus")->with('sukses', 'Sukses');
    }
}
