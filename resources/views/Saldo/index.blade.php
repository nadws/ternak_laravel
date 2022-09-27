@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-10">
                @include('template.flash')
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-left">{{ $title }}</h5>
                        <a href="" class="btn btn-costume btn-sm float-right mr-1" data-target="#view_bulan"
                            data-toggle="modal"><i class="fas fa-sort-amount-up-alt"></i>
                            Filter
                        </a>
                        <a href="" data-toggle="modal" data-target="#atur_saldo"
                            class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-tasks"></i> Atur Saldo
                            Awal
                        </a>
                    </div>
                    <div class="card-body">
                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table dataTable no-footer" id="example2" role="grid"
                                        aria-describedby="table_warning">
                                        <thead>
                                            <tr role="row">
                                                <th>No</th>
                                                <th>Nama Akun</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                                <th>Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1;
                                            $total_debit = 0;
                                            $total_kredit = 0;
                                            $saldo_save = 0;
                                            @endphp
                                            @foreach ($kategori as $a)


                                            @php
                                            $saldo = DB::select("SELECT a.*,b.nm_akun FROM tb_neraca_saldo as a
                                            left join tb_akun as b on b.id_akun = a.id_akun where(a.tgl) ='$bulan' and
                                            YEAR(a.tgl) ='$tahun' and b.id_kategori = '$a->id_kategori'
                                            ");
                                            @endphp
                                            <tr>
                                                <td colspan="5">
                                                    <dt>{{ $a->nm_kategori }}</dt>
                                                </td>
                                            </tr>
                                            @foreach ($saldo as $s)

                                            @php
                                            $total_debit += $s->debit_saldo;
                                            $total_kredit += $s->kredit_saldo;
                                            $saldo_save += $s->debit_saldo - $s->kredit_saldo;
                                            @endphp
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$s->nm_akun }}</td>
                                                <td style="text-align: right;">{{ number_format($s->debit_saldo, 0)}}
                                                </td>
                                                <td style="text-align: right;">{{ number_format($s->kredit_saldo, 0)}}
                                                </td>
                                                <td style="text-align: right;">{{number_format($s->debit_saldo -
                                                    $s->kredit_saldo, 0)}}</td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th>Total</th>
                                            <th></th>
                                            <th style="text-align: right;">{{ number_format($total_debit, 0) }}</th>
                                            <th style="text-align: right;">{{ number_format($total_kredit, 0) }}</th>
                                            <th style="text-align: right;">{{ number_format($saldo_save, 0) }}</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<form action="" method="GET">
    <div class="modal fade" id="view_bulan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Neraca Saldo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Bulan</label>
                            <select name="month" id="" class="form-control select2bs4">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Tahun</label>
                            <select name="year" id="" class="form-control select2bs4">
                                <?php foreach ($s_tahun as $t) : ?>
                                <?php $tanggal = $t->tgl;
                                    $explodetgl = explode('-', $tanggal); ?>
                                <option value="<?= $explodetgl[0]; ?>">
                                    <?= $explodetgl[0]; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>


<style>
    .modal-lg-max {
        max-width: 1000px;
    }

    .scroll {
        overflow-x: auto;
        height: 450px;
        overflow-y: scroll;
    }
</style>
<form action="" method="GET">
    <div class="modal fade" id="atur_saldo" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Atur Neraca Saldo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 mb-2">
                            <label for="">Tanggal</label>
                            <input type="date" name="tgl" id="tgl_neraca" class="form-control" required>
                        </div>
                        <div class="scroll col-lg-12">
                            <table class="table mt-2" width='100%'>
                                <thead>
                                    <tr>
                                        <th width="3%">No</th>
                                        <th width="17%">No Akun</th>
                                        <th width="37%">Nama Akun</th>
                                        <th width="25%">Debit</th>
                                        <th width="25%">Kredit</th>
                                        <th width="25%">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach ($kategori as $a)
                                    @php
                                    $saldo = DB::select("SELECT * From tb_akun as a where a.id_kategori =
                                    '$a->id_kategori' order by a.no_akun ASC")
                                    @endphp
                                    <tr>
                                        <td colspan="6">
                                            <dt>{{ $a->nm_kategori }}</dt>
                                        </td>
                                    </tr>
                                    @foreach ($saldo as $s)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$s->no_akun}}</td>
                                        <td>{{$s->nm_akun}}</td>
                                        <td>Rp.0</td>
                                        <td>Rp.0</td>
                                        <td>Rp.0</td>
                                    </tr>
                                    @endforeach

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>



<!-- /.control-sidebar -->
@endsection