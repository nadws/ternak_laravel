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
                            <a class="btn btn-costume btn-sm float-right" href="{{route('add_ayam')}}"><i
                                    class="fas fa-plus"></i> Invoice
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="example2" style="white-space: nowrap;text-align: center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Customer</th>
                                            <th>Nota</th>
                                            <th>Ekor</th>
                                            <th>Berat</th>
                                            <th>Total Rp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $l=1;
                                        @endphp
                                        @foreach ($invoice as $i)
                                        <tr>
                                            <td>{{$l++}}</td>
                                            <td>{{date('d-m-Y',strtotime($i->tgl))}}</td>
                                            <td>{{$i->nm_post}} {{$i->urutan}}</td>
                                            <td>A-{{$i->no_nota}}</td>
                                            <td>{{number_format($i->ekor,0)}}</td>
                                            <td>{{number_format($i->berat,2)}}</td>
                                            <td>{{number_format($i->ttl_harga,0)}}</td>
                                            <td>{{$i->lunas == 'Y' ?'Paid' : 'Unpaid'}}</td>
                                            <td>
                                                <a href="{{route('edit_telur',['nota'=>$i->no_nota])}}"
                                                    class="btn btn-sm btn-costume"><i class="fas fa-pen"></i></a>
                                                <a href="{{route('delete_p',['nota'=>$i->no_nota ])}}"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
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