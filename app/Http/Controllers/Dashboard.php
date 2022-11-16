<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index(Request $r)
    {
        $tujuh_hari = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
        $tgl = $r->tgl;
        $tgl1 = $tgl ?? date('Y-m-d', $tujuh_hari);

        $jenisTelur = DB::table('tb_jenis_telur')->get();
        $akun = DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->get();
        $akunPakan = DB::table('tb_akun as a')->where('id_akun', 41)->first();
        $akunObatVit = DB::table('tb_akun as a')->where('id_akun', 39)->first();
        $pakan = DB::table('tb_barang_pv')->where('id_jenis', 1)->get();
        $obatVit = DB::table('tb_barang_pv')->where('id_jenis', '!=', 1)->get();
        $jenisObat = DB::table('tb_jenis')->where('id_jenis', '!=', 1)->get();
        $post = DB::table('tb_post_center')->where('id_akun', 41)->get();
        $h_pakan = DB::select("SELECT b.id_barang,b.nm_barang,(c.debit * SUM(a.debit - a.kredit)) as debit,SUM(a.debit - a.kredit) as qty, d.nm_satuan FROM tb_asset_pv as a
                            LEFT JOIN tb_barang_pv as b ON b.id_barang = a.id_barang
                            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
                            LEFT JOIN (
                                SELECT id_barang_pv, SUM(debit / qty) as debit, SUM(qty) as qty FROM `tb_jurnal` GROUP BY id_barang_pv
                            ) as c ON c.id_barang_pv = a.id_barang
                            WHERE b.id_jenis = 1 AND c.debit != 0
                            GROUP BY a.id_barang;
                    ");
        $h_obatVit = DB::select("SELECT b.id_barang,b.nm_barang,(c.debit * SUM(a.debit - a.kredit)) as debit, SUM(a.debit - a.kredit) as qty, d.nm_satuan FROM tb_asset_pv as a
                            LEFT JOIN tb_barang_pv as b ON b.id_barang = a.id_barang
                            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
                            LEFT JOIN (
                                SELECT id_barang_pv, SUM(debit / qty) as debit, SUM(qty) as qty FROM `tb_jurnal` GROUP BY id_barang_pv
                            ) as c ON c.id_barang_pv = a.id_barang
                            WHERE b.id_jenis != 1 AND c.debit != 0
                            GROUP BY a.id_barang;
                    ");
        $data_barang = DB::table('tb_barang_pv as a')->join('tb_satuan as b', 'a.id_satuan', 'b.id_satuan')->get();
        $post_center = DB::table('tb_post_center')->where('id_akun', 29)->get();
        $stokRak = DB::selectOne("SELECT SUM(a.debit - a.kredit) as ttl FROM `tb_asset_umum` as a
                    WHERE a.id_akun = 29");
        $stokSolar = DB::selectOne("SELECT SUM(a.debit - a.kredit) as ttl FROM `tb_asset_umum` as a
                    WHERE a.id_akun = 27");
        $rakTelur = DB::selectOne("SELECT (SUM(a.debit) / SUM(a.qty)) as harga
                    FROM tb_jurnal as a 
                    where a.id_akun = '29' AND a.debit != 0 
                    ORDER BY a.id_jurnal DESC LIMIT 1");
        $ayam = DB::select("SELECT * FROM tb_populasi as a
                    LEFT JOIN tb_kandang as b ON a.id_kandang = b.id_kandang
                    WHERE a.tgl = '$tgl1'");
        $ayamPotong = DB::selectOne("SELECT sum(a.culling) as culling FROM tb_populasi as a where a.tgl = '$tgl1'");
        $stok_ayam_mtd = DB::selectOne("SELECT SUM(a.culling) AS kirim_mtd
                    FROM tb_populasi AS a where a.check_mtd = 'Y'");
        $stok_ayam_kirim = DB::selectOne("SELECT SUM(a.qty) AS kirim
                    FROM kirim_ayams AS a where a.check = 'Y'");
        $ayam_mtd = DB::selectOne("SELECT a.id as id_kirim_ayam, a.check, sum(a.qty) as qty FROM kirim_ayams as a where a.tgl = '$tgl1'");
        $stok_ayam_penjualan = DB::selectOne("SELECT sum(a.ekor) AS jual
                    FROM invoice_ayam AS a");
        $stok_alpa = DB::select("SELECT
                    sum(a.pcs) as ttl_pcs,
                    sum(a.kg) as ttl_kg,
                    a.id_jenis_telur as id_jenis
                    FROM invoice_telur as a");

        $telur = DB::select("SELECT a.check,a.id_telur,b.id_kandang,b.nm_kandang,a.id_jenis FROM `tb_telur` as a
        LEFT JOIN tb_kandang as b on a.id_kandang = b.id_kandang
        WHERE a.tgl = '$tgl1' AND a.id_kandang != ''
        GROUP BY a.id_kandang;");



        $data = [
            'title' => 'Dashboard',
            'telur' => $telur,
            'akun' => $akun,
            'ayam' => $ayam,
            'ayam_mtd' => $ayam_mtd,
            'stok_ayam_mtd' => $stok_ayam_mtd,
            'stok_ayam_penjualan' => $stok_ayam_penjualan,
            'stok_ayam_kirim' => $stok_ayam_kirim,
            'ayamPotong' => $ayamPotong,
            'tgl' => $tgl1,
            'tgl1' => $tgl1,
            'akun' => $akun,
            'post_center' => $post_center,
            'pakan' => $pakan,
            'stokRak' => $stokRak,
            'stokSolar' => $stokSolar,
            'rakTelur' => $rakTelur,
            'obatVit' => $obatVit,
            'jenisObat' => $jenisObat,
            'postCenter' => $post,
            'akunPakan' => $akunPakan,
            'akunObatVit' => $akunObatVit,
            'jenisTelur' => $jenisTelur,
            'data_barang' => $data_barang,
            'hargaPakan' => $h_pakan,
            'hargaObat' => $h_obatVit,
        ];

        return view('dashboard.welcome', $data);
    }

    public function kontenViewSolar()
    {
        $data = [
            'title' => 'view solar'
        ];
        return view('dashboard.viewSolar', $data);
    }

    public function kontenViewRak(Request $r)
    {
        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-d');

        $table = DB::select("SELECT * FROM `tb_asset_umum` as a
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND a.id_akun = 29");
        $data = [
            'title' => 'view Rak telur',
            'table' => $table
        ];
        return view('dashboard.viewRak', $data);
    }

    public function kontenViewPakan(Request $r)
    {

        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-d');
        $id_barang = $r->id_barang ?? 0;
        $ada = !$id_barang ? "" : "AND b.id_barang = '$id_barang'";

        $table = DB::select("SELECT * FROM `tb_asset_pv` as a
        LEFT JOIN tb_barang_pv as b ON a.id_barang = b.id_barang
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND b.id_jenis = 1 $ada");
        $data = [
            'title' => 'view Pakan telur',
            'table' => $table
        ];
        return view('dashboard.viewPakan', $data);
    }

    public function kontenViewObatVit(Request $r)
    {
        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-d');
        $id_barang = $r->id_barang ?? 0;
        $ada = !$id_barang ? "" : "AND b.id_barang = '$id_barang'";

        $table = DB::select("SELECT * FROM `tb_asset_pv` as a
        LEFT JOIN tb_barang_pv as b ON a.id_barang = b.id_barang
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND b.id_jenis != 1 $ada");
        $data = [
            'title' => 'view Pakan telur',
            'table' => $table
        ];
        return view('dashboard.viewObatVit', $data);
    }

    public function kontenPilihPakan()
    {
        $pakan = DB::table('tb_barang_pv')->where('id_jenis', 1)->get();
        $data = [
            'pakan' => $pakan
        ];
        return view('dashboard.kontenPilihPakan', $data);
    }

    public function kontenPilihObatVit()
    {
        $pakan = DB::table('tb_barang_pv')->where('id_jenis', '!=', 1)->get();
        $data = [
            'pakan' => $pakan
        ];
        return view('dashboard.kontenPilihObatVit', $data);
    }

    public function tbhPakan(Request $r)
    {
        $post = DB::table('tb_post_center')->where('id_akun', 41)->get();
        $data = [
            'postCenter' => $post,
            'c' => $r->c
        ];
        return view('dashboard.tbhPakan', $data);
    }
    public function tbhObatVit(Request $r)
    {
        $post = DB::table('tb_post_center')->where('id_akun', 41)->get();
        $data = [
            'postCenter' => $post,
            'c' => $r->c
        ];
        return view('dashboard.tbhObatVit', $data);
    }

    public function selStokAwalObatVit(Request $r)
    {
        $id_barang = $r->id_barang;
        $barang = DB::table('tb_barang_pv as a')->join('tb_satuan as b', 'a.id_satuan', 'b.id_satuan')->where('a.id_barang', $id_barang)->first();
        echo $barang->nm_satuan;
    }

    public function selPemutihanObatVit(Request $r)
    {
        $id_barang = $r->id_barang;
        $barang = DB::table('tb_barang_pv as a')->join('tb_satuan as b', 'a.id_satuan', 'b.id_satuan')->where('id_barang', $id_barang)->first();
        echo $barang->nm_satuan;
    }

    public function modal_tbh_pakan(Request $r)
    {
        $nm_barang = $r->nm_barang;
        $id_jenis = $r->id_jenis;
        DB::table('tb_barang_pv')->insert([
            'nm_barang' => $r->nm_barang,
            'id_satuan' => $id_jenis == 1 ? 18 : 12,
            'id_satuan_pakai' => $id_jenis == 1 ? 18 : 18,
            'id_akun' => $id_jenis == 1 ? 41 : 39,
            'id_jenis' => $id_jenis,
            'kegunaan' => 0,
            'dosis' => 0,
            'campuran' => 0,
            'admin' => Auth::user()->name,
        ]);
    }

    public function get_satuan_pakan(Request $r)
    {
        $satuan = DB::table('tb_barang_pv as a')->join('tb_satuan as b', 'a.id_satuan', 'b.id_satuan')->where('a.id_barang', $r->id_barang)->first();
        $data = [
            'id_satuan' => $satuan->id_satuan,
            'nm_satuan' => $satuan->nm_satuan,
        ];

        echo json_encode($data);
    }

    public function save_pemutihan_pv(Request $r)
    {

        $tgl = $r->tgl;
        $id_barang = $r->id_barang;
        $qty = $r->qty;
        $nota = DB::table('tb_asset_pv')->count();
        $nota = empty($nota) ? '1001' : 1001 + ($nota + 1);
        $cekJenis = DB::table('tb_barang_pv')->where('id_barang', $id_barang)->first();
        $jenis = $cekJenis->id_jenis == 1 ? '41' : '39';

        $pemutihan = $r->pemutihan;
        $stok_awal = $r->stok_awal;

        $data = [
            'id_akun' => $jenis,
            'tgl' => $tgl,
            'debit' => empty($stok_awal) ? 0 :  $qty,
            'kredit' => empty($pemutihan) ? 0 :  $qty,
            'id_barang' => $id_barang,
            'no_nota' => "AGR-$nota",
            'admin' => Auth::user()->name,
            'disesuaikan' => 'T',
        ];
        DB::table('tb_asset_pv')->insert($data);

        return redirect()->route('dashboard')->with('sukses', 'Berhasil tambah pemutihan pakan');
    }

    public function add_rak_telur(Request $r)
    {
        $tgl = $r->tgl;
        $tujuan = $r->tujuan;
        $keterangan = $r->keterangan;
        $qty = $r->qty;
        $id_satuan = 26;
        $harga = $r->harga;
        $id_post_center = $r->id_post_center;

        $nota = DB::table('tb_asset_pv')->count();
        $nota = empty($nota) ? '1001' : 1001 + ($nota + 1);

        $data = [
            'id_akun' => 29,
            'tgl' => $tgl,
            'kredit' => 0,
            'debit' => $qty,
            'no_nota' => "RKT-$nota",
            'disesuaikan' => 'T',
            'admin' => Auth::user()->name,
        ];

        DB::table('tb_asset_umum')->insert($data);

        $data_metode = [
            'id_buku' => 3,
            'id_satuan' => $id_satuan,
            'id_akun' => '29',
            'no_nota' => 'RKT-' . $nota,
            'urutan' => $nota,
            'debit' => $harga,
            'qty' => $qty,
            'tgl' => $tgl,
            'id_post' => $id_post_center,
            'ket' => $keterangan,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data_metode);

        $data_debit = [
            'id_buku' => 3,
            'id_akun' => '30',
            'no_nota' => 'RKT-' . $nota,
            'urutan' => $nota,
            'kredit' => $harga,
            'qty' => $qty,
            'tgl' => $tgl,
            'ket' => $keterangan,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data_debit);

        return redirect()->route('dashboard')->with('sukses', "Berhasil tambah rak telur");
    }

    public function pemutihan_rak_telur(Request $r)
    {
        $nota = DB::table('tb_asset_umum')->count();
        $nota = empty($nota) ? '1001' : 1001 + ($nota + 1);
        $data = [
            'id_akun' => 29,
            'tgl' => $r->tgl,
            'debit' => 0,
            'kredit' => $r->qty,
            'no_nota' => "RKT-$nota",
            'disesuaikan' => 'T',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_asset_umum')->insert($data);
        return redirect()->route('dashboard')->with('sukses', "Berhasil pemutihan rak telur");
    }

    public function stok_awal_rak_telur(Request $r)
    {
        $nota = DB::table('tb_asset_umum')->count();
        $nota = empty($nota) ? '1001' : 1001 + ($nota + 1);
        $data = [
            'id_akun' => 29,
            'tgl' => $r->tgl,
            'kredit' => 0,
            'debit' => $r->qty,
            'no_nota' => "RKT-$nota",
            'disesuaikan' => 'T',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_asset_umum')->insert($data);
        return redirect()->route('dashboard')->with('sukses', "Berhasil tambah stok awal rak telur");
    }

    // public function add_stok_solar(Request $r)
    // {

    // }

    public function pemutihan_stok_solar(Request $r)
    {
        $nota = DB::table('tb_asset_umum')->count();
        $nota = empty($nota) ? '1001' : 1001 + ($nota + 1);
        $jenis = $r->jenis;
        $data = [
            'id_akun' => 27,
            'tgl' => $r->tgl,
            'debit' => $jenis == 'pemutihan' ? 0 : $r->qty,
            'kredit' => $jenis == 'pemutihan' ? $r->qty : 0,
            'no_nota' => "SLR-$nota",
            'disesuaikan' => 'T',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_asset_umum')->insert($data);
        return redirect()->route('dashboard')->with('sukses', "Berhasil tambah stok telur");
    }

    public function check_ayam_mtd(Request $r)
    {
        DB::table('tb_populasi')->where([['id_pop', $r->id_populasi], ['tgl', $r->tgl]])->update(['check_mtd' => $r->check]);
        return redirect()->route('dashboard')->with('sukses', "Berhasil check ayam martadah stok telur");
    }

    public function check_ayam(Request $r)
    {
        DB::table('kirim_ayams')->where('id', $r->id_kirim_ayam)->update(['check' => $r->check]);
        return redirect()->route('dashboard')->with('sukses', "Berhasil check ayam stok telur");
    }

    public function pemutihan_ayam_mtd(Request $r)
    {
        $data = [
            'culling' => $r->qty,
            'check' => 'Y',
            'check_mtd' => 'Y',
            'tgl' => date('Y-m-d')
        ];
        DB::table('tb_populasi')->insert($data);
        return redirect()->route('dashboard')->with('sukses', "Berhasil pemutihan ayam stok telur");
    }

    public function pemutihan_ayam_alpa(Request $r)
    {
        $nota = DB::selectOne("SELECT max(a.nota) as nota FROM kirim_ayams as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota + 1;

        $data = [
            'tgl' => $r->tgl,
            'qty' => $r->qty,
            'kode' => 'PEM',
            'pemutihan' => 'Y',
            'nota' => $nota2,
            'admin' => Auth::user()->name,
            'check' => 'Y',
            'bawa' => 'Pemutihan'
        ];

        DB::table('kirim_ayams')->insert($data);
        return redirect()->route('dashboard')->with('sukses', "Berhasil pemutihan ayam alpa");
    }

    public function pemutihan_telur_mtd(Request $r)
    {

        $nota = DB::selectOne("SELECT max(a.nota) as nota FROM tb_penjualan_telur as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota + 1;

        for ($i = 0; $i < count($r->pcs); $i++) {

            $data = [
                'tgl' => $r->tgl,
                'admin' => Auth::user()->name,
                'nota' => $nota2,
                'pcs' => $r->pcs[$i],
                'kg' => $r->kg[$i],
                'id_jenis' => $r->id_jenis[$i],
            ];
            DB::table('tb_telur')->insert($data);
        }
        return redirect()->route('dashboard')->with('sukses', "Berhasil pemutihan telur mtd");
    }

    public function check_telur(Request $r)
    {

        if (!$r->id_penjualan) {
            $id = 'id_telur';
            $table = 'tb_telur';
            $cek = $r->cek;
        } else {
            $id = 'id_penjualan';
            $table = 'tb_penjualan_telur';
            $cek = $r->cek_alpa;
        }

        for ($i = 0; $i < count($r->$id); $i++) {
            DB::table($table)->where($id, $r->$id[$i])->update(['check' => $cek]);
        }

        return redirect()->route('dashboard')->with('sukses', "Berhasil check telur");
    }
}
