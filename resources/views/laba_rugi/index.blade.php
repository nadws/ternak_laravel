@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <dt class="float-left" style="color: #629779">Laporan Laba / Rugi
                                {{date('d-m-Y',strtotime($tgl1))}} ~
                                {{date('d-m-Y',strtotime($tgl2))}}
                            </dt>
                            <a href="#" data-toggle="modal" data-target="#view"
                                class="btn btn-sm btn-costume float-right"><i class="fas fa-calendar-alt"></i>
                                View</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-sm table-bordered">
                                <tr>
                                    <th colspan="5">URAIAN</th>
                                </tr>
                                <tr style="border-top: 2px solid black;">
                                    <td colspan="5"><strong>PEREDARAN USAHA</strong></td>
                                </tr>
                                @php
                                $total_penjualan = 0;
                                @endphp
                                @foreach ($penjualan as $p)
                                <tr>
                                    <td></td>
                                    <td colspan="2">{{$p->nm_akun}}</td>
                                    <td>Rp</td>
                                    <td align="right">{{number_format($p->penjualan,0)}}</td>
                                </tr>
                                @php
                                $total_penjualan += $p->penjualan;
                                @endphp
                                @endforeach
                                <tr>
                                    <th colspan="3">TOTAL PENDAPATAN</th>
                                    <th>Rp</th>
                                    <th class="text-right">{{number_format($total_penjualan,0)}}</th>
                                </tr>
                                <tr style="border-top: 2px solid black;">
                                    <td colspan="5"><strong>BIAYA BIAYA </strong></td>
                                </tr>
                                @php
                                $total_biaya = 0;
                                @endphp
                                @foreach ($biaya as $b)
                                <tr>
                                    <td></td>
                                    <td colspan="2">{{$b->nm_akun}}</td>
                                    <td>Rp</td>
                                    <td align="right">{{number_format($b->d_biaya - $b->k_biaya,0)}}</td>
                                </tr>
                                @php
                                $total_biaya += $b->d_biaya - $b->k_biaya;
                                @endphp
                                @endforeach
                                <tr>
                                    <th colspan="3">TOTAL BIAYA</th>
                                    <th>Rp</th>
                                    <th class="text-right">{{number_format($total_biaya,0)}}</th>
                                </tr>
                                <tr>
                                    <th colspan="3">LABA BERSIH SEBELUM PAJAK</th>
                                    <th>Rp</th>
                                    <th class="text-right">{{number_format($total_penjualan-$total_biaya,0)}}</th>
                                </tr>
                                <tr>
                                    <td colspan="3">PPH TERHUTANG (-)</td>
                                    <td>Rp</td>
                                    <td class="text-right">0</td>
                                </tr>
                                <tr>
                                    <th colspan="3">LABA BERSIH SETELAH PAJAK</th>
                                    <th>Rp</th>
                                    <th class="text-right">{{number_format($total_penjualan-$total_biaya,0)}}</th>
                                </tr>
                                <tr>
                                    <td colspan="3">PENDAPATAN BANK (+)</td>
                                    <td>Rp</td>
                                    <td class="text-right">0</td>
                                </tr>
                                <tr>
                                    <th colspan="3">LABA BERSIH</th>
                                    <th>Rp</th>
                                    <th class="text-right">{{number_format($total_penjualan-$total_biaya,0)}}</th>
                                </tr>


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

<form action="">
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-6">
                            <label for="">Dari</label>
                            <input type="date" class="form-control" name="tgl1">
                        </div>
                        <div class="col-lg-6 col-6">
                            <label for="">Sampai</label>
                            <input type="date" class="form-control" name="tgl2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-costume">Search</button>
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
<!-- /.control-sidebar -->
@endsection