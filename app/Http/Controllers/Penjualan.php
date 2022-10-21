<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $invoice = DB::select("SELECT a.no_nota, a.lunas, a.tgl, a.jenis_penjualan, b.nm_post, a.urutan, sum(a.rp_kg) as ttl_rp FROM invoice_telur as a 
        left join tb_post_center as b on b.id_post = a.id_post
        where a.tgl between '$tgl1' and '$tgl2'
        group by a.no_nota
        order by a.no_nota DESC
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
                'lunas' => 'Y'
            ];
            DB::table('invoice_telur')->insert($data);
        }
        return redirect()->route("nota", ['nota' => $no_nota])->with('sukses', 'Sukses');
    }
    public function save_pcs(Request $r)
    {
        $tgl = $r->tgl;
        $id_post = $r->id_post;
        $driver = $r->driver;

        $pcs = $r->pcs;
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
            $data = [
                'tgl' => $tgl,
                'id_post' => $id_post,
                'driver' => $driver,
                'no_nota' => $no_nota,
                'pcs' => $pcs[$x],
                'kg_jual' => $kg_jual[$x],
                'rupiah' => $rupiah[$x],
                'rp_kg' => $rp_kg[$x],
                'urutan' => $urutan,
                'id_jenis_telur' => $id_jenis_telur[$x],
                'jenis_penjualan' => 'pcs',
                'lunas' => 'Y'
            ];
            DB::table('invoice_telur')->insert($data);
        }
        return redirect()->route("nota", ['nota' => $no_nota])->with('sukses', 'Data berhasil di input');
    }

    public function nota(Request $r)
    {
        $data = [
            'title' => 'Nota Telur',
            'nota' => DB::selectOne("SELECT a.tgl, a.no_nota, b.nm_post, a.id_post, a.urutan  FROM invoice_telur as a left join tb_post_center as b on b.id_post = a.id_post
             where a.no_nota = '$r->nota' group by a.no_nota"),
            'isi_nota' => DB::table('invoice_telur as a')->join('tb_jenis_telur as b', 'a.id_jenis_telur', 'b.id')->where('no_nota', $r->nota)->get(),
            'akun' => DB::table('tb_akun')->where('id_akun', '31')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()


        ];

        return view('penjualan/nota', $data);
    }

    public function save_jurnal(Request $r)
    {
        $id_akun = $r->id_akun;
        $total = $r->total;
        $no_nota = $r->no_nota;
        $tgl = $r->tgl;
        $id_post = $r->id_post;
        $debit = $r->debit;

        DB::table('tb_jurnal')->where('no_nota', 'T-' . $no_nota)->delete();

        $data_kredit = [
            'tgl' => $tgl,
            'no_nota' => 'T-' . $no_nota,
            'id_buku' => '1',
            'id_akun' => '18',
            'ket' => 'Penjualan telur',
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
                'no_nota' => 'T-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun[$x],
                'ket' => 'Penjualan telur',
                'debit' => $debit[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);
            if ($akun->id_akun == '31') {
                DB::table('invoice_telur')->where('no_nota', $no_nota)->update(['lunas' => 'T']);
            } else {
            }
        }
        return redirect()->route("p_telur")->with('sukses', 'Data berhasil di input');
    }

    public function tb_post(Request $r)
    {
        $data = [
            'nm_post' => $r->nm_post,
            'id_akun' => '18',
            'no_telpon' => $r->no_telpon,
            'npwp' => $r->npwp
        ];
        DB::table('tb_post_center')->insert($data);
        return redirect()->route("add_telur")->with('sukses', 'Data berhasil di input');
    }

    public function delete(Request $r)
    {
        DB::table('invoice_telur')->where('no_nota', $r->nota)->delete();
        DB::table('tb_jurnal')->where('no_nota', 'T-' . $r->nota)->delete();
        return redirect()->route("p_telur")->with('sukses', 'Data berhasil di hapus');
    }

    public function edit_telur(Request $r)
    {

        $nota = DB::select("SELECT a.* , b.jenis
        FROM invoice_telur AS a
        LEFT JOIN tb_jenis_telur AS b ON b.id = a.id_jenis_telur
        WHERE a.no_nota = '$r->nota'");

        $nota2 = DB::selectOne("SELECT a.id_post, a.no_nota, a.urutan, a.driver, a.tgl FROM invoice_telur as a where a.no_nota = '$r->nota' group by a.no_nota");
        $data = [
            'title' => 'Edit Penjualan Telur',
            'costumer' => DB::table('tb_post_center')->where('id_akun', '18')->get(),
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'nota' => $nota,
            'nota2' => $nota2,
        ];

        return view('penjualan/edit', $data);
    }

    public function edit_kg(Request $r)
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
        $no_nota = $r->no_nota;
        $id_telur = $r->id_telur;

        $id_post2 = $r->id_post2;


        if ($id_post == $id_post2) {
            $urutan = $r->urutan;
        } else {
            $rutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM invoice_telur as a where a.id_post = '$id_post'");
            if (empty($rutan->urutan)) {
                $urutan = '1';
            } else {
                $urutan = $rutan->urutan + 1;
            }
        }



        for ($x = 0; $x < count($pcs); $x++) {
            $data = [
                'tgl' => $tgl,
                'id_post' => $id_post,
                'driver' => $driver,
                'pcs' => $pcs[$x],
                'kg' => $kg[$x],
                'kg_jual' => $kg_jual[$x],
                'rupiah' => $rupiah[$x],
                'rp_kg' => $rp_kg[$x],
                'urutan' => $urutan,
                'id_jenis_telur' => $id_jenis_telur[$x],
                'jenis_penjualan' => 'kg',
            ];
            DB::table('invoice_telur')->where('id_invoice_telur', $id_telur[$x])->update($data);
        }
        return redirect()->route("nota2", ['nota' => $no_nota])->with('sukses', 'Data berhasil di edit');
    }

    public function nota2(Request $r)
    {
        $data = [
            'title' => 'Nota Telur',
            'nota' => DB::selectOne("SELECT a.tgl, a.no_nota, b.nm_post, a.id_post, a.urutan  FROM invoice_telur as a left join tb_post_center as b on b.id_post = a.id_post
             where a.no_nota = '$r->nota' group by a.no_nota"),
            'isi_nota' => DB::table('invoice_telur as a')->join('tb_jenis_telur as b', 'a.id_jenis_telur', 'b.id')->where('no_nota', $r->nota)->get(),
            'akun' => DB::table('tb_akun')->where('id_akun', '31')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()


        ];

        return view('penjualan/nota2', $data);
    }

    public function save_jurnal2(Request $r)
    {


        $id_akun = $r->id_akun;
        $total = $r->total;
        $no_nota = $r->no_nota;
        $tgl = $r->tgl;
        $id_post = $r->id_post;

        DB::table('tb_jurnal')->where('no_nota', 'T-' . $no_nota)->delete();

        if ($id_akun == '31') {
            $data_kredit = [
                'tgl' => $tgl,
                'no_nota' => 'T-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => '18',
                'ket' => 'Piutang telur',
                'kredit' => $total,
                'id_post' => $id_post,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_kredit);
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'T-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun,
                'ket' => 'Piutang telur',
                'debit' => $total,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);
        } else {
            $data_kredit = [
                'tgl' => $tgl,
                'no_nota' => 'T-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => '18',
                'ket' => 'Penjualan telur',
                'kredit' => $total,
                'id_post' => $id_post,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_kredit);
            $data_debit = [
                'tgl' => $tgl,
                'no_nota' => 'T-' . $no_nota,
                'id_buku' => '1',
                'id_akun' => $id_akun,
                'ket' => 'Penjualan telur',
                'debit' => $total,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data_debit);

            DB::table('invoice_telur')->where('no_nota', $no_nota)->update(['lunas' => 'Y']);
        }
        return redirect()->route("p_telur")->with('sukses', 'Data berhasil di input');
    }

    public function tambah_pembayaran(Request $r)
    {
        $data = [
            'count' => $r->count,
            'akun' => DB::table('tb_akun')->where('id_akun', '31')->first(),
            'akun2' => DB::table('tb_akun as a')->join('tb_permission_akun as b', 'a.id_akun', 'b.id_akun')->where('id_sub_menu_akun', '28')->get()
        ];
        return view('penjualan/tambah', $data);
    }
}
