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

    .form-control1 {
        display: block;
        width: 100%;
        height: calc(2.25rem + -9px);
        padding: .375rem .75rem;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
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
                        <div class=" col-lg-12">
                            <table class="table mt-2 " id="tb_bkin" width='100%'>
                                <thead>
                                    <tr>
                                        <th width="3%">No</th>
                                        <th width="17%">No Akun</th>
                                        <th width="37%">Nama Akun</th>
                                        <th width="25%">Debit</th>
                                        <th width="25%">Kredit</th>
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
                                        <td colspan="6" style="background-color: #F2F2F2">
                                            <dt>{{ $a->nm_kategori }}</dt>
                                        </td>
                                    </tr>
                                    @foreach ($saldo as $s)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$s->no_akun}}</td>
                                        <td>{{$s->nm_akun}}</td>
                                        <td style="text-align: right;">
                                            <p class="debit debit_akun{{$s->id_akun }}" id_akun="{{$s->id_akun }}">
                                                Rp.0
                                            </p>
                                            <input type="number" name="debit[]" style="text-align: right;"
                                                class="form-control1 debit_input debit_form_input{{$s->id_akun }}"
                                                id_akun="{{$s->id_akun }}" value="0" autofocus>
                                        </td>
                                        <td style="text-align: right;">
                                            <p class="kredit kredit_akun{{$s->id_akun }}" id_akun="{{$s->id_akun }}">
                                                Rp.0
                                            </p>
                                            <input type="number" name="kredit[]" style="text-align: right;"
                                                class="form-control1 kredit_input kredit_form_input{{$s->id_akun }}"
                                                id_akun="{{$s->id_akun }}" value="0" autofocus>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @endforeach
                                </tbody>
                                <tfoot class="bg-costume">
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right;"><input type="hidden" value="0" class="total_debit">
                                        <p class="text_debit"></p>
                                    </th>
                                    <th style="text-align: right;"><input type="hidden" value="0" class="total_kredit">
                                        <p class="text_kredit"></p>
                                    </th>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>



<!-- /.control-sidebar -->
@endsection
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        hide_input();

        function hide_input() {
            $(".debit_input").hide();
            $(".kredit_input").hide();
            // alert(id_distribusi);

        }
        $(document).on('click', '.debit', function() {
            var id_akun = $(this).attr('id_akun');
            $(".debit_akun" + id_akun).hide();
            $(".debit_form_input" + id_akun).show();
            $(".debit_form_input" + id_akun).focus();
            $(".debit_form_input" + id_akun).select();
            // $('.debit_hasil' + id_akun).val(debit);
        });

        $(document).on('click', '.debit_input', function() {
            var id_akun = $(this).attr('id_akun');
            $(".debit_form_input" + id_akun).hide();
            $(".debit_akun" + id_akun).show();
            var debit = $(".debit_akun" + id_akun).val();
            // $('.debit_hasil' + id_akun).val(debit);
        });
        $(document).on('keyup', '.debit_input', function() {
            var id_akun = $(this).attr('id_akun');

            var debit = $(".debit_form_input" + id_akun).val();

            var debit2 = parseFloat(debit);

            var number = debit2.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

            var rupiah = "Rp. " + number;
            $(".debit_akun" + id_akun).text(rupiah);


            var total = 0;
            $(".debit_input:not([disabled=disabled]").each(function() {
                total += parseFloat($(this).val());
            });
            $('.total_debit').val(total);
            var number_total = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var rupiah_total = "Rp. " + number_total;
            $('.text_debit').text(rupiah_total);

        });

        // kredit saldo

        $(document).on('click', '.kredit', function() {
            var id_akun = $(this).attr('id_akun');
            $(".kredit_akun" + id_akun).hide();
            $(".kredit_form_input" + id_akun).show();
            $(".kredit_form_input" + id_akun).focus();
            $(".kredit_form_input" + id_akun).select();
            $(".debit_form_input" + id_akun).hide();
            $(".debit_akun" + id_akun).show();
            var debit = $(".debit_akun" + id_akun).val();
            // $('.debit_hasil' + id_akun).val(debit);
        });
        $(document).on('click', '.kredit_input', function() {
            var id_akun = $(this).attr('id_akun');
            $(".kredit_form_input" + id_akun).hide();
            $(".kredit_akun" + id_akun).show();
        });

        $(document).on('keyup', '.kredit_input', function() {
            var id_akun = $(this).attr('id_akun');

            var kredit = $(".kredit_form_input" + id_akun).val();

            var kredit2 = parseFloat(kredit);

            var number = kredit2.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

            var rupiah = "Rp. " + number;
            $(".kredit_akun" + id_akun).text(rupiah);

            var total = 0;
            $(".kredit_input:not([disabled=disabled]").each(function() {
                total += parseFloat($(this).val());
            });
            $('.total_kredit').val(total);

            var number_total = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var rupiah_total = "Rp. " + number_total;
            $('.text_kredit').text(rupiah_total);
        });
    });
</script>