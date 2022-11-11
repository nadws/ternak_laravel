<?php
$file = "Export Laporan Bulanan.xls";
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$file");
?>
<table border="1" class="table table-sm table-bordered someclass">
    <thead>
        <tr>
            <th width="14%" class="top">Akun</th>
            @foreach ($tahun as $t)
            <th class="top">
                {{date('M-Y', strtotime($t->tgl))}}
            </th>
            @endforeach
            <th class="top">Total</th>
        </tr>
        <tr>
            <td class="top_bawah">
                <dt>
                    Pemasukan
                </dt>
            </td>
            @php
            $ttl_penj = 0;
            @endphp
            @foreach ($tahun as $t)
            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));

            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where MONTH(a.tgl)
            = '$bulan'
            and a.id_buku ='1'
            and YEAR(a.tgl) = '$year'");
            $ttl_penj += $ttl_pen->kredit;
            @endphp
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_pen->kredit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_penj,0)}}</dt>
            </td>
        </tr>
        @foreach ($akun_pendapatan as $a)
        <tr class="pendapatan">
            <td>{{$a->nm_akun}}</td>

            @php
            $total_pendapatan = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $pendapatan = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where a.id_akun = '$a->id_akun' and MONTH(a.tgl)
            = '$bulan'
            and a.id_buku ='1'
            and YEAR(a.tgl) = '$year' group by a.id_akun");
            $total_pendapatan += empty($pendapatan->kredit) ? '0' : $pendapatan->kredit;
            @endphp


            <td align="right">
                {{empty($pendapatan->kredit) ? '0' :number_format($pendapatan->kredit,0)}}
            </td>

            @endforeach

            <td align="right">
                <dt>{{number_format($total_pendapatan,0)}}</dt>
            </td>
        </tr>
        @endforeach
        <tr class="pendapatan">
            <td class="top_bawah">
                <dt>Total Penjualan</dt>
            </td>

            @php
            $ttl_penj = 0;
            @endphp
            @foreach ($tahun as $t)
            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));

            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where MONTH(a.tgl)
            = '$bulan'
            and a.id_buku ='1'
            and YEAR(a.tgl) = '$year'");
            $ttl_penj += $ttl_pen->kredit;
            @endphp
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_pen->kredit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_penj,0)}}</dt>
            </td>
        </tr>
        <tr>
            <td></td>
            @foreach ($tahun as $t)
            <td></td>
            @endforeach
            <td>
            </td>
        </tr>

        <tr>
            <td class="top_bawah">
                <dt>Total Pengeluaran</dt>
            </td>

            @php
            $ttl_biaya = 0;
            @endphp
            @foreach ($tahun as $t)
            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));

            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            c.id_kategori='5'");

            $ttl_biaya += $biaya->debit;

            @endphp
            <td class="top_bawah" align="right">
                <dt>{{number_format($biaya->debit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_biaya,0)}}</dt>
            </td>
        </tr>

        <tr>
            <td></td>
            @foreach ($tahun as $t)
            <td></td>
            @endforeach
            <td>
            </td>
        </tr>

        <tr>
            <td class="top_bawah">
                <dt>
                    Biaya disesuaikan
                </dt>
            </td>
            @php
            $ttl_biaya_dis = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $biaya_dis = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            b.id_relation_debit
            IS NOT null");
            $ttl_biaya_dis += empty($biaya_dis->debit) ? '0' : $biaya_dis->debit;
            @endphp

            <td class="top_bawah" align="right">
                <dt>{{ empty($biaya_dis->debit) ? '0' :
                    number_format($biaya_dis->debit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_biaya_dis,0)}}</dt>
            </td>
        </tr>
        @foreach ($akun_biaya_disesuaiakan as $a)
        <tr class="biaya_dis">
            <td>{{$a->nm_akun}}</td>

            @php
            $total_biaya =0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where a.id_akun = '$a->id_akun' and MONTH(a.tgl)
            = '$bulan'
            and YEAR(a.tgl) = '$year' group by a.id_akun");
            $total_biaya += empty($biaya->debit) ? '0' : $biaya->debit;
            @endphp

            <td align="right">{{empty($biaya->debit) ? '0' : number_format($biaya->debit,0)}}</td>
            @endforeach

            <td align="right">
                <dt>{{number_format($total_biaya,0)}}</dt>
            </td>
        </tr>
        @endforeach
        <tr class="biaya_dis">
            <td class="top_bawah">
                <dt>Total Biaya Disesuaiakan</dt>
            </td>
            @php
            $ttl_biaya_dis = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $biaya_dis = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            b.id_relation_debit
            IS NOT null");
            $ttl_biaya_dis += empty($biaya_dis->debit) ? '0' : $biaya_dis->debit;
            @endphp

            <td class="top_bawah" align="right">
                <dt>{{ empty($biaya_dis->debit) ? '0' :
                    number_format($biaya_dis->debit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_biaya_dis,0)}}</dt>
            </td>
        </tr>

        <tr>
            <td></td>
            @foreach ($tahun as $t)
            <td></td>
            @endforeach
            <td>
            </td>
        </tr>

        {{-- Biaya --}}

        <tr>
            <td class="top_bawah">
                <dt>
                    Biaya Utama
                </dt>
            </td>
            @php
            $ttl_biaya_u = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $biaya_u = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            b.id_relation_debit
            IS null AND c.id_kategori='5'");
            $ttl_biaya_u += empty($biaya_u->debit) ? '0' : $biaya_u->debit;
            @endphp

            <td class="top_bawah" align="right">
                <dt>{{ empty($biaya_u->debit) ? '0' :
                    number_format($biaya_u->debit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_biaya_u,0)}}</dt>
            </td>
        </tr>
        @foreach ($akun_biaya as $a)
        <tr class="biaya_utama">
            <td>{{$a->nm_akun}}</td>

            @php
            $total_biaya =0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where a.id_akun = '$a->id_akun' and MONTH(a.tgl)
            = '$bulan'
            and YEAR(a.tgl) = '$year' group by a.id_akun");
            $total_biaya += empty($biaya->debit) ? '0' : $biaya->debit;
            @endphp

            <td align="right">{{empty($biaya->debit) ? '0' : number_format($biaya->debit,0)}}</a></td>
            @endforeach

            <td align="right">
                <dt>{{number_format($total_biaya,0)}}</dt>
            </td>
        </tr>
        @endforeach
        <tr class="biaya_utama">
            <td class="top_bawah">
                <dt>Total Biaya Utama</dt>
            </td>
            @php
            $ttl_biaya_u = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));
            $biaya_u = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            b.id_relation_debit
            IS null AND c.id_kategori='5'");
            $ttl_biaya_u += empty($biaya_u->debit) ? '0' : $biaya_u->debit;
            @endphp

            <td class="top_bawah" align="right">
                <dt>{{ empty($biaya_u->debit) ? '0' :
                    number_format($biaya_u->debit,0)}}</dt>
            </td>
            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_biaya_u,0)}}</dt>
            </td>
        </tr>

        <tr>
            <td></td>
            @foreach ($tahun as $t)
            <td></td>
            @endforeach
            <td>
            </td>
        </tr>

        {{-- Laba Rugi --}}

        <tr>
            <td class="top_bawah">
                <dt>
                    Laba Rugi
                </dt>
            </td>
            @foreach ($tahun as $t)

            @php
            $tgl_akhir = date('Y-m-t',strtotime($t->tgl));

            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where a.id_buku ='1'
            and a.tgl between '2022-01-01' and '$tgl_akhir'");

            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where a.tgl between '2022-01-01' and '$tgl_akhir' AND
            c.id_kategori='5'");

            @endphp

            <td align="right" class="top_bawah">
                <dt>{{number_format($ttl_pen->kredit - $biaya->debit,0)}}</dt>
            </td>
            @endforeach
            <td align="right" class="top_bawah">
                <dt>0</dt>
            </td>
        </tr>
        <tr class="laba">
            <td style="white-space: nowrap">Laba bersih sebelum pajak</td>
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));

            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where MONTH(a.tgl)
            = '$bulan'
            and a.id_buku ='1'
            and YEAR(a.tgl) = '$year'");

            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            c.id_kategori='5'");

            @endphp

            <td align="right">
                {{number_format($ttl_pen->kredit - $biaya->debit,0)}}
            </td>
            @endforeach
            <td align="right">0</td>
        </tr>
        <tr class="laba">
            <td>PPH Terhutang(-)</td>
            @foreach ($tahun as $t)
            <td align="right">0</td>
            @endforeach
            <td align="right">0</td>
        </tr>
        <tr class="laba">
            <td>Laba bersih setelah pajak</td>
            @foreach ($tahun as $t)

            @php
            $bulan = date('m',strtotime($t->tgl));
            $year = date('Y',strtotime($t->tgl));

            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where MONTH(a.tgl)
            = '$bulan'
            and a.id_buku ='1'
            and YEAR(a.tgl) = '$year'");

            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' AND
            c.id_kategori='5'");
            @endphp

            <td align="right">
                {{number_format($ttl_pen->kredit - $biaya->debit,0)}}
            </td>
            @endforeach
            <td align="right">0</td>
        </tr>
        <tr class="laba">
            <td>Pendapatan Bank(+)</td>
            @foreach ($tahun as $t)
            <td align="right">0</td>
            @endforeach
            <td align="right">0</td>
        </tr>
        <tr class="laba">
            <td>Laba Ditahan</td>
            @foreach ($tahun as $t)

            @php
            $tgl_akhir = date('Y-m-t',strtotime($t->tgl));

            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where a.id_buku ='1'
            and a.tgl between '2022-01-01' and '$tgl_akhir'");

            $biaya = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit
            FROM tb_jurnal as a
            left join tb_akun as c on c.id_akun = a.id_akun
            LEFT JOIN tb_relasi_akun AS b ON b.id_relation_debit = a.id_akun
            where a.tgl between '2022-01-01' and '$tgl_akhir' AND
            c.id_kategori='5'");

            @endphp

            <td align="right">
                {{number_format($ttl_pen->kredit - $biaya->debit,0)}}
            </td>
            @endforeach
            <td align="right">0</td>
        </tr>
        <tr>
            <td></td>
            @foreach ($tahun as $t)
            <td></td>
            @endforeach
            <td>
            </td>
        </tr>
        {{-- Asset --}}

        <tr>
            <td class="top_bawah">
                <dt>
                    Asset
                </dt>
            </td>
            @php
            $ttl_assets1 = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $tgl_akhir = date('Y-m-t',strtotime($t->tgl));
            $ttl_asset = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a
            left join tb_akun as b on b.id_akun = a.id_akun
            where a.tgl between
            '2022-01-01' and '$tgl_akhir' and b.id_kategori='1' and b.id_penyesuaian !=0
            ");

            $ttl_assets1 += empty($ttl_asset->debit) ? '0' : $ttl_asset->debit -
            $ttl_asset->kredit;
            @endphp

            <td class="top_bawah" align="right">
                <dt>
                    {{ empty($ttl_asset->debit) ? '0' : number_format($ttl_asset->debit
                    - $ttl_asset->kredit,0)}}</dt>
            </td>

            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_assets1,0)}}</dt>
            </td>
        </tr>

        @foreach ($asset as $a)
        <tr class="asset">
            <td>{{$a->nm_akun}}</td>

            @php
            $total_asset =0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $tgl_akhir = date('Y-m-t',strtotime($t->tgl));
            $asset = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a where a.id_akun = '$a->id_akun' and a.tgl between
            '2022-01-01' and '$tgl_akhir'
            group by a.id_akun");

            $total_asset += empty($asset->debit) ? '0' : $asset->debit - $asset->kredit;
            @endphp

            <td align="right">{{empty($asset->debit) ? '0' :
                number_format($asset->debit - $asset->kredit,0)}}</td>
            @endforeach

            <td align="right">
                <dt>{{number_format($total_asset,0)}}</dt>
            </td>
        </tr>
        @endforeach

        <tr class="asset">
            <td class="top_bawah">
                <dt>Total Asset</dt>
            </td>
            @php
            $ttl_assets1 = 0;
            @endphp
            @foreach ($tahun as $t)

            @php
            $tgl_akhir = date('Y-m-t',strtotime($t->tgl));
            $ttl_asset = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
            kredit FROM tb_jurnal as a
            left join tb_akun as b on b.id_akun = a.id_akun
            where a.tgl between
            '2022-01-01' and '$tgl_akhir' and b.id_kategori='1' and b.id_penyesuaian !=0
            ");

            $ttl_assets1 += empty($ttl_asset->debit) ? '0' : $ttl_asset->debit -
            $ttl_asset->kredit;
            @endphp

            <td class="top_bawah" align="right">
                <dt>
                    {{ empty($ttl_asset->debit) ? '0' : number_format($ttl_asset->debit
                    - $ttl_asset->kredit,0)}}</dt>
            </td>

            @endforeach
            <td class="top_bawah" align="right">
                <dt>{{number_format($ttl_assets1,0)}}</dt>
            </td>
        </tr>

    </thead>
</table>