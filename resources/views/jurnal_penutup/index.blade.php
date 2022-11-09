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
                        {{-- <ul class="nav nav-tabs float-left" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link " href="{{route('jurnal_pengeluaran')}}" role="tab"
                                    aria-controls="custom-tabs-one-home" aria-selected="true">Pengeluaran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="" role="tab" aria-controls="custom-tabs-one-profile"
                                    aria-selected="false">Pemasukan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#custom-tabs-one-messages" role="tab"
                                    aria-controls="custom-tabs-one-messages" aria-selected="false">Penyesuaian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#custom-tabs-one-settings" role="tab"
                                    aria-controls="custom-tabs-one-settings" aria-selected="false">Penutup</a>
                            </li>
                        </ul> --}}
                        <a href="" data-toggle="modal" data-target="#tambah"
                            class="btn btn-costume btn-sm tambah_penutup  float-right mr-1 p_stok"><i
                                class="fas fa-plus"></i>
                            Jurnal
                        </a>
                        <a href="" data-toggle="modal" data-target="#view"
                            class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-calendar-alt"></i> View
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
                                                    <th>Post Akun</th>
                                                    <th>Keterangan</th>
                                                    <th style="text-align: right">Debit <br>
                                                        ({{ number_format($total_jurnal->debit, 0) }})</th>
                                                    <th style="text-align: right">Kredit <br>
                                                        ({{ number_format($total_jurnal->kredit, 0) }})</th>
                                                    <th>Admin</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no = 1;
                                                @endphp
                                                @foreach ($jurnal as $a)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td style="white-space: nowrap">
                                                        {{ date('d-m-Y', strtotime($a->tgl)) }}</td>
                                                    <td>{{ $a->no_nota }}</td>
                                                    <td>{{ $a->nm_akun }}</td>
                                                    <td>{{ $a->ket }}</td>
                                                    <td align="right">{{ number_format($a->debit, 0) }}</td>
                                                    <td align="right">{{ number_format($a->kredit, 0) }}</td>
                                                    <td>{{ $a->admin }}</td>

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

<form action="{{ route('save_penutup') }}" method="post">
    @csrf
    <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="penutup">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume" action="">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="get" action="">
    <div class="modal fade" id="view" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">View Jurnal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input type="date" class="form-control" name="tgl1">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" class="form-control" name="tgl2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume" action="">Search</button>
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
            $(document).on('click', '.tambah_penutup', function() {
                $.ajax({
                    url: "{{ route('isi_penutup') }}",
                    type: "GET",
                    success: function(data) {
                        $('#penutup').html(data);
                    }
                });
            });
            $(document).on('keyup', '.prive', function() {
                var total = $(this).val();
                $('.prive').val(total);
            });
        });
</script>



<!-- /.control-sidebar -->
@endsection