@extends('template.master')
@section('content')

<style>
    .scroll {
        overflow-x: auto;
        height: auto;
        overflow-y: scroll;
    }

    .top {
        color: white;
        white-space: nowrap;
        background-color: #629779;
        position: sticky;
        top: 0;
        left: 0;
        z-index: 1030;
    }

    .top_bawah {
        color: white;
        white-space: nowrap;
        background-color: #ACD5C3;
        position: sticky;
        left: 0;
        z-index: 1020;
    }

    .input-kecil {
        height: 30px;
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">{{$title}}</h5>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <a href="#" data-toggle="modal" data-target="#view"
                                class="btn btn-costume btn-sm float-right ml-2"><i class="fas fa-search"></i>
                                View</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-9"></div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder="search....">
                                </div>
                            </div>
                            <div class="scroll">
                                <table class="table table-sm table-bordered someclass" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th width="25%" class="top">Akun</th>
                                            @foreach ($tahun2 as $t)
                                            <th class="top">
                                                {{date('M-Y', strtotime($t->tgl))}}
                                            </th>
                                            @endforeach
                                            <th class="top" width="20%">
                                                Bugeting
                                            </th>
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
                                                    <button
                                                        class="btn float-right btn-costume btn-muncul-pendapatan btn-xs show_biaya_p">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <button
                                                        class="btn float-right btn-costume btn-hide-pendapatan btn-xs show_biaya_p">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                </dt>
                                            </td>
                                            @php
                                            $ttl_penj_s = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));

                                            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
                                            kredit FROM tb_jurnal as a where MONTH(a.tgl)
                                            = '$bulan'
                                            and a.id_buku ='1'
                                            and YEAR(a.tgl) = '$year'");
                                            $ttl_penj_s += $ttl_pen->kredit;
                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($ttl_pen->kredit,0)}}</dt>
                                            </td>
                                            @endforeach
                                            <td class="top_bawah" align="right">

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
                                                <dt>{{number_format($ttl_penj + $ttl_penj_s,0)}}</dt>
                                            </td>
                                        </tr>
                                        @foreach ($akun_pendapatan as $a)
                                        <tr class="pendapatan">
                                            <td>{{$a->nm_akun}}</td>

                                            @php
                                            $total_pendapatan2 = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)

                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));
                                            $pendapatan = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
                                            kredit FROM tb_jurnal as a where a.id_akun = '$a->id_akun' and MONTH(a.tgl)
                                            = '$bulan'
                                            and a.id_buku ='1'
                                            and YEAR(a.tgl) = '$year' group by a.id_akun");
                                            $total_pendapatan2 += empty($pendapatan->kredit) ? '0' :
                                            $pendapatan->kredit;
                                            @endphp


                                            <td align="right">
                                                <a href="" data-toggle="modal" data-target="#detail_jurnal"
                                                    class="view_jurnal" id_akun="{{$a->id_akun}}" bulan="{{$bulan}}"
                                                    tahun="{{$year}}">
                                                    {{empty($pendapatan->kredit) ? '0'
                                                    :number_format($pendapatan->kredit,0)}}
                                                </a>
                                            </td>

                                            @endforeach
                                            <td align="right"></td>


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


                                            <td align="right"> <a href="" data-toggle="modal"
                                                    data-target="#detail_jurnal" class="view_jurnal"
                                                    id_akun="{{$a->id_akun}}" bulan="{{$bulan}}" tahun="{{$year}}">
                                                    {{empty($pendapatan->kredit) ? '0'
                                                    :number_format($pendapatan->kredit,0)}}</a>
                                            </td>

                                            @endforeach

                                            <td align="right">
                                                <dt>{{number_format($total_pendapatan + $total_pendapatan2,0)}}</dt>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="pendapatan">
                                            <td class="top_bawah">
                                                <dt>Total Penjualan</dt>
                                            </td>

                                            @php
                                            $ttl_penj2 = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));

                                            $ttl_pen = DB::selectOne("SELECT sum(a.debit) as debit, sum(a.kredit) as
                                            kredit FROM tb_jurnal as a where MONTH(a.tgl)
                                            = '$bulan'
                                            and a.id_buku ='1'
                                            and YEAR(a.tgl) = '$year'");
                                            $ttl_penj2 += $ttl_pen->kredit;
                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($ttl_pen->kredit,0)}}</dt>
                                            </td>
                                            @endforeach
                                            <td class="top_bawah" align="right"></td>
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
                                                <dt>{{number_format($ttl_penj + $ttl_penj2,0)}}</dt>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @foreach ($tahun2 as $t)
                                            <td></td>
                                            @endforeach
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
                                                    Uang Keluar
                                                    <button
                                                        class="btn float-right btn-costume btn-muncul-disesuaikan btn-xs show_biaya_p">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <button
                                                        class="btn float-right btn-costume btn-hide-disesuaikan btn-xs show_biaya_p">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                </dt>
                                            </td>


                                            @php
                                            $ttl_biaya2 = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
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

                                            $ttl_biaya2 += $biaya->debit;

                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($biaya->debit,0)}}</dt>
                                            </td>
                                            @endforeach
                                            <td class="top_bawah" align="right"></td>
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
                                                <dt>{{number_format($ttl_biaya + $ttl_biaya2,0)}}</dt>
                                            </td>

                                        </tr>


                                        @foreach ($uang_keluar as $u)
                                        <tr class="biaya_dis">
                                            <td>{{$u->nm_akun}}</td>
                                            @php
                                            $ttl_biaya_dis = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));
                                            $biaya_dis = DB::selectOne("SELECT a.id_akun, b.nm_akun, SUM(a.debit) AS
                                            debit, SUM(a.kredit) AS kredit, c.id_penyesuaian
                                            FROM tb_jurnal AS a
                                            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
                                            LEFT JOIN tb_akun AS c ON c.id_akun = a.id_akun_kredit
                                            WHERE a.id_buku = '3' AND c.id_kategori = '1' AND c.id_penyesuaian = '0' and
                                            MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' and a.id_akun =
                                            '$u->id_akun'
                                            GROUP BY a.id_akun");
                                            $ttl_biaya_dis += empty($biaya_dis->debit) ? '0' : $biaya_dis->debit;
                                            @endphp

                                            <td align="right">
                                                <a href="" data-toggle="modal" data-target="#detail_jurnal"
                                                    class="view_jurnal" id_akun="{{$u->id_akun}}" bulan="{{$bulan}}"
                                                    tahun="{{$year}}">
                                                    {{ empty($biaya_dis->debit) ? '0' :
                                                    number_format($biaya_dis->debit,0)}}



                                                </a>

                                            </td>
                                            @endforeach
                                            <td align="right">
                                                <input type="text" class="form-control input-kecil text-right"
                                                    value="0">
                                            </td>

                                            @php
                                            $ttl_biaya_dis2 = 0;
                                            @endphp
                                            @foreach ($tahun as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));
                                            $biaya_dis = DB::selectOne("SELECT a.id_akun, b.nm_akun, SUM(a.debit) AS
                                            debit, SUM(a.kredit) AS kredit, c.id_penyesuaian
                                            FROM tb_jurnal AS a
                                            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
                                            LEFT JOIN tb_akun AS c ON c.id_akun = a.id_akun_kredit
                                            WHERE a.id_buku = '3' AND c.id_kategori = '1' AND c.id_penyesuaian = '0' and
                                            MONTH(a.tgl) = '$bulan' and YEAR(a.tgl) = '$year' and a.id_akun =
                                            '$u->id_akun'
                                            GROUP BY a.id_akun");
                                            $ttl_biaya_dis2 += empty($biaya_dis->debit) ? '0' : $biaya_dis->debit;
                                            @endphp

                                            <td align="right">
                                                <a href="" data-toggle="modal" data-target="#detail_jurnal"
                                                    class="view_jurnal" id_akun="{{$u->id_akun}}" bulan="{{$bulan}}"
                                                    tahun="{{$year}}">
                                                    {{ empty($biaya_dis->debit) ? '0' :
                                                    number_format($biaya_dis->debit,0)}}
                                                </a>
                                            </td>
                                            @endforeach

                                            <td align="right">
                                                <dt>{{number_format($ttl_biaya_dis + $ttl_biaya_dis2,0)}}</dt>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="biaya_dis">
                                            <td class="top_bawah">
                                                <dt>Total Uang Keluar</dt>
                                            </td>
                                            @php
                                            $ttl_biaya2 = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
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

                                            $ttl_biaya2 += $biaya->debit;

                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($biaya->debit,0)}}</dt>
                                            </td>
                                            @endforeach
                                            <td class="top_bawah" align="right"></td>
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
                                                <dt>{{number_format($ttl_biaya + $ttl_biaya2,0)}}</dt>
                                            </td>
                                        </tr>

                                        {{-- liabilities --}}
                                        <tr>
                                            <td class="top_bawah">
                                                <dt>
                                                    Liabilities (credit side)
                                                    <button
                                                        class="btn float-right btn-costume btn-muncul-utama btn-xs show_biaya_p">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                    <button
                                                        class="btn float-right btn-costume btn-hide-utama btn-xs show_biaya_p">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                </dt>
                                            </td>


                                            @php
                                            $ttl_liabilities = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));

                                            $biaya = DB::selectOne("SELECT a.id_akun, b.nm_akun, SUM(a.debit) AS debit,
                                            SUM(a.kredit) AS kredit
                                            FROM tb_jurnal AS a
                                            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
                                            WHERE b.id_kategori ='1' AND b.id_penyesuaian = '0' AND a.id_buku = '3'
                                            AND MONTH(a.tgl) = '$bulan' AND YEAR(a.tgl) = '$year'
                                            GROUP BY a.id_akun");

                                            $ttl_liabilities += $biaya->kredit;

                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($biaya->kredit,0)}}</dt>
                                            </td>
                                            @endforeach

                                            <td class="top_bawah" align="right"></td>

                                            @php
                                            $ttl_liabilities2 = 0;
                                            @endphp
                                            @foreach ($tahun as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));

                                            $biaya = DB::selectOne("SELECT a.id_akun, b.nm_akun, SUM(a.debit) AS debit,
                                            SUM(a.kredit) AS kredit
                                            FROM tb_jurnal AS a
                                            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
                                            WHERE b.id_kategori ='1' AND b.id_penyesuaian = '0' AND a.id_buku = '3'
                                            AND MONTH(a.tgl) = '$bulan' AND YEAR(a.tgl) = '$year'
                                            GROUP BY a.id_akun");

                                            $ttl_liabilities2 += $biaya->kredit;

                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($biaya->kredit,0)}}</dt>
                                            </td>

                                            @endforeach
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($ttl_liabilities + $ttl_liabilities2,0)}}</dt>
                                            </td>

                                        </tr>


                                        @foreach ($liabilities as $u)
                                        <tr class="biaya_utama">
                                            <td>{{$u->nm_akun}}</td>
                                            @php
                                            $ttl_liabilities = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));
                                            $biaya_liabilities = DB::selectOne("SELECT a.id_akun, b.nm_akun,
                                            SUM(a.debit) AS
                                            debit, SUM(a.kredit) AS kredit
                                            FROM tb_jurnal AS a
                                            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
                                            WHERE b.id_kategori ='1' AND b.id_penyesuaian = '0' AND a.id_buku = '3'
                                            AND MONTH(a.tgl) = '$bulan' AND YEAR(a.tgl) = '$year' AND a.id_akun =
                                            '$u->id_akun'
                                            GROUP BY a.id_akun");
                                            $ttl_liabilities += empty($biaya_liabilities->kredit) ? '0' :
                                            $biaya_liabilities->kredit;
                                            @endphp

                                            <td align="right">
                                                <a href="" data-toggle="modal" data-target="#detail_jurnal"
                                                    class="view_jurnal" id_akun="{{$u->id_akun}}" bulan="{{$bulan}}"
                                                    tahun="{{$year}}">
                                                    {{ empty($biaya_liabilities->kredit) ? '0' :
                                                    number_format($biaya_liabilities->kredit,0)}}
                                                </a>
                                            </td>
                                            @endforeach
                                            <td align="right"></td>

                                            @php
                                            $ttl_liabilities2 = 0;
                                            @endphp
                                            @foreach ($tahun as $t)
                                            @php
                                            $bulan = date('m',strtotime($t->tgl));
                                            $year = date('Y',strtotime($t->tgl));
                                            $biaya_liabilities = DB::selectOne("SELECT a.id_akun, b.nm_akun,
                                            SUM(a.debit) AS
                                            debit, SUM(a.kredit) AS kredit
                                            FROM tb_jurnal AS a
                                            LEFT JOIN tb_akun AS b ON b.id_akun = a.id_akun
                                            WHERE b.id_kategori ='1' AND b.id_penyesuaian = '0' AND a.id_buku = '3'
                                            AND MONTH(a.tgl) = '$bulan' AND YEAR(a.tgl) = '$year' AND a.id_akun =
                                            '$u->id_akun'
                                            GROUP BY a.id_akun");
                                            $ttl_liabilities2 += empty($biaya_liabilities->kredit) ? '0' :
                                            $biaya_liabilities->kredit;
                                            @endphp

                                            <td align="right">
                                                <a href="" data-toggle="modal" data-target="#detail_jurnal"
                                                    class="view_jurnal" id_akun="{{$u->id_akun}}" bulan="{{$bulan}}"
                                                    tahun="{{$year}}">
                                                    {{ empty($biaya_liabilities->kredit) ? '0' :
                                                    number_format($biaya_liabilities->kredit,0)}}
                                                </a>
                                            </td>
                                            @endforeach

                                            <td align="right">
                                                <dt>{{number_format($ttl_liabilities + $ttl_liabilities2,0)}}</dt>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="biaya_utama">
                                            <td class="top_bawah">
                                                <dt>Total Liabilities</dt>
                                            </td>
                                            @php
                                            $ttl_biaya2 = 0;
                                            @endphp
                                            @foreach ($tahun2 as $t)
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

                                            $ttl_biaya2 += $biaya->debit;

                                            @endphp
                                            <td class="top_bawah" align="right">
                                                <dt>{{number_format($biaya->debit,0)}}</dt>
                                            </td>
                                            @endforeach
                                            <td class="top_bawah" align="right"></td>
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
                                                <dt>{{number_format($ttl_biaya + $ttl_biaya2,0)}}</dt>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-costume btn-sm float-right">
                                <i class="fas fa-save"></i> Save Budgetting
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<style>
    .modal-lg-max {
        max-width: 900px;
    }
</style>
<form action="" method="get">
    <div class="modal fade" id="view" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3 col-3">
                            <label for="">Bulan</label>
                            <select name="bulan1" id="" class="form-control select2">
                                <?php foreach ($s_bulan as $b) : ?>
                                <option value="0<?= $b->n_bulan ?>">
                                    <?= $b->bulan ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-lg-2 col-2">
                            <label for="">Tahun</label>
                            <select name="tahun1" id="" class="form-control select2">
                                <?php foreach ($s_tahun as $t) : ?>
                                <?php $tanggal = $t->tgl;
                                    $explodetgl = explode('-', $tanggal); ?>
                                <option value="<?= $explodetgl[0]; ?>">
                                    <?= $explodetgl[0]; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <br>
                            <center>
                                <h2>
                                    <dt>~</dt>
                                </h2>
                            </center>
                        </div>
                        <div class="col-lg-3 col-3">
                            <label for="">Bulan</label>
                            <select name="bulan2" id="" class="form-control select2" readonly>
                                <?php foreach ($s_bulan as $b) : ?>
                                <option value="0<?= $b->n_bulan ?>" <?=$b->n_bulan == date('m') ? 'selected' : '' ?>>
                                    <?= $b->bulan ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-2">
                            <label for="">Tahun</label>
                            <select name="tahun2" id="" class="form-control select2">
                                <?php foreach ($s_tahun as $t) : ?>
                                <?php $tanggal = $t->tgl;
                                    $explodetgl = explode('-', $tanggal); ?>
                                <option value="<?= $explodetgl[0]; ?>" <?=$explodetgl[0]==date('Y') ? 'selected' : '' ?>
                                    >
                                    <?= $explodetgl[0]; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume ">View</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{route('e_all_home')}}" method="get">
    <div class="modal fade" id="range" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input type="date" class="form-control" name="tgl1">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" class="form-control" name="tgl2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume ">Export</button>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    .modal-lg-max2 {
        max-width: 1300px;
    }
</style>
<div class="modal fade" id="detail_jurnal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max2" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Detail Jurnal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detail"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<!-- /.control-sidebar -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/izitoast/dist/js/iziToast.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.pendapatan').hide();
        $('.btn-hide-pendapatan').hide();

        $(document).on('click','.btn-muncul-pendapatan',function(){
            $('.pendapatan').show();
            $('.btn-hide-pendapatan').show();
            $('.btn-muncul-pendapatan').hide();
        });
        $(document).on('click','.btn-hide-pendapatan',function(){
            $('.pendapatan').hide();
            $('.btn-hide-pendapatan').hide();
            $('.btn-muncul-pendapatan').show();
        });

        $('.biaya_dis').hide();
        $('.btn-hide-disesuaikan').hide();

        $(document).on('click','.btn-muncul-disesuaikan',function(){
            $('.biaya_dis').show();
            $('.btn-hide-disesuaikan').show();
            $('.btn-muncul-disesuaikan').hide();
        });
        $(document).on('click','.btn-hide-disesuaikan',function(){
            $('.biaya_dis').hide();
            $('.btn-hide-disesuaikan').hide();
            $('.btn-muncul-disesuaikan').show();
        });
        
        $('.biaya_utama').hide();
        $('.btn-hide-utama').hide();

        $(document).on('click','.btn-muncul-utama',function(){
            $('.biaya_utama').show();
            $('.btn-hide-utama').show();
            $('.btn-muncul-utama').hide();
        });
        $(document).on('click','.btn-hide-utama',function(){
            $('.biaya_utama').hide();
            $('.btn-hide-utama').hide();
            $('.btn-muncul-utama').show();
        });

        $('.laba').hide();
        $('.btn-hide-laba').hide();

        $(document).on('click','.btn-muncul-laba',function(){
            $('.laba').show();
            $('.btn-hide-laba').show();
            $('.btn-muncul-laba').hide();
        });
        $(document).on('click','.btn-hide-laba',function(){
            $('.laba').hide();
            $('.btn-hide-laba').hide();
            $('.btn-muncul-laba').show();
        });
        $('.asset').hide();
        $('.btn-hide-asset').hide();

        $(document).on('click','.btn-muncul-asset',function(){
            $('.asset').show();
            $('.btn-hide-asset').show();
            $('.btn-muncul-asset').hide();
        });
        $(document).on('click','.btn-hide-asset',function(){
            $('.asset').hide();
            $('.btn-hide-asset').hide();
            $('.btn-muncul-asset').show();
        });

        // view Jurnal

        $(document).on('click','.view_jurnal',function(){
            var id_akun = $(this).attr('id_akun');
            var bulan = $(this).attr('bulan');
            var tahun = $(this).attr('tahun');

            

            $.ajax({
                url: "{{route('view_jurnal_laporan_bulanan')}}",
                method: "Get",
                data: {
                    id_akun: id_akun,
                    bulan: bulan,
                    tahun: tahun
                },
                success: function(data) {
                    $('#detail').html(data);
                }
            });
        });
     });
</script>
@endsection