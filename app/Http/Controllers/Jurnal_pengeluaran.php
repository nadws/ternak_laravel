<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
                echo "asset_atk";
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
    public function get_post_atk(Request $r)
    {
        $id_kredit = $r->id_kredit;
        $id_debit = $r->id_debit;
        if ($id_kredit == '58') {
            $post = DB::select("SELECT *
            FROM tb_post_center AS a
            WHERE a.id_akun = '$id_kredit' AND a.id_post NOT IN(SELECT b.id_post FROM table_atk AS b)");
        } else {
            $post = DB::select("SELECT *
            FROM tb_post_center AS a
            WHERE a.id_akun = '$id_debit' AND a.id_post NOT IN(SELECT b.id_post FROM table_atk AS b)");
        }

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
    public function get_ttl_atk(Request $r)
    {
        $debit = DB::selectOne("SELECT SUM(a.debit) AS debit 
        FROM tb_jurnal AS a
        WHERE a.id_post = '$r->id_post'");

        echo $debit->debit;
    }

    public function print_jurnal_all(Request $r)
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

        return view('jurnal_pengeluaran/print_j_all', $data);
    }
    public function export_jurnal_all(Request $r)
    {
        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }
        $jurnal = DB::select("SELECT * FROM tb_jurnal as a 
        left join tb_akun as b on a.id_akun = b.id_akun 
        left join tb_post_center as c on a.id_post = c.id_post 
        where a.id_buku = '3' and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Jurnal Pengeluaran');

        $sheet->getStyle('A1:F1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(3);
        $sheet->getColumnDimension('D')->setWidth(3);
        $sheet->getColumnDimension('E')->setWidth(5);
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setWidth(6);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(28);
        $sheet->getColumnDimension('K')->setWidth(8);
        $sheet->getColumnDimension('L')->setWidth(8);
        $sheet->getColumnDimension('M')->setWidth(6);
        // header text
        $sheet
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Tanggal')
            ->setCellValue('C1', 'D')
            ->setCellValue('D1', 'M')
            ->setCellValue('E1', 'Y')
            ->setCellValue('F1', 'No Nota')
            ->setCellValue('G1', 'No Id')
            ->setCellValue('H1', 'Post Akun')
            ->setCellValue('I1', 'Post Center')
            ->setCellValue('J1', 'Keterangan')
            ->setCellValue('K1', 'Debit')
            ->setCellValue('L1', 'Kredit')
            ->setCellValue('M1', 'Admin');
        $kolom = 2;
        $i = 1;
        foreach ($jurnal as $k) {
            $sheet->setCellValue('A' . $kolom, $i++);
            $sheet->setCellValue('B' . $kolom, $k->tgl);
            $sheet->setCellValue('C' . $kolom, date('d', strtotime($k->tgl)));
            $sheet->setCellValue('D' . $kolom, date('m', strtotime($k->tgl)));
            $sheet->setCellValue('E' . $kolom, date('Y', strtotime($k->tgl)));
            $sheet->setCellValue('F' . $kolom, $k->no_nota);
            $sheet->setCellValue('G' . $kolom, $k->no_id);
            $sheet->setCellValue('H' . $kolom, $k->nm_akun);
            $sheet->setCellValue('I' . $kolom, $k->nm_post);
            $sheet->setCellValue('J' . $kolom, $k->ket);
            $sheet->setCellValue('K' . $kolom, $k->debit);
            $sheet->setCellValue('L' . $kolom, $k->kredit);
            $sheet->setCellValue('M' . $kolom, $k->admin);

            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style_huruf = [
            'font' => array(
                'size' => 10,
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),

        ];
        $style_number = [
            'font' => array(
                'size' => 10,
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),

        ];
        $style_header = array(
            'font' => array(
                'size' => 10,
                'bold'  =>  true
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $batas = $jurnal;
        $batas = count($batas) + 1;
        $sheet->getStyle('A1:M1')->applyFromArray($style_header);
        $sheet->getStyle('A2:J' . $batas)->applyFromArray($style_huruf);
        $sheet->getStyle('M2:M' . $batas)->applyFromArray($style_huruf);
        $sheet->getStyle('K2:L' . $batas)->applyFromArray($style_number);



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Jurnal Pengeluaran.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
