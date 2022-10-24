<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Akun',
            'akun' => DB::table('tb_akun as a')->join('tb_kategori_akun as b', 'a.id_kategori', 'b.id_kategori')->orderBy('id_akun', 'DESC')->get(),
            'kategori' => DB::table('tb_kategori_akun')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
        ];

        return view('akun/index', $data);
    }

    public function get_no_akun(Request $request)
    {
        $id = $request->id_pilih;
        $max_no_akun = DB::selectOne("SELECT MAX(a.no_akun) AS no_max
        FROM tb_akun AS a
        WHERE a.id_kategori = '$id'");


        if (empty($max_no_akun->no_max)) {
            if ($id == '1') {
                $max = '1001';
            } elseif ($id == '2') {
                $max = '2001';
            } elseif ($id == '3') {
                $max = '3001';
            } elseif ($id == '4') {
                $max = '4001';
            } elseif ($id == '5') {
                $max = '5001';
            }
        } else {
            $max = $max_no_akun->no_max + 1;
        }
        echo "$max";
    }

    public function add_akun(Request $r)
    {
        if (empty($r->id_penyesuaian)) {
            $data = [
                'no_akun' => $r->no_akun,
                'kd_akun' => $r->kd_akun,
                'nm_akun' => $r->nm_akun,
                'id_kategori' => $r->id_kategori,
                'id_satuan' => empty($r->id_satuan) ? '0' : $r->id_satuan
            ];
            $akun = Akun::create($data);

            $id1 = $akun->id;
        } else {
            $data = [
                'no_akun' => $r->no_akun,
                'kd_akun' => $r->kd_akun,
                'nm_akun' => $r->nm_akun,
                'id_kategori' => $r->id_kategori,
                'id_penyesuaian' => $r->id_penyesuaian,
                'id_satuan' => empty($r->id_satuan) ? '0' : $r->id_satuan

            ];
            $akun = Akun::create($data);

            $id1 = $akun->id;

            if ($r->id_penyesuaian == '2') {
                $nm_kelompok = $r->nm_kelompok;
                $umur = $r->umur;
                $satuan_aktiva = $r->satuan_aktiva;
                $tarif = $r->tarif;
                $barang = $r->barang;

                for ($x = 0; $x < count($nm_kelompok); $x++) {
                    $t_tarif =  $tarif[$x] / 100;
                    $data = [
                        'nm_kelompok' => $nm_kelompok[$x],
                        'umur' => $umur[$x],
                        'satuan' => $satuan_aktiva[$x],
                        'tarif' => $t_tarif,
                        'barang_kelompok' => $barang[$x],
                        'id_akun' => $id1
                    ];
                    DB::table('tb_kelompok_aktiva')->insert($data);
                }
            }
        }



        if (empty($r->no_akun2)) {
            # code...
        } else {
            $data = [
                'no_akun' => $r->no_akun2,
                'kd_akun' => $r->kd_akun2,
                'nm_akun' => $r->nm_akun2,
                'id_kategori' => $r->id_kategori2,

            ];
            $akun2 = Akun::create($data);
            $id2 = $akun2->id;
        }


        if (empty($r->no_akun2)) {
            # code...
        } else {
            $data = [
                'id_akun' => $id1,
                'id_relation_debit' => $id2,
                'id_relation_kredit' => $id1,
            ];

            DB::table('tb_relasi_akun')->insert($data);
        }

        $id_kategori = $r->id_kategori;

        if ($id_kategori == '5') {
            $data = [
                'id_akun' => $id1,
                'id_sub_menu_akun' => '27'
            ];
            DB::table('tb_permission_akun')->insert($data);
        } elseif ($id_kategori == '4') {
            $data = [
                'id_akun' => $id1,
                'id_sub_menu_akun' => '26'
            ];
            DB::table('tb_permission_akun')->insert($data);
        } else {
            # code...
        }

        $id_biaya =  $r->id_biaya;
        $id_kas =  $r->id_kas;

        if ($id_kategori == '1') {
            if ($id_biaya == '1') {
                $data = [
                    'id_akun' => $id1,
                    'id_sub_menu_akun' => '30'
                ];
                DB::table('tb_permission_akun')->insert($data);
            } else {
            }
            if ($id_kas == '1') {
                $data = [
                    'id_akun' => $id1,
                    'id_sub_menu_akun' => '28'
                ];
                DB::table('tb_permission_akun')->insert($data);
            } else {
            }
        } else {
        }


        return redirect()->route("akun")->with('sukses', 'Sukses');
    }

    public function delete(Request $r)
    {
        $id = $r->id_akun;

        $jurnal = DB::table('tb_jurnal')->where('id_akun', $id)->first();

        if (empty($jurnal)) {

            DB::table('tb_akun')->where('id_akun', $id)->delete();
            DB::table('tb_permission_akun')->where('id_akun', $id)->delete();
            DB::table('tb_relasi_akun')->where('id_akun', $id)->delete();
            return redirect()->route("akun")->with('sukses', 'Data berhasil dihapus');
        } else {
            return redirect()->route("akun")->with('error', 'Data gagal dihapus');
        }
    }

    public function tambah_kelompok_aktiva(Request $r)
    {
        $data = ['count' => $r->count];
        return view('akun/kelompok', $data);
    }

    public function kelompok_akun(Request $r)
    {
        $data = [
            'aktiva' => DB::table('tb_kelompok_aktiva')->where('id_akun', $r->id_akun)->orderBy('id_kelompok', 'ASC')->get(),
            'id_akun' => $r->id_akun
        ];
        return view('akun/edit_kelompok', $data);
    }

    public function save_kelompok_baru(Request $r)
    {
        $nm_kelompok = $r->nm_kelompok;
        $umur = $r->umur;
        $satuan_aktiva = $r->satuan_aktiva;
        $tarif = $r->tarif;
        $barang = $r->barang;

        for ($x = 0; $x < count($nm_kelompok); $x++) {
            $t_tarif =  $tarif[$x] / 100;
            $data = [
                'nm_kelompok' => $nm_kelompok[$x],
                'umur' => $umur[$x],
                'satuan' => $satuan_aktiva[$x],
                'tarif' => $t_tarif,
                'barang_kelompok' => $barang[$x],
                'id_akun' => $r->id_akun
            ];
            DB::table('tb_kelompok_aktiva')->insert($data);
        }
    }

    public function delete_kelompok_baru(Request $r)
    {
        DB::table('tb_kelompok_aktiva')->where('id_kelompok', $r->id_kelompok)->delete();
    }
}
