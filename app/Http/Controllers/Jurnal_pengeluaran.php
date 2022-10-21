<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;

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
            'title' => 'Jurnal Pengeluaran',
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
        $satuan = DB::table('tb_satuan')->where('id_satuan', $akun->id_satuan)->first();

        $data = [
            'satuan' => DB::table('tb_satuan')->get(),

            'post_center' => DB::select("SELECT *
                FROM tb_post_center AS a
                WHERE a.id_akun = '$id' AND a.id_post NOT IN(SELECT b.id_post FROM aktiva AS b)"),
            'barang' => DB::table('tb_barang_pv')->where('id_akun', $id)->get(),
            'aktiva' => DB::table('tb_kelompok_aktiva')->where('id_akun', $id)->orderBy('id_kelompok', 'ASC')->get(),
            'id_akun' => $id,
            'satuan2' => $satuan,

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
            } elseif ($akun->id_penyesuaian == '4') {
                return view('jurnal_pengeluaran/get_isi_pakan', $data);
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
                echo "asset_aktiva";
            } elseif ($akun->id_penyesuaian == '3') {
            } elseif ($akun->id_penyesuaian == '4') {
                echo "asset_pakan";
            }
        }
    }


    public function delete_jurnal(Request $r)
    {
        DB::table('tb_jurnal')->where('no_nota', $r->no_nota)->delete();
        DB::table('tb_asset_umum')->where('no_nota', $r->no_nota)->delete();
        return redirect()->route("jurnal_pengeluaran")->with('sukses', 'Data berhasil di hapus');
    }



    public function print_jurnal(Request $r)
    {
        $nota = $r->nota;

        $data = [
            'nota' => $nota,
            'jurnal2' => DB::selectOne("SELECT * FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.no_nota = '$nota' group by a.no_nota"),
            'jurnal' => DB::select("SELECT * FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.no_nota = '$nota'")
        ];

        return view('jurnal_pengeluaran/view_print', $data);
    }
    public function print_jurnal2(Request $r)
    {
        $nota = $r->nota;

        $data = [
            'nota' => $nota,
            'jurnal2' => DB::selectOne("SELECT * FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.no_nota = '$nota' group by a.no_nota"),
            'jurnal' => DB::select("SELECT * FROM tb_jurnal as a left join tb_akun as b on b.id_akun = a.id_akun where a.no_nota = '$nota'")
        ];

        return view('jurnal_pengeluaran/view_print2', $data);
    }

    public function get_barang(Request $r)
    {
        $barang = DB::table("tb_barang_pv")->where('id_barang', $r->id_barang)->first();

        $satuan = DB::table("tb_satuan")->where('id_satuan', $barang->id_satuan)->get();

        foreach ($satuan as $k) {
            echo "<option value='" . $k->id_satuan . "'>" . $k->nm_satuan . "</option>";
        }
    }

    public function get_post_aktiva(Request $r)
    {
        $post = DB::select("SELECT *
        FROM tb_post_center AS a
        WHERE a.id_akun = '$r->id_akun' AND a.id_post NOT IN(SELECT b.id_post FROM aktiva AS b)");

        echo "<option value=''>Pilih Post Center</option>";
        foreach ($post as $k) {
            echo "<option value='" . $k->id_post . "'>" . $k->nm_post . "</option>";
        }
    }

    public function get_ttl_aktiva(Request $r)
    {
        $debit = DB::selectOne("SELECT SUM(a.debit) AS debit 
        FROM tb_jurnal AS a
        WHERE a.id_post = '$r->id_post'");

        echo $debit->debit;
    }
}
