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
                        <div class="card-header">
                            <ul class="nav nav-tabs float-left" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active h_kg" id="custom-tabs-one-home-tab" data-toggle="pill"
                                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true">Hitung Kg</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link h_pcs" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-one-profile" role="tab"
                                        aria-controls="custom-tabs-one-profile" aria-selected="false">Hitung Pcs</a>
                                </li>
                            </ul>
                        </div>
                        <form action="{{ route('save_kg') }}" method="post">
                            @csrf
                            <div class="card-body hitung_kg">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tgl" class="form-control" value="{{ date('Y-m-d') }}"
                                            required>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Costumer</label>
                                        <select name="id_post" id="" class="form-control select" required>
                                            <option value="">--Pilih Costumer--</option>
                                            @foreach ($costumer as $c)
                                            <option value="{{ $c->id_post }}">{{ $c->nm_post }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Driver</label>
                                        <input type="text" name="driver" class="form-control" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table " style="white-space: nowrap">
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
                                                @foreach ($jenis as $j)
                                                <tr>
                                                    <td>{{ $j->jenis }}</td>
                                                    <td><input type="text" name="pcs[]"
                                                            class="form-control pcs pcs_kg{{ $j->id }}"
                                                            id_jenis="{{ $j->id }}" value="0" style="text-align: right">
                                                    </td>
                                                    <td><input type="text" name="kg[]"
                                                            class="form-control kg kg{{ $j->id }}"
                                                            id_jenis="{{ $j->id }}" value="0" style="text-align: right">
                                                    </td>
                                                    <td><input type="text" class="form-control ikat{{ $j->id }}"
                                                            value="0" style="text-align: right" readonly></td>

                                                    <td><input name="kg_jual[]" type="text"
                                                            class="form-control  kg_rak{{ $j->id }}" value="0"
                                                            style="text-align: right" readonly></td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control rupiah rupiah{{ $j->id }}" value="0"
                                                            style="text-align: right" name="rupiah[]"
                                                            id_jenis="{{ $j->id }}">

                                                        <input type="hidden"
                                                            class="form-control hasil hasil{{ $j->id }}" value="0"
                                                            style="text-align: right" name="rp_kg[]">

                                                        <input type="hidden" name="id_jenis_telur[]" value="{{$j->id}}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4"></th>
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
                        <form action="">
                            <div class="card-body hitung_pcs">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="">Tanggal</label>
                                        <input type="date" class="form-control input_pcs" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Costumer</label>
                                        <select name="" id="" class="form-control select input_pcs">
                                            <option value="">--Pilih Costumer--</option>
                                            @foreach ($costumer as $c)
                                            <option value="{{ $c->id_post }}">{{ $c->nm_post }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Driver</label>
                                        <input type="text" class="form-control input_pcs">
                                    </div>
                                    <div class="col-lg-12">
                                        <hr>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table " style="white-space: nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Nama barang</th>
                                                    <th>Pcs</th>
                                                    <th>Kg</th>
                                                    <th>Rp/Kg</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jenis as $j)
                                                <tr>
                                                    <td>{{ $j->jenis }}</td>
                                                    <td><input type="text" class="form-control pcs input_pcs" value="0"
                                                            style="text-align: right"></td>
                                                    <td><input type="text" class="form-control kg input_pcs" value="0"
                                                            style="text-align: right"></td>

                                                    <td><input type="text" class="form-control input_pcs" value="0"
                                                            style="text-align: right"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th style="text-align: right;vertical-align: middle">Total:</th>
                                                    <th><input type="text" class="form-control input_pcs" value="0"
                                                            style="text-align: right"></th>
                                                </tr>


                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer hitung_pcs">
                                <button type="submit" class="btn float-right btn-costume"><i class="fas fa-save"></i>
                                    Save
                                </button>
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


            });
            $(document).on('keyup', '.kg', function() {

                var id_jenis = $(this).attr('id_jenis');

                var kg = $('.kg' + id_jenis).val();
                var ikat = $('.ikat' + id_jenis).val();



                var kg_rak = parseFloat(kg) - parseFloat(ikat);
                $(".kg_rak" + id_jenis).val(kg_rak.toFixed(1));


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


        });
</script>
<!-- /.control-sidebar -->
@endsection