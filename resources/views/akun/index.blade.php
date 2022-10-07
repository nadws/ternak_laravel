@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-lg-10">
                @include('template.flash')
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-left">{{ $title }}</h5>
                        <a href="" data-toggle="modal" data-target="#tambah"
                            class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-plus"></i> Tambah
                            Akun</a>
                    </div>
                    <div class="card-body">
                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table dataTable no-footer" id="example2" role="grid"
                                        aria-describedby="table_warning">
                                        <thead>
                                            <tr role="row">
                                                <th>#</th>
                                                <th>No Akun</th>
                                                <th>Akun</th>
                                                <th>Kategori</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no = 1;
                                            @endphp
                                            @foreach ($akun as $a)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $a->no_akun }}</td>
                                                <td>{{ $a->nm_akun }}</td>
                                                <td>{{ $a->nm_kategori }}</td>
                                                <td align="center">
                                                    <a href="#" class="btn btn-costume btn-sm"><i
                                                            class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('delete_akun', ['id_akun' => $a->id_akun])}}"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i>
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
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<form action="" method="post">
    <div class="modal fade" id="post_center" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Post Center</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="post_center2">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="tambah_post">
    <div class="modal fade" id="tbh_post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" class="form-control nm_post" name="nm_post">
                        <input type="hidden" class="form-control " id="id_akun" name="nm_post">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save/Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" action="{{route('save_akun')}}">
    @csrf
    <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <label for=""><u>Akun</u></label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">No Akun</label>
                                <input class="form-control" type="text" name="no_akun" id="no_akun"
                                    placeholder="Cth: 1200" required readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Kode Akun</label>
                                <input class="form-control" type="text" name="kd_akun" id="kd_akun" required>
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Nama Akun</label>
                                <input class="form-control" type="text" name="nm_akun" id="nm_akun" required>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="list_kategori">Kategori Akun</label>
                                <select name="id_kategori" id="id_kategori" class="form-control select" required="">
                                    <option value="">--Pilih Akun--</option>
                                    <?php foreach ($kategori as $k) : ?>
                                    <option value="<?= $k->id_kategori ?>">
                                        <?= $k->nm_kategori ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 asset">
                            <div class="custom-control custom-switch">
                                <input name="biayaDisesuaikan" value="off" type="checkbox" class="custom-control-input"
                                    id="switchBiaya">
                                <label class="custom-control-label" for="switchBiaya">Biaya Di Sesuaikan</label>
                                <input type="hidden" name="id_biaya" id="id_biaya" value="0">
                            </div>
                        </div>
                        <div class="col-md-6 cash_flow">
                            <div class="custom-control custom-switch"><input name="biayaDisesuaikan" value="off"
                                    type="checkbox" class="custom-control-input" id="switchbukukas"><label
                                    class="custom-control-label" for="switchbukukas">Buku kas / bank</label></div>
                            <input type="hidden" name="id_kas" id="id_kas" value="0">
                        </div>

                        <!-- batas -->
                        <div class="col-md-12 lawan_penyesuaian">
                            <hr>
                        </div>
                        <div class="col-md-4 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori"><u>Kategori Asset</u></label>
                                <select name="id_penyesuaian" id="" class="form-control select2 kat_akun input_akun2"
                                    required>
                                    <option value="">--Pilih Kategori--</option>
                                    <option value="1">Umum</option>
                                    <option value="2">Aktiva</option>
                                    <option value="3">ATK</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 ">
                            <div class="form-group keterangan">
                                <label for="list_kategori"><u>Asset Umum</u></label>
                                <p>Asset umum memuat data asset yang tunggal tidak memiliki produk</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_umum" data-toggle="modal">
                                    <img src="{{asset('assets')}}/img/umum2.png" alt="" width="80%">
                                </a>
                            </div>
                            <div class="form-group keterangan2">
                                <label for="list_kategori"><u>Asset Aktiva</u></label>
                                <p>Asset aktiva memuat data asset yang memiliki produk dan terjadi penurunan nilai asset
                                    setiap bulannya</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_aktiva" data-toggle="modal">
                                    <img src="{{asset('assets')}}/img/aktiva.png" alt="" width="80%">
                                </a>

                            </div>
                            <div class="form-group keterangan3">
                                <label for="list_kategori"><u>Asset ATK</u></label>
                                <p>Asset aktiva memuat data asset yang memiliki produk dan akan di opname setiap
                                    bulannya</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_atk" data-toggle="modal">
                                    <img src="{{asset('assets')}}/img/atk.png" alt="" width="80%">
                                </a>

                            </div>
                        </div>
                        <div class="col-lg-4 keterangan mb-2">
                            <label for="">Satuan</label>
                            <select name="id_satuan"
                                class="form-control select satuan input_detail input_akun2 input_biaya" required>
                                <option value="">-Pilih Satuan-</option>
                                <?php foreach ($satuan as $p) : ?>
                                <option value="{{ $p->id }}">{{ $p->nm_satuan }}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <br>
                        <div class="col-md-12 lawan_penyesuaian">
                            <label for=""><u>Biaya Penyesuaian</u> </label>
                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">No Akun</label>
                                <input class="form-control input_akun2" type="text" name="no_akun2" id="no_akun2"
                                    placeholder="Cth: 1200" required readonly>
                            </div>

                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Kode Akun</label>
                                <input class="form-control input_akun2" type="text" name="kd_akun2" id="kd_akun"
                                    required>
                            </div>

                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Nama Akun</label>
                                <input class="form-control input_akun2" type="text" name="nm_akun2" id="nm_akun"
                                    required>
                            </div>
                        </div>


                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Kategori Akun</label>
                                <input type="text " class="form-control input_akun2" value="Biaya" readonly>
                                <input type="hidden" name="id_kategori2" class="form-control input_akun2" value="5"
                                    readonly>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save/Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .modal-lg-max {
        max-width: 1200px;
    }
</style>
<div class="modal fade" id="view_image_umum" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <img src="{{asset('assets')}}/img/umum2.png" alt="" width="100%">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view_image_aktiva" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <img src="{{asset('assets')}}/img/aktiva.png" alt="" width="100%">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view_image_atk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">

        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <img src="{{asset('assets')}}/img/atk.png" alt="" width="100%">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        hide_default();

function hide_default() {
    $('.asset').hide();
    $('.cash_flow').hide();
    $('.lawan_penyesuaian').hide();
    $('.keterangan').hide();
    $('.keterangan2').hide();
    $('.keterangan3').hide();
    $('.input_akun2').attr('disabled', 'true');
    $('#id_kas').attr('disabled', 'true');
}
$(document).on('change', '#id_kategori', function() {
    var id_kategori = $(this).val();
    if (id_kategori == '1') {
        $('.asset').show();
        $('.cash_flow').show();

        $('#id_kas').removeAttr('disabled', 'true');

    } else {
        $('.asset').hide();
        $('.cash_flow').hide();
        $('.lawan_penyesuaian').hide();

    }

});

$(document).on('click', '#switchBiaya', function() {
    var id_biaya = $('#id_biaya').val();
    if (id_biaya == '0') {
        var b = '1';
        $('.lawan_penyesuaian').show();
        $('.input_akun2').removeAttr('disabled', 'true');
        $('#switchbukukas').attr('disabled', 'true');
    } else {
        var b = '0';
        $('.lawan_penyesuaian').hide();
        $('.input_akun2').attr('disabled', 'true');
        $('#switchbukukas').removeAttr('disabled', 'true');
    }

    var id_pilih = '5';
   

    $.ajax({
        url: "{{route('get_no_akun')}}",
        type: "Get",
        data: {
            id_pilih: id_pilih
        },
        // dataType: "json",
        success: function(data) {

            $('#no_akun2').val(data);

        }

    });



    $('#id_biaya').val(b);

});
$(document).on('click', '#switchbukukas', function() {
    var id_kas = $('#id_kas').val();
    if (id_kas == '0') {
        var b = '1';
        $('#switchBiaya').attr('disabled', 'true');
    } else {
        var b = '0';
        $('#switchBiaya').removeAttr('disabled', 'true');
    }
    $('#id_kas').val(b);


});

// post center
        load_post();

        function load_post() {
            $(document).on('click', '.post_center', function() {
                var id_akun = $(this).attr("id_akun");
                // alert(id_akun);
                $.ajax({
                    url: "{{route('post_center_akun')}}",
                    method: "GET",
                    data: {
                        id_akun: id_akun,
                    },
                    success: function(data) {
                        $('#post_center2').html(data);
                    }
                });

            });
        }

        $(document).on('submit', '#tambah_post', function(event) {
            event.preventDefault();

            var nm_post = $(".nm_post").val();
            var id_akun = $("#id_akun").val();
            $.ajax({
                type: "GET",
                url: "{{ route('tambah_post') }}",
                data: {
                    nm_post: nm_post,
                    id_akun: id_akun
                },
                success: function(response) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Tambah Post berhasil'
                    });
                    var id_akun = $("#id_akun").val();
                 
                    $.ajax({
                        url: "{{route('post_center_akun')}}",
                        method: "GET",
                        data: {
                            id_akun: id_akun,
                        },
                        success: function(data) {
                            $('#post_center2').html(data);
                        }
                    });
                    $('#tbh_post').hide(); //or  $('#IDModal').modal('hide');
                }
            });

        });

        $(document).on('click', '.tbh_post', function() {
            var id_akun = $(this).attr("id_akun");
            // alert(id_akun);
            $("#id_akun").val(id_akun);

        });

        $("body").on("change", "#id_kategori", function() {
            var id_pilih = $(this).val();
            // alert(id_pilih);

            $.ajax({
                url: "{{route('get_no_akun')}}",
                type: "Get",
                data: {
                    id_pilih: id_pilih
                },
                // dataType: "json",
                success: function(data) {

                    $('#no_akun').val(data);

                }

            });
        });
        $("body").on("change", ".kat_akun", function() {
            var id_kat = $(this).val();
            if (id_kat == '1') {
                $('.keterangan').show();
            } else {
                $('.keterangan').hide();
            }
            if (id_kat == '2') {
                $('.keterangan2').show();
            } else {
                $('.keterangan2').hide();
            }
            if (id_kat == '3') {
                $('.keterangan3').show();
            } else {
                $('.keterangan3').hide();
            }
            
        
        });
    });
</script>

<!-- /.control-sidebar -->
@endsection