@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
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

                <div class="card">
                    <div class="card-header">
                        <h5 class="float-left">Data Akun</h5>
                        <a href="" data-toggle="modal" data-target="#tambah"
                            class="btn btn-info btn-sm float-right mr-1"><i class="fas fa-plus"></i> Tambah
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
                                                <td align="center"><button type="button" class="btn btn-info btn-sm  "
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-primary post_center" href="#"
                                                            data-toggle="modal" data-target="#post_center"
                                                            id_akun="<?= $a->id_akun ?>"><i
                                                                class="far fa-clipboard"></i> &nbsp;Post Center</a>

                                                        <a class="dropdown-item text-primary " href="#"
                                                            data-toggle="modal"
                                                            data-target="#akses<?= $a->id_akun ?>"><i
                                                                class="fas fa-link"></i> &nbsp;Permission Akun</a>

                                                        <a class="dropdown-item text-primary " href="#"
                                                            data-toggle="modal"
                                                            data-target="#relation<?= $a->id_akun ?>"><i
                                                                class="fas fa-bars"></i> &nbsp;Relasi Penyesuaian</a>

                                                        <a class="dropdown-item text-success" href="#"
                                                            data-toggle="modal" data-target="#edit_akun"><i
                                                                class="fas fa-pen"></i> &nbsp;Edit</a>

                                                        <a class="dropdown-item text-danger" href="#"><i
                                                                class="far fa-trash-alt"></i> &nbsp;Delete</a>
                                                    </div>
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
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="list_kategori">No Akun</label>
                                <input class="form-control" type="text" name="no_akun" id="no_akun"
                                    placeholder="Cth: 1200" required readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="list_kategori">Kode Akun</label>
                                <input class="form-control" type="text" name="kd_akun" id="kd_akun" required>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="list_kategori">Nama Akun</label>
                                <input class="form-control" type="text" name="nm_akun" id="nm_akun" required>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="list_kategori">Kategori Akun</label>
                                <select name="id_kategori" id="id_kategori" class="form-control select2bs4" required="">
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
                        <div class="col-md-6 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori"><u>Kategori Asset</u></label>
                                <select name="" id="" class="form-control select2 input_akun2">
                                    <option value="">--Pilih Kategori--</option>
                                    <option value="">Umum</option>
                                    <option value="">Aktiva</option>
                                    <option value="">ATK</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 lawan_penyesuaian">
                            <label for=""><u>Biaya Penyesuaian</u> </label>
                        </div>

                        <div class="col-md-6 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">No Akun</label>
                                <input class="form-control input_akun2" type="text" name="no_akun2" id="no_akun2"
                                    placeholder="Cth: 1200" required readonly>
                            </div>

                        </div>

                        <div class="col-md-6 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Kode Akun</label>
                                <input class="form-control input_akun2" type="text" name="kd_akun2" id="kd_akun"
                                    required>
                            </div>

                        </div>

                        <div class="col-md-6 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Nama Akun</label>
                                <input class="form-control input_akun2" type="text" name="nm_akun2" id="nm_akun"
                                    required>
                            </div>
                        </div>


                        <div class="col-md-6 lawan_penyesuaian">
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
    });
</script>

<!-- /.control-sidebar -->
@endsection