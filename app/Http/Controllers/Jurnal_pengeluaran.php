<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Jurnal_pengeluaran extends Controller
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
        $jurnal = DB::select("SELECT * FROM tb_jurnal as a left join tb_akun as b on a.id_akun = b.id_akun where a.id_buku = '3' and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");
        $data = [
            'title' => 'Jurnal',
            'akun' => DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->get(),
            'jurnal' => $jurnal,

            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where a.id_buku = '3' and a.tgl between '$tgl1' and '$tgl2' "),
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
        ];

        return view('jurnal_pengeluaran/index', $data);
    }

    public function akun_kredit(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', '!=', $id)->get();


        echo "<option value=''>Pilih Akun</option>";
        foreach ($akun as $k) {
            echo "<option value='" . $k->id_akun . "'>" . $k->nm_akun . "</option>";
        }
    }

    public function get_isi_jurnal(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', $id)->first();
        $satuan = DB::table('tb_satuan')->where('id', $akun->id_satuan)->first();

        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $id)->get(),
            'aktiva' => DB::table('tb_kelompok_aktiva')->get(),
            'id_akun' => $id,
            'satuan' => $satuan
        ];

        if ($akun->id_kategori == '5') {
            return view('jurnal_pengeluaran/get_isi_jurnal', $data);
        } elseif ($akun->id_kategori == '1') {
            if ($akun->id_penyesuaian == '1') {
                return view('jurnal_pengeluaran/get_isi_umum', $data);
            } elseif ($akun->id_penyesuaian == '2') {
                return view('jurnal_pengeluaran/get_isi_aktiva', $data);
            } elseif ($akun->id_penyesuaian == '3') {
                return view('jurnal_pengeluaran/get_isi_atk', $data);
            }
        }
    }

    public function get_save_jurnal(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', $id)->first();

        if ($akun->id_kategori == '5') {
            echo "biaya";
        } elseif ($akun->id_kategori == '1') {
            if ($akun->id_penyesuaian == '1') {
                echo "asset_umum";
            } elseif ($akun->id_penyesuaian == '2') {
            } elseif ($akun->id_penyesuaian == '3') {
            }
        }
    }

    public function tambah_jurnal(Request $r)
    {

        $data = [
            'title' => 'Absensi',
            'count' => $r->count,
            'satuan' => DB::table('tb_satuan')->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $r->id_akun)->get()

        ];
        return view('jurnal_pengeluaran/get_isi_jurnal_plus', $data);
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
        return view('jurnal_pengeluaran/get_isi_umum_plus', $data);
    }
    public function delete_jurnal(Request $r)
    {
        DB::table('tb_jurnal')->where('no_nota', $r->no_nota)->delete();
        DB::table('tb_asset_umum')->where('no_nota', $r->no_nota)->delete();
        return redirect()->route("jurnal_pengeluaran")->with('sukses', 'Sukses');
    }

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

        return redirect()->route("jurnal_pengeluaran")->with('sukses', 'Sukses');
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

        return redirect()->route("jurnal_pengeluaran")->with('sukses', 'Sukses');
    }
}
