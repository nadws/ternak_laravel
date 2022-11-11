<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Home extends Controller
{
    public function index(Request $r)
    {
        if (empty($r->bulan1)) {
            $tgl_akhir = date('Y-m-d');
            $tgl_awal = date('Y-m-d', strtotime('-4 month', strtotime($tgl_akhir)));
            $bulan1 = date('m');
            $tahun1 = date('Y');
            $bulan2 = date('m');
            $tahun2 = date('Y');
        } else {
            $bulan1 = $r->bulan1;
            $tahun1 = $r->tahun1;
            $bulan2 = $r->bulan2;
            $tahun2 = $r->tahun2;
            $h1 = date('t');


            $tgl_akhir = $tahun2 . '-' . $bulan2 . '-' . $h1;
            $tgl_awal =  $tahun1 . '-' . $bulan1 . '-' . 01;
        }

        $tahun = DB::select("SELECT a.tgl
        FROM tb_jurnal AS a
        WHERE a.tgl BETWEEN '$tgl_awal' and '$tgl_akhir'
        GROUP BY MONTH(a.tgl) , YEAR(a.tgl)
        ORDER BY a.tgl ASC");

        $data = [
            'title' => 'Laporan Bulanan',
            'akun_pendapatan' => DB::table('tb_akun')->where('id_kategori', 4)->get(),
            'akun_biaya_disesuaiakan' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun, b.id_relation_debit
            FROM tb_akun AS a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            WHERE b.id_relation_debit IS NOT null"),

            'akun_biaya' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun, b.id_relation_debit
            FROM tb_akun AS a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            WHERE b.id_relation_debit IS NULL AND a.id_kategori='5'"),

            'asset' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun
            FROM tb_akun AS a
            WHERE  a.id_kategori='1' and a.id_penyesuaian != 0"),

            'tahun' => $tahun,
            's_bulan' => DB::table('bulan')->get(),
            's_tahun' => DB::select("SELECT a.tgl FROM tb_jurnal as a group by YEAR(a.tgl)"),
            'bulan1' => $bulan1,
            'bulan2' => $bulan2,
            'tahun1' => $tahun1,
            'tahun2' => $tahun2,
        ];

        return view('home.index', $data);
    }

    public function view_jurnal_laporan_bulanan(Request $r)
    {
        $id_akun = $r->id_akun;
        $bulan = $r->bulan;
        $tahun = $r->tahun;

        $jurnal = DB::select("SELECT a.id_buku, a.tgl,a.no_nota, b.nm_akun, a.debit, a.kredit, a.ket, c.nm_post
        FROM tb_jurnal AS a
        LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
        left join tb_post_center as c on c.id_post = a.id_post
        
        WHERE a.id_buku not in('7','6') and a.id_akun = '$id_akun' AND MONTH(a.tgl) = '$bulan' AND YEAR(a.tgl) = '$tahun'
        order by a.tgl ASC");

        $data = [
            'jurnal' => $jurnal,
            'akun' => DB::table('tb_akun')->where('id_akun', $id_akun)->first(),
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        return view('home.view', $data);
    }

    public function e_home(Request $r)
    {
        if (empty($r->bulan1)) {
            $tgl_akhir = date('Y-m-d');
            $tgl_awal = date('Y-m-d', strtotime('-4 month', strtotime($tgl_akhir)));
            $bulan1 = date('m');
            $tahun1 = date('Y');
            $bulan2 = date('m');
            $tahun2 = date('Y');
        } else {
            $bulan1 = $r->bulan1;
            $tahun1 = $r->tahun1;
            $bulan2 = $r->bulan2;
            $tahun2 = $r->tahun2;
            $h1 = date('t');


            $tgl_akhir = $tahun2 . '-' . $bulan2 . '-' . $h1;
            $tgl_awal =  $tahun1 . '-' . $bulan1 . '-' . 01;
        }

        $tahun = DB::select("SELECT a.tgl
        FROM tb_jurnal AS a
        WHERE a.tgl BETWEEN '$tgl_awal' and '$tgl_akhir'
        GROUP BY MONTH(a.tgl) , YEAR(a.tgl)
        ORDER BY a.tgl ASC");

        $data = [
            'title' => 'Laporan Bulanan',
            'akun_pendapatan' => DB::table('tb_akun')->where('id_kategori', 4)->get(),
            'akun_biaya_disesuaiakan' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun, b.id_relation_debit
            FROM tb_akun AS a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            WHERE b.id_relation_debit IS NOT null"),

            'akun_biaya' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun, b.id_relation_debit
            FROM tb_akun AS a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            WHERE b.id_relation_debit IS NULL AND a.id_kategori='5'"),

            'asset' => DB::select("SELECT a.id_akun, a.nm_akun, a.id_akun
            FROM tb_akun AS a
            WHERE  a.id_kategori='1' and a.id_penyesuaian != 0"),

            'tahun' => $tahun,
            's_bulan' => DB::table('bulan')->get(),
            's_tahun' => DB::select("SELECT a.tgl FROM tb_jurnal as a group by YEAR(a.tgl)"),
        ];

        return view('home.export', $data);
    }
    public function e_all_home(Request $r)
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
        where a.id_buku in('3','4','5','7') and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");

        $jurnal_pemasukan = DB::select("SELECT * FROM tb_jurnal as a 
        left join tb_akun as b on a.id_akun = b.id_akun 
        left join tb_post_center as c on a.id_post = c.id_post 
        where a.id_buku = '1' and a.tgl between '$tgl1' and '$tgl2' order by a.id_jurnal DESC");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Jurnal Pengeluaran');

        $sheet->getStyle('A1:F1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(3);
        $sheet->getColumnDimension('C')->setWidth(9);
        $sheet->getColumnDimension('D')->setWidth(3);
        $sheet->getColumnDimension('E')->setWidth(3);
        $sheet->getColumnDimension('F')->setWidth(5);
        $sheet->getColumnDimension('G')->setWidth(8);
        $sheet->getColumnDimension('H')->setWidth(6);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(21);
        $sheet->getColumnDimension('K')->setWidth(28);
        $sheet->getColumnDimension('L')->setWidth(8);
        $sheet->getColumnDimension('M')->setWidth(8);
        $sheet->getColumnDimension('N')->setWidth(6);
        $sheet->getColumnDimension('P')->setWidth(16);
        $sheet->getColumnDimension('Q')->setWidth(3);
        $sheet->getColumnDimension('R')->setWidth(9);
        $sheet->getColumnDimension('S')->setWidth(3);
        $sheet->getColumnDimension('T')->setWidth(3);
        $sheet->getColumnDimension('U')->setWidth(5);
        $sheet->getColumnDimension('V')->setWidth(8);
        $sheet->getColumnDimension('W')->setWidth(22);
        $sheet->getColumnDimension('X')->setWidth(21);
        $sheet->getColumnDimension('Y')->setWidth(28);
        $sheet->getColumnDimension('Z')->setWidth(8);
        $sheet->getColumnDimension('AA')->setWidth(8);
        $sheet->getColumnDimension('AB')->setWidth(6);
        // header text
        $sheet
            ->setCellValue('A1', 'Jurnal Pengeluaran')
            ->setCellValue('B1', 'No')
            ->setCellValue('C1', 'Tanggal')
            ->setCellValue('D1', 'D')
            ->setCellValue('E1', 'M')
            ->setCellValue('F1', 'Y')
            ->setCellValue('G1', 'No Nota')
            ->setCellValue('H1', 'No Id')
            ->setCellValue('I1', 'Post Akun')
            ->setCellValue('J1', 'Post Center')
            ->setCellValue('K1', 'Keterangan')
            ->setCellValue('L1', 'Debit')
            ->setCellValue('M1', 'Kredit')
            ->setCellValue('N1', 'Admin')

            ->setCellValue('P1', 'Jurnal Pemasukan')
            ->setCellValue('Q1', 'No')
            ->setCellValue('R1', 'Tanggal')
            ->setCellValue('S1', 'D')
            ->setCellValue('T1', 'M')
            ->setCellValue('U1', 'Y')
            ->setCellValue('V1', 'No Nota')
            ->setCellValue('W1', 'Post Akun')
            ->setCellValue('X1', 'Customer')
            ->setCellValue('Y1', 'Keterangan')
            ->setCellValue('Z1', 'Debit')
            ->setCellValue('AA1', 'Kredit')
            ->setCellValue('AB1', 'Admin');
        $kolom = 2;
        $i = 1;
        foreach ($jurnal as $k) {
            $sheet->setCellValue('B' . $kolom, $i++);
            $sheet->setCellValue('C' . $kolom, $k->tgl);
            $sheet->setCellValue('D' . $kolom, date('d', strtotime($k->tgl)));
            $sheet->setCellValue('E' . $kolom, date('m', strtotime($k->tgl)));
            $sheet->setCellValue('F' . $kolom, date('Y', strtotime($k->tgl)));
            $sheet->setCellValue('G' . $kolom, $k->no_nota);
            $sheet->setCellValue('H' . $kolom, $k->no_id);
            $sheet->setCellValue('I' . $kolom, $k->nm_akun);
            $sheet->setCellValue('J' . $kolom, $k->nm_post);
            $sheet->setCellValue('K' . $kolom, $k->ket);
            $sheet->setCellValue('L' . $kolom, $k->debit);
            $sheet->setCellValue('M' . $kolom, $k->kredit);
            $sheet->setCellValue('N' . $kolom, $k->admin);

            $kolom++;
        }

        $kolom2 = 2;
        $i = 1;
        foreach ($jurnal_pemasukan as $k) {
            $sheet->setCellValue('Q' . $kolom2, $i++);
            $sheet->setCellValue('R' . $kolom2, $k->tgl);
            $sheet->setCellValue('S' . $kolom2, date('d', strtotime($k->tgl)));
            $sheet->setCellValue('T' . $kolom2, date('m', strtotime($k->tgl)));
            $sheet->setCellValue('U' . $kolom2, date('Y', strtotime($k->tgl)));
            $sheet->setCellValue('V' . $kolom2, $k->no_nota);
            $sheet->setCellValue('W' . $kolom2, $k->nm_akun);
            $sheet->setCellValue('X' . $kolom2, $k->nm_post);
            $sheet->setCellValue('Y' . $kolom2, $k->ket);
            $sheet->setCellValue('Z' . $kolom2, $k->debit);
            $sheet->setCellValue('AA' . $kolom2, $k->kredit);
            $sheet->setCellValue('AB' . $kolom2, $k->admin);
            $kolom2++;
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

        $batas2 = $jurnal_pemasukan;
        $batas2 = count($batas2) + 1;

        $sheet->getStyle('B1:N1')->applyFromArray($style_header);
        $sheet->getStyle('B2:K' . $batas)->applyFromArray($style_huruf);
        $sheet->getStyle('N2:N' . $batas)->applyFromArray($style_huruf);
        $sheet->getStyle('L2:M' . $batas)->applyFromArray($style_number);


        $sheet->getStyle('Q1:AB1')->applyFromArray($style_header);
        $sheet->getStyle('Q2:Y' . $batas2)->applyFromArray($style_huruf);
        $sheet->getStyle('AB2:AB' . $batas2)->applyFromArray($style_huruf);
        $sheet->getStyle('Z2:AA' . $batas2)->applyFromArray($style_number);



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Export All.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
