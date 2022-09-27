@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">{{ $title }}</h1> --}}
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
                        <h5 class="float-left">Data {{ $title }}</h5>
                        <a href="" data-toggle="modal" data-target="#tambah"
                            class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-plus"></i> Tambah
                            Jurnal</a>
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
                                                    <td>{{ number_format($a->debit, 0) }}</td>
                                                    <td>{{ number_format($a->kredit, 0) }}</td>
                                                    <td>{{ $a->admin }}</td>
                                                    <td align="center" style="white-space: nowrap">
                                                        <a href="#" class="btn btn-costume btn-sm"><i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-sm"><i
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
        max-width: 1000px;
    }
</style>
<form action="" method="post">
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                                <input type="hidden" class="plus">
                            </div>
                        </div>
                        <div class="mt-3 ml-1">
                            <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Akun</label>
                                <select name="id_akun" class="form-control select id_debit" required="">
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
                                <input type="number" class="form-control total ttl_rp" id="total" name="total" readonly>
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
                                <select name="id_akun_kredit" class="form-control akun_kredit select" required>

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

                                <input type="number" class="form-control total ttl_rp" id="total1" readonly>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">

                        </div>
                        <div id="input_jurnal">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-costume">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>





<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

{{-- <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script> --}}




<!-- /.control-sidebar -->
@endsection
@section('script')
<script>
    $(document).ready(function() {

            $('.id_debit').change(function() {
                var id_debit = $(this).val();
                $.ajax({
                    url: "{{ route('akun_kredit') }}",
                    data: {
                        id_debit: id_debit
                    },
                    type: "GET",
                    success: function(data) {
                        $('.akun_kredit').html(data);
                    }
                });
            });
            $('.id_debit').change(function() {
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
        });
</script>
@endsection