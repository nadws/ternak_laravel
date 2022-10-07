@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">{{ $title }}</h5>
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
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ route('edit_kg') }}" method="post">
                            @csrf
                            <div class="card-body hitung_kg">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tgl" class="form-control"
                                            value="{{ date('Y-m-d',strtotime($nota2->tgl)) }}" required>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Costumer</label>
                                        <input type="hidden" value="{{$nota2->no_nota}}" name="no_nota">
                                        <input type="hidden" value="{{$nota2->id_post}}" name="id_post2">
                                        <input type="hidden" value="{{$nota2->urutan}}" name="urutan">
                                        <select name="id_post" id="costumer" class="form-control select" required>
                                            <option value="">--Pilih Costumer--</option>
                                            @foreach ($costumer as $c)
                                            <option value="{{ $c->id_post }}" {{$nota2->id_post == $c->id_post ?
                                                'selected' : ''}}>{{ $c->nm_post }}</option>
                                            @endforeach
                                            <option value="Tambah">+ Customer</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Driver</label>
                                        <input type="text" name="driver" class="form-control" value="{{$nota2->driver}}"
                                            required>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table" style="white-space: nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Nama barang</th>
                                                    <th>Pcs</th>
                                                    <th>Kg</th>
                                                    <th>Ikat</th>
                                                    <th>Kg -(rak)</th>
                                                    <th>Rp/Kg</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $total = 0;
                                                @endphp
                                                @foreach ($nota as $j)
                                                <tr>
                                                    <td>{{ $j->jenis }}</td>
                                                    <input type="hidden" name="id_telur[]"
                                                        value="{{$j->id_invoice_telur}}">
                                                    <td><input type="text" name="pcs[]"
                                                            class="form-control pcs pcs_kg{{ $j->id_jenis_telur }}"
                                                            id_jenis="{{ $j->id_jenis_telur }}" value="{{$j->pcs}}"
                                                            style="text-align: right">
                                                    </td>
                                                    <td><input type="text" name="kg[]"
                                                            class="form-control kg kg{{ $j->id_jenis_telur }}"
                                                            id_jenis="{{ $j->id_jenis_telur }}" value="{{$j->kg}}"
                                                            style="text-align: right">
                                                    </td>
                                                    <td><input type="text"
                                                            class="form-control ikat{{ $j->id_jenis_telur }}"
                                                            value="{{$j->pcs / 180}}" style="text-align: right"
                                                            readonly></td>

                                                    <td><input name="kg_jual[]" type="text"
                                                            class="form-control  kg_rak{{ $j->id_jenis_telur }}"
                                                            value="{{ $j->kg - ($j->pcs/180) }}"
                                                            style="text-align: right" readonly></td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control rupiah rupiah{{ $j->id_jenis_telur }}"
                                                            value="{{ $j->rupiah }}" style="text-align: right"
                                                            name="rupiah[]" id_jenis="{{ $j->id_jenis_telur }}">

                                                        <input type="hidden"
                                                            class="form-control hasil hasil{{ $j->id_jenis_telur }}"
                                                            value="{{ $j->rupiah * ($j->kg - ($j->pcs/180)) }}"
                                                            style="text-align: right" name="rp_kg[]">

                                                        <input type="hidden" name="id_jenis_telur[]"
                                                            value="{{$j->id_jenis_telur}}">
                                                    </td>
                                                </tr>
                                                @php
                                                $total += $j->rupiah * ($j->kg - ($j->pcs/180));
                                                @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4"></th>
                                                    <th style="text-align: right;vertical-align: middle">Total:</th>
                                                    <th>
                                                        <input type="text" class="form-control total" value="{{$total}}"
                                                            style="text-align: right" readonly>
                                                    </th>
                                                </tr>


                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer hitung_kg">
                                <button type="submit" class="btn float-right btn-costume"><i class="fas fa-save"></i>
                                    Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<form method="post" action="{{route('tb_post')}}">
    @csrf
    <div class="modal fade tbh_post" id="tbh_post" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Nama Customer</label>
                            <input type="text" class="form-control" name="nm_post">
                        </div>
                        <div class="col-lg-4">
                            <label for="">No Telpon</label>
                            <input type="text" class="form-control" name="no_telpon">
                        </div>
                        <div class="col-lg-4">
                            <label for="">NPWP</label>
                            <input type="text" class="form-control" name="npwp">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume" action="">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
            hide_default();

            function hide_default() {
                $('.hitung_pcs').hide();
                $('.input_pcs').attr('disabled', 'true');
            }
            $(document).on('click', '.h_kg', function() {
                $('.hitung_kg').show();
                $('.hitung_pcs').hide();
                $('.input_kg').removeAttr('disabled', 'true');
                $('.input_pcs').attr('disabled', 'true');

            });
            $(document).on('click', '.h_pcs', function() {
                $('.hitung_kg').hide();
                $('.hitung_pcs').show();
                $('.input_pcs').removeAttr('disabled', 'true');
                $('.input_kg').attr('disabled', 'true');

            });

            $(document).on('keyup', '.pcs', function() {

                var id_jenis = $(this).attr('id_jenis');

                var pcs = $('.pcs_kg' + id_jenis).val();



                var ikat = parseFloat(pcs) / 180;
                $(".ikat" + id_jenis).val(ikat.toFixed(1));

                var kg = $('.kg' + id_jenis).val();
                var rupiah = $('.rupiah' + id_jenis).val();
                var kg_rak = parseFloat(kg) - parseFloat(ikat);

                var bayar = rupiah * kg_rak;
                $(".hasil" + id_jenis).val(bayar);

                var ttl_rp = 0;
                $(".hasil").each(function() {
                    ttl_rp += parseInt($(this).val());
                });


                $('.total').val(ttl_rp);


            });
            $(document).on('keyup', '.kg', function() {

                var id_jenis = $(this).attr('id_jenis');

                var kg = $('.kg' + id_jenis).val();
                var ikat = $('.ikat' + id_jenis).val();


                var rupiah = $('.rupiah' + id_jenis).val();
                var kg_rak = parseFloat(kg) - parseFloat(ikat);
                $(".kg_rak" + id_jenis).val(kg_rak.toFixed(1));

                var bayar = rupiah * kg_rak;

                $(".hasil" + id_jenis).val(bayar);



                var ttl_rp = 0;
                $(".hasil").each(function() {
                    ttl_rp += parseInt($(this).val());
                });


                $('.total').val(ttl_rp);


            });
            
            $(document).on('keyup', '.rupiah', function() {

                var id_jenis = $(this).attr('id_jenis');

                var kg_rak = $('.kg_rak' + id_jenis).val();

                var rupiah = $('.rupiah' + id_jenis).val();

                var bayar = parseInt(rupiah) * parseInt(kg_rak);

                $(".hasil" + id_jenis).val(bayar);

                var ttl_rp = 0;
                $(".hasil").each(function() {
                    ttl_rp += parseInt($(this).val());
                });


                $('.total').val(ttl_rp);


            });
            $(document).on('change', '#costumer', function() {

               var id_post = $(this).val();

              if (id_post == 'Tambah') {
                $('.tbh_post').modal('show')
              } else {
                  
              }


            });


        });
</script>
<!-- /.control-sidebar -->
@endsection