@extends('template.master')
@section('content')
<style>
    .bekecil {
        font-size: 18px;
    }

    .modal-lg-max {
        max-width: 1000px;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row pt-5 mb-3">
                <div class="col-lg-12">
                    <button class="btn btn-md btn-costume float-right" data-target="#view" data-toggle="modal"
                        type="button">View</button>
                </div>
            </div>
            {{-- stok masuk dan transafer martadah alpa --}}
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="bekecil">Stock Masuk Martadah {{ date('d-M-Y', strtotime($tgl)) }} (08:00 Am)
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('check_telur') }}" method="post">
                                @csrf

                                <table class="table table-bordered table-sm"
                                    style="font-size: 12px; white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;width:2%">Kandang</th>
                                            @foreach ($jenisTelur as $t)
                                            <th colspan="2" style="text-align: center;">{{ $t->jenis }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($jenisTelur as $j)
                                            <th>Pcs</th>
                                            <th>Kg</th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($telur as $t)
                                        @php
                                        $check = $t->check;
                                        @endphp
                                        <tr>
                                            <td>{{ $t->nm_kandang }}</td>
                                            <input type="hidden" name="id_telur[]" value="{{ $t->id_telur }}">
                                            <input type="hidden" name="cek" value="{{ $check == 'Y' ? 'T' : 'Y' }}">
                                            @foreach ($jenisTelur as $j)
                                            @php
                                            $skandang = DB::selectOne("SELECT SUM(a.pcs) as pcs, SUM(a.kg) as kg FROM
                                            `tb_telur` as a
                                            WHERE a.id_kandang = '$t->id_kandang' and a.id_jenis = '$j->id' AND a.tgl =
                                            '$tgl1' GROUP BY a.id_jenis,a.id_kandang");
                                            @endphp
                                            <td>{{ $skandang->pcs ?? 0 }}</td>
                                            <td>{{ $skandang->kg ?? 0 }}</td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td style="font-weight: bold;">Total</td>
                                        @foreach ($jenisTelur as $j)
                                        @php
                                        $tkandang = DB::selectOne("SELECT SUM(a.pcs) as pcs, SUM(a.kg) as kg FROM
                                        `tb_telur` as a
                                        WHERE a.id_jenis = '$j->id' AND a.tgl = '$tgl1' AND a.id_kandang != '' GROUP BY
                                        a.id_jenis");
                                        @endphp
                                        <td>{{ $tkandang->pcs ?? 0 }}</td>
                                        <td>{{ $tkandang->kg ?? 0 }}</td>
                                        @endforeach

                                    </tfoot>
                                </table>
                                <button class="btn btn-md btn-costume float-right mt-3" type="submit"><i
                                        class="far fa-{{ $check == 'Y' ? 'times' : 'check' }}-circle"></i> {{ $check ==
                                    'Y' ? 'Uncheck' : 'check' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="bekecil">Stock Transfer Alpa {{ date('d-M-Y', strtotime($tgl)) }} (08:00 Am)</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('check_telur') }}" method="post">
                                @csrf

                                <table class="table table-bordered table-sm table-responsive" style="font-size: 12px; ">
                                    <thead>
                                        <tr>
                                            @foreach ($jenisTelur as $j)
                                            <th colspan="4" style="text-align: center;">{{ ucwords($j->jenis) }}</th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <thead>
                                            <tr>
                                                @foreach ($jenisTelur as $j)
                                                <th>pcs</th>
                                                <th>Kg {{ $j->jenis == 'P' ? ' + rak' : '' }}</th>
                                                <th>Ikat</th>
                                                <th>Kg jual</th>
                                                @endforeach


                                            </tr>
                                        </thead>
                                    </tbody>
                                    <tr>
                                        @foreach ($jenisTelur as $j)
                                        @php
                                        $stock = DB::selectOne("SELECT a.id_penjualan,a.tgl,a.check,sum(a.kg) as kg,
                                        sum(a.pcs) as pcs
                                        FROM tb_penjualan_telur as a
                                        WHERE a.tgl = '$tgl1' AND a.id_jenis = '$j->id' GROUP BY a.tgl");
                                        $checkA = $stock->check;
                                        @endphp
                                        <input type="hidden" name="id_penjualan[]" value="{{ $stock->id_penjualan }}">
                                        <input type="hidden" name="cek_alpa" value="{{ $checkA == 'Y' ? 'T' : 'Y' }}">
                                        <td>{{ $stock->pcs ?? 0 }}</td>
                                        <td>{{ number_format($stock->kg ?? 0,1) }}</td>
                                        <td>{{ number_format($stock->pcs / 180 ?? 0,1) }}</td>
                                        <td>{{ number_format($stock->kg - ($stock->pcs / 180) ?? 0,1) }}</td>
                                        @endforeach

                                    </tr>
                                </table>
                                <button class="btn btn-md btn-costume float-right mt-3" type="submit"><i
                                        class="far fa-{{ $checkA == 'Y' ? 'times' : 'check' }}-circle"></i> {{ $checkA
                                    == 'Y' ? 'Uncheck' : 'check' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- pengecekan stok telur --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left">Pengecekan Stok telur</h5>
                            <a href="{{ route('add_telur') }}" class="btn btn-sm btn-costume float-right ml-2"><i
                                    class="fas fa-plus-circle"></i> Pemutihan Alpa</a>
                            <button type="button" data-target="#pemutihanTelur" data-toggle="modal"
                                class="btn btn-sm btn-costume float-right"><i class="fas fa-plus-circle"></i> Pemutihan
                                Martadah</button>
                        </div>
                        <div class="card-body">
                            <table width="100%" border="1" style="white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="background-color: #BDEED9; color: #787878; width:10%;">
                                        </th>
                                        @foreach ($jenisTelur as $j)
                                        <td style="background-color: #BDEED9; color: #787878; text-align:center;width:20%; font-weight: bold; font-family: Arial, Helvetica, sans-serif;"
                                            colspan="3"> {{ strtoupper($j->jenis) }}</td>
                                        <td rowspan="4" style="width: 0%;background-color: #BDEED9;"></td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        @foreach ($jenisTelur as $j)
                                        <td width="8%" style="background-color: #BDEED9; color: #787878; ">Pcs
                                        </td>
                                        <td width="8%" style="background-color: #BDEED9; color: #787878;">Kg
                                        </td>
                                        <td width="8%" style="background-color: #BDEED9; color: #787878;">Ikat
                                        </td>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                    <tr>
                                        <td style="color: #787878; font-weight: bold;">Stok Alpa</td>

                                        @foreach ($jenisTelur as $j)
                                        @php
                                        $stok = DB::selectOne("SELECT SUM(a.pcs) as pcs, SUM(a.kg) as kg FROM
                                        `invoice_telur` as a
                                        WHERE a.id_jenis_telur = '$j->id'");
                                        $sisa = DB::selectOne("SELECT SUM(a.pcs) as pcs, SUM(a.kg) as kg FROM
                                        `tb_penjualan_telur` as a
                                        WHERE a.check = 'T' AND a.id_jenis = '$j->id'");
                                        @endphp
                                        <td align="center">{{ $sisa->pcs - $stok->pcs ?? 0 }}</td>
                                        <td align="center">{{ number_format($sisa->kg - $stok->kg ?? 0, 1) }} </td>
                                        <td align="center">
                                            {{ number_format(empty($stok->pcs) ? 0 : ($sisa->pcs - $stok->pcs) / 180, 1)
                                            }}
                                        </td>
                                        <td rowspan="4" style="background-color: #BDEED9"></td>
                                        @endforeach
                                    </tr>
                                    <tr></tr>
                                    <tr>
                                        <td style="color: #787878;font-weight: bold;">Stok martadah</td>
                                        @foreach ($jenisTelur as $j)
                                        @php
                                        $sisa = DB::selectOne("SELECT SUM(a.pcs) as pcs, SUM(a.kg) as kg FROM
                                        `tb_penjualan_telur` as a
                                        WHERE a.check = 'T' AND a.id_jenis = '$j->id'");

                                        $stok3 = DB::selectOne("SELECT b.nm_kandang,b.id_kandang,SUM(a.pcs) as pcs,
                                        SUM(a.kg) as kg FROM `tb_telur` as a
                                        LEFT JOIN tb_kandang as b ON a.id_kandang = b.id_kandang
                                        WHERE a.check = 'T' AND a.id_jenis = '$j->id'");
                                        @endphp
                                        <td align="center">{{ $stok3->pcs - $sisa->pcs }}</td>
                                        <td align="center">{{ number_format($stok3->kg - $sisa->kg, 1) }}</td>
                                        <td align="center">{{ number_format(($stok3->pcs - $sisa->pcs) / 180, 1) }}
                                        </td>
                                        @endforeach

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- stok ayam solar rak telur --}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="bekecil">Stok Ayam {{ date('d-M-Y', strtotime($tgl)) }}</h5>
                        </div>
                        <div class="card-body">
                            <table width="100%" style="white-space: nowrap; text-align: center; ">
                                <tbody>
                                    <tr>
                                        <td align="center" style=" border-right: 1px solid black; font-weight: bold; "
                                            colspan="2">Culling</td>
                                        <td style=" border-right: 1px solid black; font-weight: bold;">MTD</td>
                                        <td align="center" style=" border-right: 1px solid black; font-weight: bold;"
                                            colspan="2">Transit</td>
                                        <td style=" border-right: 1px solid black; font-weight: bold;">Alpa</td>
                                    </tr>
                                    <tr>
                                        @php
                                        // dd($ayamCheck);
                                        // dd($ayam);
                                        foreach ($ayam as $ac) {
                                        $cek = $ac->check_mtd;
                                        }
                                        // dd($cek);
                                        @endphp

                                        <td width="12.5%">
                                            {{ $cek == 'Y' ? 0 : number_format($ayamPotong->culling, 0) }} Ekor
                                        </td>
                                        <td width="12.5%" style="border-right: 1px solid black;">
                                            <form action="{{ route('check_ayam_mtd') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="check" value="{{ $cek == 'Y' ? 'T' : 'Y' }}">
                                                @foreach ($ayam as $a)
                                                <input type="hidden" name="id_populasi" value="{{ $a->id_pop }}">
                                                <input type="hidden" name="tgl" value="{{ $tgl1 }}">
                                                @endforeach

                                                <button type="submit" class="btn btn-info  btn-sm"><i
                                                        class="fas fa-{{ $cek == 'Y' ? 'times' : 'check' }}-circle"></i>
                                                </button>

                                            </form>
                                        </td>
                                        <td width="25%" style="border-right: 1px solid black;">
                                            {{ number_format($stok_ayam_mtd->kirim_mtd - $stok_ayam_kirim->kirim, 0) }}
                                            Ekor</td>
                                        <td width="12.5%">
                                            {{ $ayam_mtd->check == 'Y' ? 0 : number_format($ayam_mtd->qty, 0) }} Ekor
                                        </td>
                                        <td width="12.5%" style="border-right: 1px solid black;">
                                            <form action="{{ route('check_ayam') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="check"
                                                    value="{{ $ayam_mtd->check == 'Y' ? 'T' : 'Y' }}">
                                                <input type="hidden" name="id_kirim_ayam"
                                                    value="{{ $ayam_mtd->id_kirim_ayam }}">
                                                @if (empty($ayam_mtd->check))
                                                @else
                                                <button type="submit" class="btn btn-info  btn-sm"><i
                                                        class="fas fa-{{ $ayam_mtd->check == 'Y' ? 'times' : 'check' }}-circle"></i>
                                                </button>
                                                @endif

                                            </form>
                                        </td>
                                        <td width="25%" style="border-right: 1px solid black;">
                                            @php
                                            $alert = $stok_ayam_kirim->kirim - $stok_ayam_penjualan->jual == '0' ? true
                                            : false;
                                            @endphp
                                            <a style="color: #787878; text-decoration: underline;"
                                                href="{{ $alert ? '#' : route('add_ayam') }}" @if ($alert)
                                                data-toggle="modal" data-target="#alert_stok_ayam" @endif>{{
                                                number_format($stok_ayam_kirim->kirim - $stok_ayam_penjualan->jual, 0)
                                                }}
                                                Ekor </a>
                                        </td>


                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center pt-4">
                                <button type="button" data-toggle="modal" data-target="#pemutihanAyamMtd"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i> Pemutihan
                                    Martadah</button>
                                <button type="button" data-toggle="modal" data-target="#pemutihanAyamAlpa"
                                    class="btn btn-sm btn-costume mr-2"><i class="fas fa-plus-circle"></i> Pemutihan
                                    Alpa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="bekecil">Stok Solar</h5>
                        </div>
                        <div class="card-body">
                            <table width="100%" style="white-space: nowrap;">
                                <tbody>
                                    <tr>
                                        <td class="card-title ">Stok total</td>
                                        <td style="text-align: right; font-weight: bold;" class="">
                                            {{ number_format($stokSolar->ttl, 1) }} Liter
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title ">&nbsp;</td>
                                        <td style="text-align: right; font-weight: bold;" class="">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center pt-4">
                                <button type="button" class="btn btn-costume dropdown-toggle  btn-sm"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus-circle"></i> Isi data
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#tambahSolar">Tambah Data</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#pemutihanSolar">Pemutihan</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#stokAwalSolar">Stock Awal</a>

                                </div>
                                <button type="button" data-toggle="modal" data-target="#viewSolar"
                                    class="btn btn-sm btn-costume mr-2"><i class="fas fa-eye"></i>
                                    View</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="bekecil">Stok Rak Telur</h5>
                        </div>
                        <div class="card-body">
                            <table width="100%" style="white-space: nowrap;">
                                <tbody>
                                    <tr>
                                        <td class="card-title ">Stok total</td>
                                        <td style="text-align: right; font-weight: bold;" class="">
                                            {{ number_format($stokRak->ttl, 1) }} Pcs
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="card-title ">&nbsp;</td>
                                        <td style="text-align: right; font-weight: bold;" class="">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center pt-4">
                                <button type="button" class="btn btn-costume dropdown-toggle  btn-sm"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-plus-circle"></i> Isi data
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#tambahRak">Tambah Data</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#pemutihanRak">Pemutihan</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#stokAwalRak">Stock Awal</a>

                                </div>
                                <button type="button" data-target="#viewRak" data-toggle="modal"
                                    class="btn btn-sm btn-costume mr-2"><i class="fas fa-eye"></i>
                                    View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- stok pakan obat vitamin --}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left bekecil">Stok Pakan</h5>
                            <div class="float-right mr-2">
                                <button type="button" data-toggle="modal" data-target="#tambahPakan"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i> Data</button>
                                <button type="button" data-toggle="modal" data-target="#pemutihanPakan"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i>
                                    Pemutihan</button>
                                <button type="button" data-toggle="modal" data-target="#stokAwalPakan"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i> Stok
                                    Awal</button>
                                <button type="button" data-toggle="modal" data-target="#viewPakan"
                                    class="btn btn-sm btn-costume"><i class="fas fa-eye"></i>
                                    View</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #BDEED9">
                                    <tr>
                                        <td>Nama Pakan</td>
                                        <td>Qty</td>
                                        <td>Satuan</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($hargaPakan as $s)
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#viewDetailPakan"
                                                id="detail-id-barang" detail-id-barang="{{ $s->id_barang }}">{{
                                                $s->nm_barang }}</a>
                                        </td>
                                        <td>{{ number_format($s->qty, 2) ?? 0 }}</td>
                                        <td>{{ $s->nm_satuan }}</td>
                                        <td>{{ number_format($s->debit, 0) }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left bekecil">Stok Obat dan Vitamin : 0</h5>
                            <div class="float-right mr-2">
                                <button type="button" data-toggle="modal" data-target="#tambahObatVitamin"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i> Data</button>
                                <button type="button" data-toggle="modal" data-target="#pemutihanObatVitamin"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i>
                                    Pemutihan</button>
                                <button type="button" data-toggle="modal" data-target="#stokAwalObatVitamin"
                                    class="btn btn-sm btn-costume"><i class="fas fa-plus-circle"></i> Stok
                                    Awal</button>
                                <button type="button" data-toggle="modal" data-target="#viewObatVitamin"
                                    class="btn btn-sm btn-costume"><i class="fas fa-eye"></i>
                                    View</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead style="background-color: #BDEED9">
                                    <tr>
                                        <td>Nama Obat</td>
                                        <td>Qty</td>
                                        <td>Satuan</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hargaObat as $s)
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#viewDetailObat"
                                                id="detail-id-barang-obat"
                                                detail-id-barang-obat="{{ $s->id_barang }}">{{ $s->nm_barang }}</a>
                                        </td>
                                        <td>{{ number_format($s->qty, 2) ?? 0 }}</td>
                                        <td>{{ $s->nm_satuan }}</td>
                                        <td>{{ number_format($s->debit, 0) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>

<div class="modal fade" id="alert_stok_ayam" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Stok Ayam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    Stok ayam saat ini <span class="text-danger">(0)</span> tidak bisa membuat nota
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal view --}}
<form action="" method="GET">
    <div class="modal fade" id="view" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">

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
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" class="form-control" name="tgl2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihanTelur --}}
<form action="{{ route('pemutihan_telur_mtd') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanTelur" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Telur Martadah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input required type="date" name="tgl" class="form-control">
                            </div>
                        </div>

                        @foreach ($jenisTelur as $j)
                        <input type="hidden" name="id_jenis[]" value="{{ $j->id }}">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pcs {{ $j->jenis }}</label>
                                <input type="text" value="0" class="form-control" name="pcs[]">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Kg {{ $j->jenis }}</label>
                                <input type="text" value="0" class="form-control" name="kg[]">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihan ayam matd --}}
<form action="{{ route('pemutihan_ayam_mtd') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanAyamMtd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Ayam Martadah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Stok culling</label>
                            <input required type="text" class="form-control" name="qty">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihan ayam alpa --}}
<form action="{{ route('pemutihan_ayam_alpa') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanAyamAlpa" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Ayam Alpa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Ekor</label>
                            <input type="text" class="form-control" name="qty">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal tambah data stok solar --}}
<form action="{{ route('add_stok_solar') }}" method="post">
    @csrf
    <div class="modal fade" id="tambahSolar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Solar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Qty</label>
                            <input type="text" class="form-control" name="qty">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Satuan</label>
                            <input type="text" readonly value="Liter" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Keterangan</label>
                            <input type="text" name="ket" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Akun</label>
                            <select name="akunTambahSolar" class="form-control select2" id="">
                                <option value="">- Pilih Post Akun -</option>
                                <option value="">Biaya Solar</option>
                                <option value="">Piutan Andri</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihan solar --}}
<form action="{{ route('pemutihan_stok_solar') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanSolar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <input type="hidden" name="jenis" value="pemutihan">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Solar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-4">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Qty</label>
                            <input type="text" class="form-control" name="qty">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Satuan</label>
                            <input type="text" readonly value="Liter" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal stok awal solar --}}
<form action="{{ route('pemutihan_stok_solar') }}" method="post">
    @csrf
    <div class="modal fade" id="stokAwalSolar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <input type="hidden" name="jenis" value="stok_awal">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Stok Awal Solar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-4">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Qty</label>
                            <input type="text" class="form-control" name="qty">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Satuan</label>
                            <input type="text" readonly value="Liter" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal view solar --}}
<div class="modal fade" id="viewSolar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">History Solar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="tgl1">
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" name="tgl2">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-sm btn-costume">View</button>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">

                        <div id="kontenViewSolar"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah data rak telur --}}
<form action="{{ route('add_rak_telur') }}" method="POST">
    @csrf
    <div class="modal fade" id="tambahRak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Rak Telur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Tujuan</label>
                            <input type="text" class="form-control" name="tujuan">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Qty <span style="font-size: 10px; color:red;">(dion= X50 / jordan =
                                    X70)</span></label>
                            <input type="text" name="qty" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="">Satuan</label>
                            <input type="text" value="Pcs" readonly class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Harga</label>
                            <input type="text" name="harga" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Post Center</label>
                            <select name="id_post_center" class="form-control select2" id="">
                                <option value="">- Pilih Post Center -</option>
                                @foreach ($post_center as $p)
                                <option value="{{ $p->id_post }}">{{ $p->nm_post }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihan rak telur --}}
<form action="{{ route('pemutihan_rak_telur') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanRak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Rak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-3">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Qty</label>
                            <input type="text" class="form-control" name="qty">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Satuan</label>
                            <input type="text" readonly value="Pcs" class="form-control">
                        </div>
                        <div class="col-lg-3">
                            <label for="">Harga Satuan</label>
                            <input type="text" readonly value="{{ $rakTelur->harga }}" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>


{{-- modal stok awal Rak --}}
<form action="{{ route('stok_awal_rak_telur') }}" method="post">
    @csrf
    <div class="modal fade" id="stokAwalRak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Stok Awal Rak telur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-4">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="tgl">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Qty</label>
                            <input type="text" class="form-control" name="qty">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Satuan</label>
                            <input type="text" readonly value="Pcs" class="form-control">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal view rak --}}
<div class="modal fade" id="viewRak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">History Rak Telur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl1-view-rak" name="tgl1">
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl2-view-rak" name="tgl2">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" id="btn-view-rak" class="btn btn-sm btn-costume">View</button>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">

                        <div id="kontenViewRak"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>


{{-- modal tambah stok pakan --}}
<form action="{{ route('save_jurnal_pv') }}" method="post">
    @csrf
    <div class="modal fade" id="tambahPakan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Tanggal</label>
                                <input class="form-control" type="date" name="tgl" id="tgl_peng"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mt-3 ml-1">
                            <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Akun</label>
                                <input type="hidden" readonly value="{{ $akunPakan->id_akun }}" name="id_akun">
                                <input class="form-control" type="text" readonly value="{{ $akunPakan->nm_akun }}">

                            </div>

                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="list_kategori">Debit</label>
                                <input type="number" class="form-control  total" name="debit" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="list_kategori">Kredit</label>
                                <input type="number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">

                        </div>

                        <div class="mt-1">
                            <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <select name="id_akun_kredit" class="form-control akun_kredit select2" required>
                                    <option value="">- Pilih Akun -</option>

                                    @foreach ($akun as $ak)
                                    <option value="{{ $ak->id_akun }}">{{ $ak->nm_akun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" class="form-control total " name="kredit" readonly>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">

                        </div>



                    </div>
                    <hr>
                    <input type="hidden" name="dashboard" value="dashboard">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">No id</label>
                                <input type="text" name="no_id[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tujuan</label>
                                <input type="text" name="tujuanPakan" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" name="keterangan[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pilih Pakan</label>
                                <div id="kontenPilihPakan1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Post Center</label>
                                <select name="id_postCenterPakan" id="" class="form-control select2">
                                    <option value="">- Pilih post center -</option>
                                    @foreach ($postCenter as $p)
                                    <option value="{{ $p->id_post }}">{{ $p->nm_post }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" name="qty[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input readonly type="hidden" id="id-satuan-pakan1" name="id_satuan[]"
                                    class="form-control">
                                <input readonly type="text" id="nm-satuan-pakan1" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Total Rp</label>
                                <input type="text" name="ttl_rp[]"
                                    class="form-control input_detail input_biaya total_rp">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label for="">Aksi</label>
                            <button type="button" class="btn btn-sm btn-costume" id="tbhPakan1">Tambah</button>
                        </div>
                    </div>

                    <div id="kontenTbhPakan"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihan stok pakan --}}
<form action="{{ route('save_pemutihan_pv') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanPakan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Stok Pakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="pemutihan" value="pemutihan">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" name="tgl" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pilih Pakan</label>
                                <select name="id_barang" class="form-control select2" id="">
                                    <option value="">- Pilih Pakan -</option>
                                    @foreach ($pakan as $p)
                                    <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" name="qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input type="text" readonly value="Kg" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal stok awal pakan --}}
<form action="{{ route('save_pemutihan_pv') }}" method="post">
    @csrf
    <div class="modal fade" id="stokAwalPakan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Stok Awal Pakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="stok_awal" value="stok_awal">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" name="tgl" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pilih Pakan</label>
                                <select name="id_barang" class="form-control select2" id="">
                                    <option value="">- Pilih Pakan -</option>
                                    @foreach ($pakan as $p)
                                    <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" name="qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input type="text" readonly value="Kg" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal view pakan --}}
<div class="modal fade" id="viewPakan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">History Pakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl1-view-pakan">
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl2-view-pakan">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" id="btn-view-pakan" class="btn btn-sm btn-costume">View</button>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">

                        <div id="kontenViewPakan"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>

{{-- modal view detail pakan --}}
<div class="modal fade" id="viewDetailPakan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">History Detail Pakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl1-detail-view-pakan">
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl2-detail-view-pakan">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" id="btn-detail-view-pakan" class="btn btn-sm btn-costume">View</button>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">

                        <div id="kontenDetailViewPakan"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah stok obat vitamin --}}
<form action="{{ route('save_jurnal_pv') }}" method="post">
    @csrf
    <div class="modal fade" id="tambahObatVitamin" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Obat Vitamin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Tanggal</label>
                                <input class="form-control" type="date" name="tgl" id="tgl_peng"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mt-3 ml-1">
                            <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Akun</label>
                                <input type="hidden" readonly value="{{ $akunObatVit->id_akun }}" name="id_akun">
                                <input class="form-control" type="text" readonly value="{{ $akunObatVit->nm_akun }}">

                            </div>

                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="list_kategori">Debit</label>
                                <input type="number" class="form-control  total-obat" name="debit" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="list_kategori">Kredit</label>
                                <input type="number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">

                        </div>

                        <div class="mt-1">
                            <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <select name="id_akun_kredit" class="form-control akun_kredit select2" required>
                                    <option value="">- Pilih Akun -</option>
                                    @foreach ($akun as $a)
                                    <option value="{{ $a->id_akun }}">{{ $a->nm_akun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" class="form-control total-obat" name="kredit" readonly>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">

                        </div>



                    </div>
                    <hr>
                    <input type="hidden" name="dashboard" value="dashboard">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">No id</label>
                                <input type="text" name="no_id[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tujuan</label>
                                <input type="text" name="tujuanPakan" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" name="keterangan[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pilih Obat & Vitamin</label>
                                <div id="kontenPilihObatVit1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Post Center</label>
                                <select name="id_postCenterPakan" id="" class="form-control select2">
                                    <option value="">- Pilih post center -</option>
                                    @foreach ($postCenter as $p)
                                    <option value="{{ $p->id_post }}">{{ $p->nm_post }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" name="qty[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input readonly type="hidden" id="id-satuan-obat1" name="id_satuan[]"
                                    class="form-control">
                                <input readonly type="text" id="nm-satuan-obat1" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Total Rp</label>
                                <input type="text" name="ttl_rp[]" class="form-control total-rp-obat">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label for="">Aksi</label>
                            <button type="button" class="btn btn-sm btn-costume" id="tbhObatVit1">Tambah</button>
                        </div>
                    </div>

                    <div id="kontenTbhObatVit"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal pemutihan stok obat dan vitamin --}}
<form action="{{ route('save_pemutihan_pv') }}" method="post">
    @csrf
    <div class="modal fade" id="pemutihanObatVitamin" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pemutihan Obat & Vitamin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="pemutihan" value="pemutihan">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" name="tgl" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pilih Obat Vitamin</label>
                                <select name="id_barang" class="form-control select2" id="selPemutihanObatVit">
                                    <option value="">- Pilih Obat & Vitamin -</option>
                                    @foreach ($obatVit as $p)
                                    <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" name="qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input id="satuanPemutihanObatVit" type="text" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal stok awal obat vitamin --}}
<form action="{{ route('save_pemutihan_pv') }}" method="post">
    @csrf
    <div class="modal fade" id="stokAwalObatVitamin" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Stok Awal Obat & Vitamin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="stok_awal" value="stok_awal">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" name="tgl" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Pilih Obat Vitamin</label>
                                <select name="id_barang" class="form-control select2" id="selStokAwalObatVit">
                                    <option value="">- Pilih Obat & Vitamin -</option>
                                    @foreach ($obatVit as $p)
                                    <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" name="qty" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Satuan</label>
                                <input id="satuanStokAwalObatVit" type="text" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- modal view stok obat vitamin --}}
<div class="modal fade" id="viewObatVitamin" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">History Obat & vitamin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl1-view-obat">
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl2-view-obat">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" id="btn-view-obat" class="btn btn-sm btn-costume">View</button>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">

                        <div id="kontenViewObatVit"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>

{{-- modal view detail obat --}}
<div class="modal fade" id="viewDetailObat" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">History Detail Obat & vitamin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl1-detail-view-obat">
                    </div>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="tgl2-detail-view-obat">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" id="btn-detail-view-obat" class="btn btn-sm btn-costume">View</button>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">

                        <div id="kontenDetailViewObat"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah pakan di modal --}}
<div class="modal fade" id="modal-tbh-pakan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Pakan</label>
                    <input type="text" id="tbh-nm-pakan" class="form-control">
                    <input type="hidden" id="tbh-id-jenis-pakan" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="tbh-button-pakan" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>

{{-- modal tambah obat vit di modal --}}
<div class="modal fade" id="modal-tbh-obat" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Obat & Vitamin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Nama Obat & vitamin</label>
                            <input type="text" id="tbh-nm-obat" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Jenis Obat</label>
                            <select id="tbh-id-jenis-obat" class="form-control select2" id="">
                                @foreach ($jenisObat as $o)
                                <option value="{{ $o->id_jenis }}">{{ $o->nm_jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="tbh-button-obat" class="btn btn-costume">Edit/Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
            var c = 1
            loadViewSolar()
            loadViewRak()
            loadViewPakan()
            loadViewObatVit()
            selPemutihanObatVit()
            selStokAwalObatVit()
            loadKontenPilihPakan(c)
            tbhPakan(c)
            loadKontenPilihObatVit(c)
            tbhObatVit(c)

            function loadToastSukses(pesan) {
                iziToast.success({
                    title: 'Success',
                    message: pesan,
                    position: 'topRight'
                });
            }

            function loadToastGagal(pesan) {
                iziToast.error({
                    title: 'Gagal',
                    message: pesan,
                    position: 'topRight'
                });
            }

            function loadKontenPilihPakan(c) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontenPilihPakan') }}",
                    success: function(r) {
                        $("#kontenPilihPakan" + c).html(r);
                        $(".select2").select2()
                    }
                });
            }

            function tbhPakan(c) {
                $(document).on('click', '#tbhPakan' + c, function() {
                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tbhPakan') }}",
                        data: {
                            c: c
                        },
                        success: function(r) {
                            $("#kontenTbhPakan").append(r)
                            $(".select2").select2()
                            loadKontenPilihPakan(c)
                        }
                    });
                })

                $(document).on('keyup', '.total_rp', function() {
                    var rupiah = parseFloat($(this).val());

                    var debit = 0;
                    $(".total_rp:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                    });
                    $('.total').val(debit);
                });

                $(document).on('click', '.removePakan', function() {
                    var delete_row = $(this).attr("count");
                    $('#row' + delete_row).remove();

                    var rupiah = parseFloat($('.total_rp').val());


                    var debit = 0;
                    $(".total_rp:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                    });
                    $('.total').val(debit);
                })

                $(document).on('change', '.pilihPakan', function() {
                    var v = $(this).val()
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get_satuan_pakan') }}?id_barang=" + v,
                        dataType: "json",
                        success: function(r) {
                            $("#id-satuan-pakan" + c).val(r.id_satuan);
                            $("#nm-satuan-pakan" + c).val(r.nm_satuan);
                        }
                    });

                    if (v == 'tbh') {
                        $('#modal-tbh-pakan').modal('toggle');
                    }

                })

                $(document).on('click', '#tbh-button-pakan', function() {
                    var nm_pakan = $("#tbh-nm-pakan").val();
                    var id_jenis = $("#tbh-id-jenis-pakan").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('modal_tbh_pakan') }}",
                        data: {
                            nm_barang: nm_pakan,
                            id_jenis: id_jenis
                        },
                        success: function(response) {
                            loadToastSukses('berhasil tambah pakan')
                            $('#modal-tbh-pakan').modal('hide');
                            loadKontenPilihPakan(c)
                        }
                    });

                })
            }

            function loadKontenPilihObatVit(c) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontenPilihObatVit') }}",
                    success: function(r) {
                        $("#kontenPilihObatVit" + c).html(r);
                        $(".select2").select2()
                    }
                });


            }

            function tbhObatVit(c) {
                $(document).on('click', '#tbhObatVit' + c, function() {
                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tbhObatVit') }}",
                        data: {
                            c: c
                        },
                        success: function(r) {
                            $("#kontenTbhObatVit").append(r)
                            $(".select2").select2()
                            loadKontenPilihObatVit(c)
                        }
                    });
                })

                $(document).on('keyup', '.total-rp-obat', function() {
                    var rupiah = parseFloat($(this).val());

                    var debit = 0;
                    $(".total-rp-obat:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                    });
                    $('.total-obat').val(debit);
                });

                $(document).on('click', '.removeObatVit', function() {
                    var delete_row = $(this).attr("count");
                    $('#row' + delete_row).remove();

                    var rupiah = parseFloat($('.total-rp-obat').val());


                    var debit = 0;
                    $(".total-rp-obat:not([disabled=disabled]").each(function() {
                        debit += parseFloat($(this).val());
                    });
                    $('.total-obat').val(debit);
                })

                $(document).on('change', '.pilihObatVit', function() {
                    var v = $(this).val()
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get_satuan_pakan') }}?id_barang=" + v,
                        dataType: "json",
                        success: function(r) {
                            $("#id-satuan-obat" + c).val(r.id_satuan);
                            $("#nm-satuan-obat" + c).val(r.nm_satuan);
                        }
                    });
                    if (v == 'tbh') {
                        $('#modal-tbh-obat').modal('toggle');
                    }
                })

                $(document).on('click', '#tbh-button-obat', function() {
                    var nm_pakan = $("#tbh-nm-obat").val();
                    var id_jenis = $("#tbh-id-jenis-obat").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('modal_tbh_pakan') }}",
                        data: {
                            nm_barang: nm_pakan,
                            id_jenis: id_jenis
                        },
                        success: function(response) {
                            loadToastSukses('berhasil tambah obat & vitamin')
                            $('#modal-tbh-obat').modal('hide');
                            loadKontenPilihObatVit(c)
                        }
                    });

                })
            }

            function loadViewSolar() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontenViewSolar') }}",
                    success: function(r) {
                        $("#kontenViewSolar").html(r);
                        $("#tblViewSolar").DataTable();
                    }
                });
            }

            function loadViewPakan() {
                $(document).on('click', '#detail-id-barang,#btn-detail-view-pakan', function() {

                    var id_barang = $(this).attr('detail-id-barang');
                    var tgl1 = $("#tgl1-detail-view-pakan").val();
                    var tgl2 = $("#tgl2-detail-view-pakan").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('kontenViewPakan') }}",
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                            id_barang: id_barang
                        },
                        success: function(r) {
                            $("#kontenDetailViewPakan").html(r);
                            $("#tblViewPakan").DataTable();
                        }
                    });
                })

                $(document).on('click', '#btn-view-pakan', function() {
                    var tgl1 = $("#tgl1-view-pakan").val();
                    var tgl2 = $("#tgl2-view-pakan").val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kontenViewPakan') }}",
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                        },
                        success: function(r) {
                            $("#kontenViewPakan").html(r);
                            $("#tblViewPakan").DataTable();
                        }
                    });
                })
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontenViewPakan') }}",
                    success: function(r) {
                        $("#kontenViewPakan").html(r);
                        $("#tblViewPakan").DataTable();
                    }
                });
            }

            function loadViewObatVit() {
                $(document).on('click', '#detail-id-barang-obat,#btn-detail-view-obat', function() {

                    var id_barang = $(this).attr('detail-id-barang-obat');
                    var tgl1 = $("#tgl1-detail-view-obat").val();
                    var tgl2 = $("#tgl2-detail-view-obat").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('kontenViewObatVit') }}",
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                            id_barang: id_barang
                        },
                        success: function(r) {
                            $("#kontenDetailViewObat").html(r);
                            $("#tblViewPakan").DataTable();
                        }
                    });
                })

                $(document).on('click', '#btn-view-obat', function() {
                    var tgl1 = $("#tgl1-view-obat").val();
                    var tgl2 = $("#tgl2-view-obat").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('kontenViewObatVit') }}",
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                        },
                        success: function(r) {
                            $("#kontenViewObatVit").html(r);
                            $("#tblViewObatVit").DataTable();
                        }
                    });
                })
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontenViewObatVit') }}",
                    success: function(r) {
                        $("#kontenViewObatVit").html(r);
                        $("#tblViewObatVit").DataTable();
                    }
                });
            }

            function loadViewRak() {
                $(document).on('click', '#btn-view-rak', function() {
                    var tgl1 = $("#tgl1-view-rak").val();
                    var tgl2 = $("#tgl2-view-rak").val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('kontenViewRak') }}",
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                        },
                        success: function(r) {
                            $("#kontenViewRak").html(r);
                            $("#tblViewRak").DataTable();
                        }
                    });
                })
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontenViewRak') }}",
                    success: function(r) {
                        $("#kontenViewRak").html(r);
                        $("#tblViewRak").DataTable();
                    }
                });
            }

            function selPemutihanObatVit() {
                $(document).on('change', '#selPemutihanObatVit', function() {
                    var id_barang = $(this).val()
                    $.ajax({
                        type: "GET",
                        url: "{{ route('selPemutihanObatVit') }}",
                        data: {
                            id_barang: id_barang
                        },
                        success: function(r) {
                            $("#satuanPemutihanObatVit").val(r);
                        }
                    });
                })
            }

            function selStokAwalObatVit() {
                $(document).on('change', '#selStokAwalObatVit', function() {
                    var id_barang = $(this).val()
                    $.ajax({
                        type: "GET",
                        url: "{{ route('selStokAwalObatVit') }}",
                        data: {
                            id_barang: id_barang
                        },
                        success: function(r) {
                            $("#satuanStokAwalObatVit").val(r);
                        }
                    });
                })
            }

        });
</script>
@endsection