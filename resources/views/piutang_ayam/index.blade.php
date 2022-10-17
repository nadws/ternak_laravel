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
                        <a href="" data-toggle="modal" data-target="#bayar"
                            class="btn btn-costume btn-sm float-right mr-1 " id="btn_pembayaran"><i
                                class="fas fa-check-square"></i> Bayar
                        </a>

                    </div>
                    <div class="card-body">
                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table dataTable no-footer" id="example2" role="grid"
                                            aria-describedby="table_warning">
                                            <thead>
                                                <tr role="row" style="white-space: nowrap">
                                                    <th>#</th>
                                                    <th>Tanggal</th>
                                                    <th>No Nota</th>
                                                    <th>Customer</th>
                                                    <th>Total </th>
                                                    <th>Admin</th>
                                                    <th style="text-align: center">Check</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no = 1;
                                                @endphp
                                                @foreach ($piutang as $p)
                                                @if ($p->debit - $p->kredit < 1) @php continue; @endphp @else @endif
                                                    <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td style="white-space: nowrap">
                                                        {{ date('d-m-Y', strtotime($p->tgl)) }}</td>
                                                    <td>{{ $p->no_nota }}</td>
                                                    <td>{{ $p->nm_post }} {{ $p->urutan }}</td>
                                                    <td>{{ number_format($p->debit - $p->kredit , 0) }}</td>
                                                    <td>{{ $p->admin }}</td>
                                                    <td style="text-align: center"><input type="checkbox" name="no_nota"
                                                            id="" value="{{ $p->no_nota }}"></td>
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
        max-width: 1000px;
    }
</style>
<form method="post" action="{{route('save_piutang_t')}}">
    @csrf
    <div class="modal fade" id="bayar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Pelunasan Piutang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="input_pembayaran">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn_bayar" class="btn btn-costume" disabled action="">Edit/Save</button>
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
            // Aktiva

            $(document).on('click', '#btn_pembayaran', function() {
                var no_nota = [];
                $('input[name="no_nota"]:checked').each(function() {
                    no_nota.push($(this).attr("value"))
                });
                console.log(no_nota);
                $.ajax({
                    url: "{{route('bayar_telur')}}",
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
            $(document).on('keyup', '.byr', function() {

                var ttl_rp = 0;
                $(".byr").each(function() {
                    ttl_rp += parseInt($(this).val());
                });

                var ttl_akhir = $('.ttl_akhir').val();

                var number = parseInt(ttl_rp).toLocaleString()

                $('.total').text(number); 
                $('.total2').val(ttl_rp);

                var sisa = ttl_rp - ttl_akhir;
             

                $('.sisa').val(sisa);
                if (sisa < 1) {
                    $('#btn_bayar').removeAttr('disabled');
                    // alert('tes')
                } else {
                    // alert('tes1')
                    $('#btn_bayar').attr('disabled', 'true');
                }

            });
            $(document).on('keyup', '.debit', function() {

                var ttl_rp = 0;
                $(".debit").each(function() {
                    ttl_rp += parseInt($(this).val());
                });
                var kredit = 0;
                $(".kredit").each(function() {
                    kredit += parseInt($(this).val());
                });
                var total =  parseInt($('.total2').val());

                var ttl_akhir = ttl_rp - kredit;
                $('.ttl_akhir').val(ttl_akhir);

                var sisa = (total + kredit) - ttl_rp;
             

                $('.sisa').val(sisa);

                if (sisa < 1) {
                    $('#btn_bayar').removeAttr('disabled');
                    // alert('tes')
                } else {
                    // alert('tes1')
                    $('#btn_bayar').attr('disabled', 'true');
                }

            });
            $(document).on('keyup', '.kredit', function() {

                var ttl_rp = 0;
                $(".debit").each(function() {
                    ttl_rp += parseInt($(this).val());
                });
                var kredit = 0;
                $(".kredit").each(function() {
                    kredit += parseInt($(this).val());
                });
                var total =  parseInt($('.total2').val());

                var ttl_akhir = ttl_rp - kredit;
                $('.ttl_akhir').val(ttl_akhir);
            

                var sisa = (total + kredit) - ttl_rp ;
             

                $('.sisa').val(sisa);

                if (sisa < 1) {
                    $('#btn_bayar').removeAttr('disabled');
                    // alert('tes')
                } else {
                    // alert('tes1')
                    $('#btn_bayar').attr('disabled', 'true');
                }

            });

            var count = 1;
            $(document).on('click', '#tambah_pembayaran', function() {
                count = count + 1;
                $.ajax({
                        url: "{{ route('tambah_piutang') }}?count=" + count ,
                        type: "Get",
                        success: function(data) {
                            $('#tambah').append(data);
                            $('.select').select2()
                    }
                }); 
                
            });
            $(document).on('click', '.remove', function() {
                var delete_row = $(this).attr('count');
                $('#row' + delete_row).remove();

                var ttl_rp = 0;
                $(".debit").each(function() {
                    ttl_rp += parseInt($(this).val());
                });
                var kredit = 0;
                $(".kredit").each(function() {
                    kredit += parseInt($(this).val());
                });
                var total =  parseInt($('.total2').val());

                var ttl_akhir = ttl_rp - kredit;
                $('.ttl_akhir').val(ttl_akhir);
            

                var sisa = (total + kredit) - ttl_rp ;
             

                $('.sisa').val(sisa);
                
            });
    });
</script>



<!-- /.control-sidebar -->
@endsection