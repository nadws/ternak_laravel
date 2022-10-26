@extends('template.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Data {{ $title }}</h5>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-12">
                @include('template.flash')
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-left">Total Setor :
                        </h5>
                        <h5 class="ttl float-left ml-2"></h5>
                        <a href="" data-toggle="modal" data-target="#bayar"
                            class="btn btn-costume btn-sm float-right mr-1 " id="btn_pembayaran"><i
                                class="fas fa-plus"></i> Perencanaan
                        </a>
                        <a href="" data-toggle="modal" data-target="#list_perencanaan"
                            class="btn btn-costume btn-sm float-right mr-1 " id="list"><i class="fas fa-list"></i> List
                            Perencanaan
                        </a>
                        <a href="" data-toggle="modal" data-target="#list_setoran"
                            class="btn btn-costume btn-sm float-right mr-1 " id="list"><i
                                class="fas fa-file-invoice"></i> Data
                            Invoice
                        </a>
                    </div>
                    <div class="card-body">
                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table dataTable no-footer" id="tb_bkin" role="grid"
                                            aria-describedby="table_warning">
                                            <thead>
                                                <tr role="row" style="white-space: nowrap; ">
                                                    <th>#</th>
                                                    <th>Tanggal</th>
                                                    <th>No Nota</th>
                                                    <th>Customer</th>
                                                    <th>Pembayaran</th>
                                                    {{-- @foreach ($jenis as $j)
                                                    <th style="text-align: center">Kg Jual <br> ({{$j->jenis}})</th>
                                                    @endforeach --}}
                                                    <th style="text-align: right">Total </th>
                                                    <th style="text-align: center">Check</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i=1;
                                                @endphp
                                                @foreach ($setor as $s)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{date('d-m-Y',strtotime($s->tgl))}}</td>
                                                    <td>{{$s->no_nota}}</td>
                                                    <td>{{$s->nm_post}} {{$s->urutan}}</td>
                                                    <td>{{$s->nm_akun}}</td>
                                                    {{-- @foreach ($jenis as $j)
                                                    @php
                                                    $kg =
                                                    DB::table('invoice_telur')->where([['no_nota',$s->nota_telur],['id_jenis_telur',$j->id]])->first();
                                                    @endphp
                                                    <td style="text-align: right">{{empty($kg->kg_jual) ? '0' :
                                                        $kg->kg_jual}}</td>
                                                    @endforeach --}}
                                                    <td style="text-align: right">{{number_format($s->debit,0)}}</td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="no_nota" class="total"
                                                            nota_ayam="<?= $s->no_nota ?>" value="<?= $s->debit ?>">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

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


<style>
    .modal-lg-max {
        max-width: 1200px;
    }
</style>

<form action="{{route('save_perencanaan_pupuk')}}" method="post">
    @csrf
    <div class="modal fade" id="bayar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Penyetoran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="input_pembayaran">

                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="list_perencanaan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">List Perencanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="perencanaan">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="list_setoran" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">List Setoran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="History">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Dari</label>
                            <input type="date" id="tgl1" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Sampai</label>
                            <input type="date" id="tgl2" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <label for="">Aksi</label> <br>
                            <button type="submit" class="btn btn-sm btn-costume">search</button>
                        </div>
                    </div>
                </form>
                <div id="list_penyetoran">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail_invoice" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Detail cfm setor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detail_list_setoran">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>

<form action="{{route('save_jurnal_setoran_pupuk')}}" method="post">
    @csrf
    <div class="modal fade" id="view_list" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Detail List Perencanaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detail_perencanaan">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>







<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>


<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('input:checkbox').change(function() {
            var total = $(this).val();

            var rupiah = 0;
            $('input[name="no_nota"]:checked').each(function() {
                rupiah += parseInt($(this).val());
            });
            var ttl = rupiah.toLocaleString();
            $('.ttl').text(ttl);
        });
        $(document).on('click', '#btn_pembayaran', function() {
                var no_nota = [];
                $('input[name="no_nota"]:checked').each(function() {
                    no_nota.push($(this).attr("nota_ayam"))
                });
                $.ajax({
                    url: "{{route('rencana_pupuk')}}",
                    method: "GET",
                    data: {
                        no_nota: no_nota
                    },
                    success: function(data) {
                        
                        $('#input_pembayaran').html(data);
                        $('.select').select2()
                    }
                });
                

        });
        $(document).on('click', '#list', function() {
                $.ajax({
                    url: "{{route('list_perencanaan_pupuk')}}",
                    method: "GET",
                    success: function(data) {
                        $('#perencanaan').html(data);
                        $('.select').select2()
                    }
                });
                

        });
        $(document).on('click', '.view_list', function() {
            var nota = $(this).attr('nota');
                $.ajax({
                    url: "{{route('detail_list_perencanaan_pupuk')}}",
                    data: {
                        nota : nota
                    },
                    method: "GET",
                    success: function(data) {
                        $('#detail_perencanaan').html(data);
                    }
                });
                

        });

        $(document).on('submit', '#History', function(e) {
            e.preventDefault();
            var tgl1 = $("#tgl1").val();
            var tgl2 = $("#tgl2").val();
            console.log(tgl1);
            console.log(tgl2);
            var url = "{{route('data_invoice_setoran_pupuk')}}?tgl1=" + tgl1 + "&tgl2=" + tgl2;
            $('#list_penyetoran').load(url);
            
        });

        $(document).on('click','.detail_nota', function() {
            var nota = $(this).attr('nota');
            var url = "{{route('detail_set_pupuk')}}?nota=" + nota;
            $('#detail_list_setoran').load(url);
            
           
        });

    });
</script>





<!-- /.control-sidebar -->
@endsection