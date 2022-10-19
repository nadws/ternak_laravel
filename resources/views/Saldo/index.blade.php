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
                <form id="edit_saldo">
                    @csrf
                    <input type="hidden" class="bulan_edit" value="{{$bulan}}">
                    <input type="hidden" class="tahun_edit" value="{{$tahun}}">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left">{{ $title }} {{$bulan}}-{{$tahun}}</h5>
                            @foreach ($saldo as $s)
                            @php
                            $sldo = $s->id_akun;
                            @endphp
                            @endforeach
                            <a href="" class="btn btn-costume btn-sm float-right mr-1" data-target="#view_bulan"
                                data-toggle="modal"><i class="fas fa-sort-amount-up-alt"></i>
                                Filter
                            </a>
                            <a href="" data-toggle="modal" data-target="#atur_saldo"
                                class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-tasks"></i> Atur Saldo
                                Awal
                            </a>
                            @if (empty($sldo))
                            @else
                            <button type="submit" class="btn btn-sm float-right btn-costume mr-1"><i
                                    class="fas fa-save"></i> Edit
                                saldo</button>
                            @endif
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table dataTable no-footer" id="tb_bkin" role="grid"
                                        aria-describedby="table_warning">
                                        <thead>
                                            <tr role="row">
                                                <th width="5%">No</th>
                                                <th width="35%">Nama Akun</th>
                                                <th width="20%">Debit</th>
                                                <th width="20%">Kredit</th>
                                                <th width="20%">Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $l = 1;
                                            $total_debit = 0;
                                            $total_kredit = 0;
                                            $saldo_save = 0;
                                            @endphp
                                            @foreach ($saldo as $s)
                                            @php
                                            $total_debit += $s->debit;
                                            $total_kredit += $s->kredit;
                                            $saldo_save += $s->debit - $s->kredit;
                                            @endphp
                                            <tr>
                                                <td>{{$l++}}</td>
                                                <td>{{$s->nm_akun }}</td>
                                                <td>
                                                    <input type="hidden" name="id_jurnal[]" value="{{$s->id_jurnal}}">

                                                    <input style="text-align: right;" name="debit[]" type="number"
                                                        class="form-control e_debit e_debit{{$s->id_jurnal}}"
                                                        id_jurnal="{{$s->id_jurnal}}" value="{{$s->debit}}">
                                                </td>
                                                <td><input style="text-align: right;" name="kredit[]" type="number"
                                                        class="form-control e_kredit e_kredit{{$s->id_jurnal}}"
                                                        value="{{ $s->kredit}}" id_jurnal="{{$s->id_jurnal}}">
                                                </td>
                                                <td style="text-align: right;">{{number_format($saldo_save, 0)}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-costume">
                                            <tr>
                                                <th>Total</th>
                                                <th></th>
                                                <th style="text-align: right;">
                                                    <p class="e_ttl_debit">Rp. {{number_format($total_debit, 0) }}</p>
                                                    <input type="hidden" class="total_debit_edit"
                                                        value="{{$total_debit}}">
                                                </th>
                                                <th style="text-align: right;">
                                                    <p class="e_ttl_kredit">Rp. {{number_format($total_kredit, 0) }}</p>
                                                    <input type="hidden" class="e_ttl_kredit_input"
                                                        value="{{$total_kredit}}">
                                                </th>
                                                <th style="text-align: right;">
                                                    <p class="e_ttl_saldo">Rp. {{number_format($saldo_save, 0) }}</p>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
<form id="tambah_saldo">
    @csrf
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
                        <div class="col-lg-12">
                            <h2 class="text-danger" id="testing"></h2>
                        </div>
                        <div class=" col-lg-12">
                            <div class="scroll">


                                <table class="table mt-2" width='100%'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Akun</th>
                                            <th>Nama Akun</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach ($saldo2 as $s)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$s->no_akun}}</td>
                                            <td>{{$s->nm_akun}}</td>
                                            <td style="text-align: right;">
                                                <input type="hidden" name="id_akun[]" value="{{$s->id_akun}}">
                                                <input type="number" name="debit[]" style="text-align: right;"
                                                    class="form-control debit_input debit_form_input{{$s->id_akun }}"
                                                    id_akun="{{$s->id_akun }}" value="0" autofocus>
                                            </td>
                                            <td style="text-align: right;">
                                                <input type="number" name="kredit[]" style="text-align: right;"
                                                    class="form-control kredit_input kredit_form_input{{$s->id_akun }}"
                                                    id_akun="{{$s->id_akun }}" value="0" autofocus>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-costume">
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th style="text-align: right;"><input type="hidden" value="0"
                                                    class="total_debit">
                                                <p class="text_debit"></p>
                                            </th>
                                            <th style="text-align: right;"><input type="hidden" value="0"
                                                    class="total_kredit">
                                                <p class="text_kredit"></p>
                                            </th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-costume btn-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">
        <div class="modal-content ">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Saldo Awal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Silahkan konfirmasi untuk menerbitkan saldo awal dengan kondisi di bawah ini:</h5>
                <br>
                <p>
                    Total debit dan kredit harus sama. Total selisih berjumlah <span class="selisih text-danger"></span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- /.control-sidebar -->
@endsection
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() { 

        $("input[type='number']").on("click", function () {
            $(this).select();
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
        $(document).on('keyup', '.e_debit', function() {
            var id_jurnal = $(this).attr('id_jurnal');

            var debit = $(".e_debit" + id_jurnal).val();

            var total = 0;
            $(".e_debit:not([disabled=disabled]").each(function() {
                total += parseFloat($(this).val());
            });
            $('.total_debit_edit').val(total)

            var number_total = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var rupiah_total = "Rp. " + number_total;
            $('.e_ttl_debit').text(rupiah_total);

            // saldo
            var ttl_kredit = $('.e_ttl_kredit_input').val();
            var ttl_debit = $('.total_debit_edit').val();
        
            
            var saldo = ttl_debit - ttl_kredit;
            var number_saldo = saldo.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var rupiah_saldo = "Rp. " + number_saldo;
            $('.e_ttl_saldo').text(rupiah_saldo);

        });
        $(document).on('keyup', '.kredit_input', function() {
            var id_akun = $(this).attr('id_akun');

            var debit = $(".kredit_form_input" + id_akun).val();

            var debit2 = parseFloat(debit);
            

            var number = debit2.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

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

        $(document).on('keyup', '.e_kredit', function() {
            var id_jurnal = $(this).attr('id_jurnal');

            var kredit = $(".e_kredit" + id_jurnal).val();

            var total = 0;
            $(".e_kredit:not([disabled=disabled]").each(function() {
                total += parseFloat($(this).val());
            });
            $('.e_ttl_kredit_input').val(total)

            var number_total = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var rupiah_total = "Rp. " + number_total;
            $('.e_ttl_kredit').text(rupiah_total);

            // saldo
            var ttl_kredit = $('.e_ttl_kredit_input').val();
            var ttl_debit = $('.total_debit_edit').val();
        
            
            var saldo = ttl_debit - ttl_kredit;
           
            var number_saldo = saldo.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var rupiah_saldo = "Rp. " + number_saldo;
            $('.e_ttl_saldo').text(rupiah_saldo);

        });

        $(document).on('submit', '#tambah_saldo', function(event) {
            event.preventDefault();

            var debit = $(".total_debit").val();
            var kredit = $(".total_kredit").val();
            var total = parseFloat(debit) - parseFloat(kredit);
            if (debit == kredit) {
                $.ajax({
                    url: "{{route('save_saldo')}}",
                    type: 'post',
                    dataType: 'application/json',
                    data: $("#tambah_saldo").serialize(),
                    success: function(data) {
                    }
                });
                window.location = "{{route('saldo')}}";
            } else {
                var number_total = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                var rupiah_total = "Rp. " + number_total;
                $('.selisih').text(rupiah_total);
                $('#myModal').modal('show')
            }
        });
        $(document).on('submit', '#edit_saldo', function(event) {
            event.preventDefault();

            var debit = $(".total_debit_edit").val();
            var kredit = $(".e_ttl_kredit_input").val();
            var bulan = $('.bulan_edit').val();
            var tahun = $('.tahun_edit').val();
            var total = parseFloat(debit) - parseFloat(kredit);
            // alert(bulan);
            
            if (debit == kredit) {
                $.ajax({
                    url: "{{route('edit_saldo')}}",
                    type: 'post',
                    dataType: 'application/json',
                    data: $("#edit_saldo").serialize(),
                    success: function(data) {
                    }
                });
                window.location = "{{route('saldo')}}?month="+bulan+"&year="+tahun;
            } else {
                var number_total = total.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                var rupiah_total = "Rp. " + number_total;
                $('.selisih').text(rupiah_total);
                $('#myModal').modal('show')
            
            }
        });
        

        $(document).on('change', '#tgl_neraca', function() {
            var tgl_neraca = $(this).val();

            const d = new Date(tgl_neraca);
            let month = d.getMonth();
            let year = d.getFullYear();

            var bulan = month + 1
            var tahun = year

            // alert(bulan);

            $.ajax({
                url: "{{route('get_penutup')}}",
                type: "GET",
                data: {
                    bulan: bulan,
                    tahun: tahun
                },
                // dataType: "json",
                success: function(data) {
                    $('#testing').text(data);
                    if (data != '') {
                        $('.scroll').hide();
                        $('.btn-save').attr('disabled', 'true');
                    } else {
                        $('.scroll').show();
                        $('.btn-save').removeAttr('disabled', 'true');
                    }
                }

            });
        });

        // kredit saldo

        
        
        
    });
</script>