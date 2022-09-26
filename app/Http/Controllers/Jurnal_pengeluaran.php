<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Jurnal_pengeluaran extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Jurnal Pengeluaran',
            'akun' => DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->get(),
            'jurnal' => DB::table('tb_jurnal as a')->join('tb_akun as b', 'a.id_akun', 'b.id_akun')->where('id_buku', '3')->get(),
            'total_jurnal' => DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as kredit FROM tb_jurnal as a where a.id_buku = '3'"),
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
            'logout' => $request->session()->get('logout'),
        ];

        return view('jurnal_pengeluaran/index', $data);
    }

    public function akun_kredit(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', '!=', $id)->get();

        foreach ($akun as $k) {
            echo "<option value='" . $k->id_akun . "'>" . $k->nm_akun . "</option>";
        }
    }

    public function get_isi_jurnal(Request $r)
    {
        $id = $r->id_debit;
        $akun = DB::table('tb_akun')->where('id_akun', $id)->first();

        $data = [
            'satuan' => DB::table('tb_satuan')->get(),
            'post_center' => DB::table('tb_post_center')->where('id_akun', $id)->get()
        ];

        if ($akun->id_kategori == '5') {
            return view('jurnal_pengeluaran/get_isi_jurnal', $data);
        } elseif ($akun->id_kategori == '5') {
            if ($akun->id_penyesuaian == '1') {
                return view('jurnal_pengeluaran/get_isi_umum', $data);
            } elseif ($akun->id_penyesuaian == '2') {
                return view('jurnal_pengeluaran/get_isi_aktiva', $data);
            } elseif ($akun->id_penyesuaian == '3') {
                return view('jurnal_pengeluaran/get_isi_atk', $data);
            }
        }
    }
}
