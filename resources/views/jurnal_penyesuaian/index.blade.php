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
                            class="btn btn-costume btn-sm float-right mr-1 p_stok"><i class="fas fa-plus"></i> Jurnal
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
                                                    <th>Debit <br> ({{ number_format($total_jurnal->debit, 0) }})</th>
                                                    <th>Kredit <br> ({{ number_format($total_jurnal->kredit, 0) }})</th>
                                                    <th>Admin</th>
                                                    <th class="text-center">Aksi</th>
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
                                                    <td align="center" style="white-space: nowrap">
                                                        <a href="#" class="btn btn-costume btn-sm"><i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                        <a href="{{route('delete_penyesuaian', ['no_nota' => $a->no_nota])}}"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash-alt"></i>
                                                        </a>

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
        max-width: 1300px;
    }
</style>

<div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link p_stok active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Stok</a>
                        @foreach ($akun_asset_pv as $a)
                        <a class="nav-item nav-link pakan_stok pakan_stok{{$a->id_akun}}" id_akun="{{$a->id_akun}}"
                            id="nav-profile-tab " data-toggle="tab" href="#nav-profile" role="tab"
                            aria-controls="nav-profile" aria-selected="false">{{$a->nm_akun}}</a>
                        @endforeach

                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                            role="tab" aria-controls="nav-contact" aria-selected="false">Pullet</a>

                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                            role="tab" aria-controls="nav-contact" aria-selected="false">Atk & Perlengkapan</a>
                    </div>
                </nav>
            </div>
            <div class="modal-body">
                <div id="stok">

                </div>
                <div id="pakan">

                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="submit" class="btn btn-costume" action="">Edit/Save</button>
            </div> --}}
        </div>
    </div>
</div>

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
        $(document).on('click', '.p_stok', function() {
            $.ajax({
                url: "{{ route('p_stok') }}",
                type: "GET",
                success: function(data) {
                    $('#stok').html(data);
                    $('#stok').show();
                    $('#pakan').hide();
                }
            });
        });                
        $(document).on('click', '.pakan_stok', function() {
            var id_akun = $(this).attr('id_akun')
            $.ajax({
                url: "{{ route('pakan_stok') }}?id_akun="+id_akun,
                type: "GET",
                success: function(data) {
                    $('#pakan').html(data);
                    $('#pakan').show();
                    $('#stok').hide();
                    
                }
            });
        });                
        $(document).on('keyup', '.stk_aktual_umum', function() {
            var id_akun = $(this).attr('id_akun');
            var qty_pro = $('.stk_program_umum' + id_akun).val()
            var qty_akt = $('.stk_aktual_umum' + id_akun).val()
            var h_satuan = $('.h_satuan' + id_akun).val()

            var selisih = parseInt(qty_pro) - parseInt(qty_akt);
            var rupiah = parseInt(h_satuan) * selisih;


            $('.selisih' + id_akun).val(selisih);
            $('.debit' + id_akun).val(rupiah);

            
        });  

        $(document).on('keyup', '.qty_aktual_pv', function() {
            var id_barang = $(this).attr('id_barang');
            var qty_pro = $('.qty_a_pv' + id_barang).val()
            var qty_akt = $('.qty_aktual_pv' + id_barang).val()
            var h_satuan = $('.h_satuan_pv' + id_barang).val()

            var selisih = parseInt(qty_pro) - parseInt(qty_akt);
            var rupiah = parseInt(h_satuan) * selisih;


            $('.slsh_pv' + id_barang).val(selisih);
            $('.ttl_pv' + id_barang).val(rupiah);

            var debit = 0;
            $(".ttl_pv").each(function() {
                debit += parseFloat($(this).val());
            });
            
            $('.ttl_debit_p').val(debit);

            
        });                
    });
</script>



<!-- /.control-sidebar -->
@endsection