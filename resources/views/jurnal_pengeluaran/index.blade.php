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
                <div class="card">
                    <div class="card-header">
                        <h5>Tanggal : {{ date('d-m-Y', strtotime($tgl1)) }} ~ {{ date('d-m-Y', strtotime($tgl2)) }}</h5>
                        <a href="" data-toggle="modal" data-target="#tambah"
                            class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-plus"></i>
                            Jurnal
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-costume btn-sm float-right mr-1 dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-info" target="_blank"
                                    href="{{route('print_j_all',['tgl1' => $tgl1,'tgl2' => $tgl2 ])}}"><i
                                        class="fas fa-print "></i>
                                    Cetak</a>
                                <a class="dropdown-item text-info"
                                    href="{{route('export_j_all',['tgl1' => $tgl1,'tgl2' => $tgl2 ])}}"><i
                                        class="fas fa-file-excel"></i>
                                    Excel</a>
                            </div>
                        </div>


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
                                                    <th>No Id</th>
                                                    <th>Post Akun</th>
                                                    <th>Keterangan</th>
                                                    <th style="text-align: right">Debit <br>
                                                        ({{ number_format($total_jurnal->debit, 0) }})</th>
                                                    <th style="text-align: right">Kredit <br>
                                                        ({{ number_format($total_jurnal->kredit, 0) }})</th>
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
                                                    <td>{{ $a->no_id }}</td>
                                                    <td>{{ $a->nm_akun }}</td>
                                                    <td>{{ $a->ket }}</td>
                                                    <td style="text-align: right">{{ number_format($a->debit, 0) }}
                                                    </td>
                                                    <td style="text-align: right">
                                                        {{ number_format($a->kredit, 0) }}
                                                    </td>
                                                    <td>{{ $a->admin }}</td>
                                                    <td align="center" style="white-space: nowrap">
                                                        <a href="#" data-toggle="modal" data-target="#print"
                                                            class="btn btn-costume btn-sm print"
                                                            nota="{{ $a->no_nota }}"><i class="fas fa-print"></i>
                                                        </a>
                                                        @if ($a->penyesuaian == 'Y' || $a->penutup == 'Y')

                                                        @else
                                                        <a href="#" data-toggle="modal" data-target="#edit"
                                                            class="btn btn-costume btn-sm edit_jurnal"
                                                            nota="{{ $a->no_nota }}"><i class="fas fa-pen"></i>
                                                        </a>
                                                        <a href="{{ route('delete_jurnal', ['no_nota' => $a->no_nota]) }}"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash-alt"></i>
                                                        </a>
                                                        @endif


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
        max-width: 1000px;
    }
</style>
<form method="post" id="form-jurnal" action="">
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
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Tanggal</label>
                                <input class="form-control" type="date" name="tgl" id="tgl_peng"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mt-3 ml-1">
                            <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Akun</label>
                                <select name="id_akun" class="form-control select id_debit" required>
                                    <option value="">-Pilih Akun-</option>
                                    <?php foreach ($akun as $a) : ?>
                                    <option value="<?= $a->id_akun ?>">
                                        <?= $a->nm_akun ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="list_kategori">Debit</label>
                                <input style="text-align: right" type="number" class="form-control  total" name="debit"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="list_kategori">Kredit</label>
                                <input type="number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">

                        </div>

                        <div class="mt-1">
                            <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
                        </div>

                        <div class="col-sm-3 col-md-3">

                            <div class="form-group">
                                <input type="hidden" class="id_debit_akun">
                                <select name="id_akun_kredit" class="form-control post_atk akun_kredit select" count="1"
                                    required>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="number" style="text-align: right" class="form-control total " name="kredit"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">

                        </div>

                    </div>
                    <div id="input_jurnal">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume" action="">Edit/Save</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal</h5>
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


<div class="modal fade" id="edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jurnal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="edit_jurnal">

            </div>

        </div>
    </div>
</div>


<style>
    .modal-lg-max2 {
        max-width: 1200px;
    }
</style>
<div class="modal fade" id="print" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max2" role="document">

        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Print Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="print_nota">

                </div>

            </div>
        </div>
    </div>
</div>






<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>


<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/izitoast/dist/js/iziToast.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
            $(document).on('change', '.id_debit', function() {
                var id_debit = $(this).val();


                $.ajax({
                    url: "{{ route('akun_kredit') }}",
                    data: {
                        id_debit: id_debit
                    },
                    type: "GET",
                    success: function(data) {
                        $('.akun_kredit').html(data);
                        $('.id_debit_akun').val(id_debit);
                        $(this).attr('id_debit', id_debit);
                        $('.select').select2()
                    }
                });

                $.ajax({
                    url: "{{ route('get_save_jurnal') }}",
                    data: {
                        id_debit: id_debit
                    },
                    type: "GET",
                    success: function(data) {
                        if (data == 'biaya') {
                            $("#form-jurnal").attr("action",
                                "{{ route('save_jurnal_biaya') }}");
                        }
                        if (data == 'asset_umum') {
                            $("#form-jurnal").attr("action",
                                "{{ route('save_jurnal_umum') }}");
                        }
                        if (data == 'asset_pakan') {
                            $("#form-jurnal").attr("action", "{{ route('save_jurnal_pv') }}");
                        }
                        if (data == 'asset_aktiva') {
                            $("#form-jurnal").attr("action", "{{ route('save_aktiva') }}");
                        }
                        if (data == 'asset_atk') {
                            $("#form-jurnal").attr("action", "{{ route('save_atk') }}");
                        }
                    }
                });

                $('.total').val(0);
            });

            $(document).on('change', '.id_debit', function() {
                var id_debit = $(this).val();

                $.ajax({
                    url: "{{ route('get_isi_jurnal') }}",
                    data: {
                        id_debit: id_debit,
                    },
                    type: "GET",
                    success: function(data) {
                        $('#input_jurnal').html(data);
                        $('.select').select2()
                    }
                });
            });
            $(document).on('change', '.id_debit', function() {
                var id_debit = $(this).val();
                $.ajax({
                    url: "{{ route('get_isi_jurnal') }}",
                    data: {
                        id_debit: id_debit
                    },
                    type: "GET",
                    success: function(data) {
                        $('#input_jurnal').html(data);
                        $('.select').select2()
                    }
                });
            });
            $(document).on('keyup', '.total_rp', function() {
                var rupiah = parseFloat($(this).val());

                var debit = 0;
                $(".total_rp:not([disabled=disabled]").each(function() {
                    debit += parseFloat($(this).val());
                });
                $('.total').val(debit);
            });
            $(document).on('click', '.remove_monitoring', function() {
                var delete_row = $(this).attr('count');

                $('#row' + delete_row).remove();

                var rupiah = parseFloat($('.total_rp').val());


                var debit = 0;
                $(".total_rp:not([disabled=disabled]").each(function() {
                    debit += parseFloat($(this).val());
                });
                $('.total').val(debit);

            });

            var count = 1;
            $(document).on('click', '.tambah_input_jurnal', function() {
                var id_akun = $(this).attr('id_akun');
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_jurnal') }}?count=" + count + "&" + "id_akun=" +
                        id_akun,
                    type: "Get",
                    success: function(data) {
                        $('#tambah_input_jurnal').append(data);
                        $('.select').select2()
                    }
                });
            });


            var count = 1;
            $(document).on('click', '.tambah_umum', function() {
                var id_akun = $(this).attr('id_akun');
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_umum') }}?count=" + count + "&" + "id_akun=" + id_akun,
                    type: "Get",
                    success: function(data) {
                        $('#tambah_umum').append(data);
                        $('.select').select2()
                    }
                });
            });

            var count = 1;
            $(document).on('click', '.tambah_input_vitamin', function() {
                var id_akun = $(this).attr('id_akun');
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_input_vitamin') }}?count=" + count + "&" + "id_akun=" +
                        id_akun,
                    type: "Get",
                    success: function(data) {
                        $('#tambah_input_vitamin').append(data);
                        $('.select').select2()
                    }
                });
            });



            // Aktiva

            $(document).on('keyup', '.total_aktiva', function() {
                var rupiah = parseFloat($(this).val());
                var qty = parseFloat($('.qty_aktiva').val());
                var ppn = (rupiah * qty) * 0.1;
                var total = (rupiah * qty) + ppn;

                $('.ppn').val(ppn);
                $('.ppn_ttl_rp').val(total);
                $('.total').val(total);
            });

            $(document).on('click', '.print', function() {
                var nota = $(this).attr('nota');
                $.ajax({
                    url: "{{ route('print_j') }}?nota=" + nota,
                    type: "Get",
                    success: function(data) {
                        $('#print_nota').html(data);
                    }
                });
            });
            $(document).on('change', '.get_barang', function() {
                var id_barang = $(this).val();
                var count = $(this).attr('count');
                $.ajax({
                    url: "{{ route('get_barang') }}?id_barang=" + id_barang,
                    type: "Get",
                    success: function(data) {
                        $('.satuan_barang' + count).html(data);
                    }
                });
            });
            $(document).on('change', '.akun_kredit', function() {
                var id_akun = $(this).val();
                $.ajax({
                    url: "{{ route('get_post_aktiva') }}?id_akun=" + id_akun,
                    type: "Get",
                    success: function(data) {
                        $('.pos_aktiva').html(data);
                    }
                });
            });

            $(document).on('change', '.pos_aktiva', function() {
                var id_post = $(this).val();
                $.ajax({
                    url: "{{ route('get_ttl_aktiva') }}?id_post=" + id_post,
                    type: "Get",
                    success: function(data) {
                        $('.total_aktiva').val(data);
                        var rupiah = parseFloat($('.total_aktiva').val());
                        var qty = parseFloat($('.qty_aktiva').val());
                        var ppn = (rupiah * qty) * 0.1;
                        var total = (rupiah * qty) + ppn;

                        $('.ppn').val(ppn);
                        $('.ppn_ttl_rp').val(total);
                        $('.total').val(total);

                    }
                });
            });
            $(document).on('keyup', '.ppn', function() {
                var ppn = $(this).val();
                var ppn_ttl_rp = $('.total_aktiva').val();

                var total = parseInt(ppn_ttl_rp) + parseInt(ppn);
                $('.ppn_ttl_rp').val(total);
                $('.total').val(total);




            });

            $(document).on('change', '.post_atk', function() {
                var id_debit = $('.id_debit').val();
                var id_kredit = $('.post_atk').val();
                var count = '1';

                $.ajax({
                    url: "{{ route('get_post_atk') }}",
                    data: {
                        id_debit: id_debit,
                        id_kredit: id_kredit,
                    },
                    type: "Get",
                    success: function(data) {
                        $('.atk_post' + count).html(data);
                    }
                });



            });
            $(document).on('change', '.atk_post', function() {
                var count = $(this).attr('count');
                var id_post = $('.atk_post' + count).val();

                $.ajax({
                    url: "{{ route('get_ttl_atk') }}",
                    data: {
                        id_post: id_post
                    },
                    type: "Get",
                    success: function(data) {
                        $('.ttl_atk' + count).val(data);

                        var debit = 0;
                        $(".ttl_atk:not([disabled=disabled]").each(function() {
                            debit += parseFloat($(this).val());
                        });
                        $('.total').val(debit);

                    }
                });



            });

            var count = 2;
            $(document).on('click', '.tambah_input_jurnal_atk', function() {
                var id_akun = $(this).attr('id_akun');
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_input_atk') }}?count=" + count + "&" + "id_akun=" +
                        id_akun,
                    type: "Get",
                    success: function(data) {
                        $('#tambah_input_jurnal_atk').append(data);
                        $('.select').select2()
                        var id_debit = $('.id_debit').val();
                        var id_kredit = $('.post_atk').val();
                        $.ajax({
                            url: "{{ route('get_post_atk') }}",
                            data: {
                                id_debit: id_debit,
                                id_kredit: id_kredit,
                            },
                            type: "Get",
                            success: function(data) {
                                $('.atk_post' + count).html(data);
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.edit_jurnal', function() {
                var nota = $(this).attr('nota');
            
                $.ajax({
                    url: "{{ route('edit_jurnal') }}?nota=" + nota,
                    type: "Get",
                    success: function(data) {
                        $('#edit_jurnal').html(data);
                        $('.select').select2()
                    }
                });
            });








        });
</script>






<!-- /.control-sidebar -->
@endsection