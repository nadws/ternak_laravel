<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Isi_jurnalpengeluaran extends Controller
{
    public function tambah_jurnal(Request $r)
    {

        $data = [
            'title' => 'Absensi',
            'count' => $r->count,
            'satuan' => DB::table('tb_satuan')->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $r->id_akun)->get()

        ];
        return view('isi_jurnalpengeluaran/get_isi_jurnal_plus', $data);
    }
    public function tambah_umum(Request $r)
    {
        $akun = DB::table('tb_akun')->where('id_akun', $r->id_akun)->first();
        $satuan = DB::table('tb_satuan')->where('id', $akun->id_satuan)->first();
        $data = [
            'title' => 'Absensi',
            'count' => $r->count,
            'satuan' => DB::table('tb_satuan')->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $r->id_akun)->get(),
            'satuan' => $satuan

        ];
        return view('isi_jurnalpengeluaran/get_isi_umum_plus', $data);
    }
    public function tambah_input_vitamin(Request $r)
    {
        $data = [
            'title' => 'Absensi',
            'count' => $r->count,
            'satuan' => DB::table('tb_satuan')->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $r->id_akun)->get(),
            'barang' => DB::table('tb_barang_pv')->where('id_akun', $r->id_akun)->get(),

        ];
        return view('isi_jurnalpengeluaran/get_isi_pakan_plus', $data);
    }

    // Save

    public function save_jurnal_biaya(Request $r)
    {

        $no_id = $r->no_id;
        $ttl_rp = $r->ttl_rp;
        $ket = $r->keterangan;
        $id_post = $r->id_post_center;
        $qty = $r->qty;

        $akun = DB::table('tb_akun')->where('id_akun', $r->id_akun)->first();
        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }



        $data = [
            'id_akun' => $r->id_akun_kredit,
            'id_buku' => '3',
            'urutan' => $no_urutan,
            'no_nota' => 'AGR-' . $no_urutan,
            'tgl' => $r->tgl,
            'ket' => 'Pengeluaran' . ' ' . $akun->nm_akun,
            'kredit' => $r->kredit,
            'admin' => Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);


        for ($x = 0; $x < count($ttl_rp); $x++) {
            $data = [
                'id_akun' => $r->id_akun,
                'id_buku' => '3',
                'urutan' => $no_urutan,
                'no_nota' => 'AGR-' . $no_urutan,
                'tgl' => $r->tgl,
                'debit' => $ttl_rp[$x],
                'ket' => $ket[$x],
                'qty' => $qty[$x],
                'id_post' => $id_post[$x],
                'no_id' =>  $no_id[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);
        }
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }
    public function save_jurnal_umum(Request $r)
    {

        $no_id = $r->no_id;
        $ttl_rp = $r->ttl_rp;
        $ket = $r->keterangan;
        $id_post = $r->id_post_center;
        $qty = $r->qty;

        $akun = DB::table('tb_akun')->where('id_akun', $r->id_akun)->first();
        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a ");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }



        $data = [
            'id_akun' => $r->id_akun_kredit,
            'id_buku' => '3',
            'urutan' => $no_urutan,
            'no_nota' => 'AGR-' . $no_urutan,
            'tgl' => $r->tgl,
            'ket' => 'Pengeluaran' . ' ' . $akun->nm_akun,
            'kredit' => $r->kredit,
            'admin' => Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);


        for ($x = 0; $x < count($ttl_rp); $x++) {
            $data = [
                'id_akun' => $r->id_akun,
                'id_buku' => '3',
                'urutan' => $no_urutan,
                'no_nota' => 'AGR-' . $no_urutan,
                'tgl' => $r->tgl,
                'debit' => $ttl_rp[$x],
                'ket' => $ket[$x],
                'qty' => $qty[$x],
                'id_post' => $id_post[$x],
                'no_id' =>  $no_id[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);

            $data_asset = [
                'id_akun' => $r->id_akun,
                'tgl' => $r->tgl,
                'debit' => $qty[$x],
                'no_nota' => 'AGR-' . $no_urutan,
                'admin' => Auth::user()->name
            ];
            DB::table('tb_asset_umum')->insert($data_asset);
        }
        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }

    public function save_jurnal_pv(Request $r)
    {
        $no_id = $r->no_id;
        $ttl_rp = $r->ttl_rp;
        $ket = $r->keterangan;
        $id_post = $r->id_post_center;
        $id_barang = $r->id_barang;
        $qty = $r->qty;

        $akun = DB::table('tb_akun')->where('id_akun', $r->id_akun)->first();
        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '3'");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }



        $data = [
            'id_akun' => $r->id_akun_kredit,
            'id_buku' => '3',
            'urutan' => $no_urutan,
            'no_nota' => 'AGR-' . $no_urutan,
            'tgl' => $r->tgl,
            'ket' => 'Pengeluaran' . ' ' . $akun->nm_akun,
            'kredit' => $r->kredit,
            'admin' => Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);


        for ($x = 0; $x < count($ttl_rp); $x++) {
            $data = [
                'id_akun' => $r->id_akun,
                'id_buku' => '3',
                'urutan' => $no_urutan,
                'no_nota' => 'AGR-' . $no_urutan,
                'tgl' => $r->tgl,
                'debit' => $ttl_rp[$x],
                'ket' => $ket[$x],
                'qty' => $qty[$x],
                'no_id' =>  $no_id[$x],
                'id_barang_pv' => $id_barang[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_jurnal')->insert($data);

            $data_asset = [
                'id_akun' => $r->id_akun,
                'tgl' => $r->tgl,
                'debit' => $qty[$x],
                'no_nota' => 'AGR-' . $no_urutan,
                'id_barang' => $id_barang[$x],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_asset_pv')->insert($data_asset);
        }

        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }

    public function save_aktiva(Request $r)
    {
        $no_id = $r->no_id_aktiva;
        $ttl_rp = $r->ttl_rp_aktiva;
        $ket = $r->keterangan_aktiva;
        $id_post = $r->id_post_center_aktiva;
        $qty = $r->qty_aktiva;
        $id_satuan = $r->id_satuan_aktiva;
        $debit = $r->debit;

        $akun = DB::table('tb_akun')->where('id_akun', $r->id_akun)->first();
        $urutan = DB::selectOne("SELECT max(a.urutan) as urutan FROM tb_jurnal as a where a.id_buku = '3'");

        if (empty($urutan->urutan)) {
            $no_urutan = '1001';
        } else {
            $no_urutan = $urutan->urutan + 1;
        }
        $data = [

            'id_akun' => $r->id_akun_kredit,
            'id_buku' => '3',
            'urutan' => $no_urutan,
            'no_nota' => 'AGR-' . $no_urutan,
            'tgl' => $r->tgl,
            'ket' => 'Pengeluaran' . ' ' . $akun->nm_akun,
            'kredit' => $r->kredit,
            'admin' => Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);
        $data = [
            'no_id' => $no_id,
            'id_akun' => $r->id_akun,
            'id_buku' => '3',
            'urutan' => $no_urutan,
            'no_nota' => 'AGR-' . $no_urutan,
            'tgl' => $r->tgl,
            'ket' => $ket,
            'debit' => $r->kredit,
            'admin' => Auth::user()->name
        ];
        DB::table('tb_jurnal')->insert($data);


        $id_kelompok = $r->id_kelompok;

        $kelompok = DB::table('tb_kelompok_aktiva')->where('id_kelompok', $id_kelompok)->first();
        $susut = $kelompok->tarif;

        $data = [
            'tgl' => $r->tgl,
            'id_post' => $id_post,
            'id_kelompok' => $id_kelompok,
            'qty' => $qty,
            'no_nota' => 'AGR-' . $no_urutan,
            'id_satuan' => $id_satuan,
            'debit_aktiva' => $debit,
            'b_penyusutan' => (($debit * $qty) * $susut) / 12,
            'admin' => Auth::user()->name,
            'id_akun' => $r->id_akun
        ];
        DB::table('aktiva')->insert($data);

        $tgl1 = date('Y-m-01', strtotime($r->tgl));
        return redirect()->route("jurnal_pengeluaran", ['tgl1' => $tgl1, 'tgl2' => $r->tgl])->with('sukses', 'Data berhasil di input');
    }
}
