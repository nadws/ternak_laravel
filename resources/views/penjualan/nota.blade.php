@extends('template.master')
@section('content')
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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <img src="{{ asset('assets') }}/menu/img/agrilaras.png" alt="" width='150px'>
                            </div>
                            <div class="float-right">
                                <table style="font-size: small;">
                                    <tr>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">Tanggal</td>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">:</td>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">{{date('d-m-Y',strtotime($nota->tgl))}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">No nota</td>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">:</td>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">T-{{$nota->no_nota}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">Kpd Yth, Bpk/Ibu</td>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">:</td>
                                        <td style="padding: 0.75rem;
                                        vertical-align: top;">{{$nota->nm_post}}{{$nota->urutan}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered"
                                style="text-align: center;white-space: nowrap; vertical-align: middle">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Timbangan <br> (Kg)</th>
                                        <th>Ikat</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $ttl =0;

                                    @endphp
                                    @foreach ($isi_nota as $s)
                                    @if ($s->kg_jual != '0')

                                    <tr>
                                        <td>{{$s->jenis}}</td>
                                        <td>{{$s->kg_jual}}</td>
                                        <td>{{number_format($s->pcs/180,1)}}</td>
                                        <td>{{number_format($s->rupiah,0)}}</td>
                                        <td>{{number_format($s->rp_kg,0)}}</td>
                                    </tr>
                                    @else

                                    @endif


                                    @php
                                    $ttl += $s->rp_kg
                                    @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th colspan="3"></th>
                                    <th>TOTAL</th>
                                    <th>{{number_format($ttl,0)}}</th>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <form action="{{route('save_jurnal')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8"></div>
                                    <div class="col-lg-4 mb-2">
                                        <select name="id_akun" id="" class="form-control select">
                                            <option value="">--Pilih Akun--</option>
                                            <option value="{{$akun->id_akun}}">{{$akun->nm_akun}}</option>
                                            @foreach ($akun2 as $a)
                                            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="total" value="{{$ttl}}">
                                    <input type="hidden" name="no_nota" value="{{$nota->no_nota}}">
                                    <input type="hidden" name="tgl" value="{{$nota->tgl}}">
                                    <input type="hidden" name="id_post" value="{{$nota->id_post}}">
                                    <div class="col-lg-12">
                                        <button class="btn btn-costume  float-right">Save</button>
                                    </div>
                                </div>
                            </form>
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
<!-- /.control-sidebar -->
@endsection