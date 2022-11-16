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
                <div class="col-lg-6">
                    <div class="card">
                        <form action="{{ route('save_pupuk') }}" method="post">
                            @csrf
                            <div class="card-body hitung_kg">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tgl" class="form-control" value="{{ date('Y-m-d') }}"
                                            required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Costumer</label>
                                        <select name="id_post" id="costumer" class="form-control select" required>
                                            <option value="">--Pilih Costumer--</option>
                                            @foreach ($costumer as $c)
                                            <option value="{{ $c->id_post }}">{{ $c->nm_post }}</option>
                                            @endforeach
                                            <option value="Tambah">+ Customer</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table " style="white-space: nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="25%">Full</th>
                                                    <th width="25%">Harga Full</th>
                                                    <th width="25%">Setengah</th>
                                                    <th width="25%">Harga Setengah</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td><input type="text" name="full" class="form-control full"
                                                            value="0"></td>
                                                    <td>
                                                        <input type="text" name="h_full" class="form-control h_full"
                                                            value="0" required>
                                                        <input type="hidden" name="ttl" class="form-control ttl1"
                                                            required>
                                                    </td>
                                                    <td><input type="text" name="setengah" value="0"
                                                            class="form-control setengah">
                                                    </td>
                                                    <td><input type="text" name="h_setengah" value="0"
                                                            class="form-control h_setengah" required>
                                                    </td>

                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th style="text-align: right;vertical-align: middle">Total:</th>
                                                    <th>
                                                        <input type="text" class="form-control total" value="0"
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
                            <input type="hidden" value="20" class="form-control" name="id_akun">
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
        

            $(document).on('keyup', '.full', function() {


                var full = $('.full').val();
                var h_full = $('.h_full').val();
                var setengah = $('.setengah').val();
                var h_setengah = $('.h_setengah').val();

                var hitung= (parseInt(full) * parseInt(h_full)) + (parseInt(setengah) * parseInt(h_setengah));
                var ttl = $('.ttl1').val(hitung);

                var ttl_rp = 0;
                $(".ttl1").each(function() {
                    ttl_rp += parseInt($(this).val());
                });

                $('.total').val(ttl_rp)

            });
            $(document).on('keyup', '.h_full', function() {
                var full = $('.full').val();
                var h_full = $('.h_full').val();
                var setengah = $('.setengah').val();
                var h_setengah = $('.h_setengah').val();

                var hitung= (parseInt(full) * parseInt(h_full)) + (parseInt(setengah) * parseInt(h_setengah));
                var ttl = $('.ttl1').val(hitung);

                var ttl_rp = 0;
                $(".ttl1").each(function() {
                    ttl_rp += parseInt($(this).val());
                });

                $('.total').val(ttl_rp)

            });
            $(document).on('keyup', '.setengah', function() {
                var full = $('.full').val();
                var h_full = $('.h_full').val();
                var setengah = $('.setengah').val();
                var h_setengah = $('.h_setengah').val();

                var hitung= (parseInt(full) * parseInt(h_full)) + (parseInt(setengah) * parseInt(h_setengah));
                var ttl = $('.ttl1').val(hitung);

                var ttl_rp = 0;
                $(".ttl1").each(function() {
                    ttl_rp += parseInt($(this).val());
                });

                $('.total').val(ttl_rp)

            });
            $(document).on('keyup', '.h_setengah', function() {
                var full = $('.full').val();
                var h_full = $('.h_full').val();
                var setengah = $('.setengah').val();
                var h_setengah = $('.h_setengah').val();

                var hitung= (parseInt(full) * parseInt(h_full)) + (parseInt(setengah) * parseInt(h_setengah));
                var ttl = $('.ttl1').val(hitung);

                var ttl_rp = 0;
                $(".ttl1").each(function() {
                    ttl_rp += parseInt($(this).val());
                });

                $('.total').val(ttl_rp)

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