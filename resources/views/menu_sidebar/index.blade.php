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
            <div class="row">


                <div class="col-lg-6">
                    @include('template.flash')
                    <div class="card">
                        <div class="card-header">

                            <h5 class="float-left">Data Menu</h5>
                            <a href="" class="btn btn-info float-right " data-target="#tambah_menu"
                                data-toggle="modal">Tambah Menu</a>
                            <a href="" class="btn btn-info float-right mr-2" data-target="#urutan"
                                data-toggle="modal">Urutan</a>

                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table dataTable no-footer" id="example1" role="grid"
                                            aria-describedby="table_warning">
                                            <thead>
                                                <tr role="row">
                                                    <th>#</th>
                                                    <th>Icon</th>
                                                    <th>Nama Menu</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($menu as $d) : ?>
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td><i class="<?= $d->icon; ?>"></i></td>
                                                    <td>{{$d->menu}}</td>
                                                    <td>
                                                        <a href="" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#edit_menu<?= $d->id_menu ?>"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="" class="btn btn-sm
                                                        btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left">Data Sub Menu</h5>
                            <a href="" data-target="#tambah_sub_menu" data-toggle="modal"
                                class="btn btn-info float-right ">Tambah Sub Menu</a>
                        </div>
                        <div class="card-body">
                            <table id="example3" class="table " width="100%">
                                <thead style="background-color: white;">
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Menu</th>
                                        <th>Nama Sub Menu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                foreach ($sub_menu as $d) : ?>
                                    <tr>
                                        <td>
                                            <?= $i++; ?>
                                        </td>
                                        <td>
                                            <?= $d->menu ?>
                                        </td>
                                        <td>
                                            <?= $d->sub_menu; ?>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <a href="" data-toggle="modal" data-target="#edit_sub<?= $d->id_sub_menu ?>"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a href="" class="btn
                                            btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
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
<!-- /.content-wrapper -->
<form action="{{ route('save_submenu') }}" method="post">
    @csrf
    <div class="modal fade" id="tambah_sub_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header btn-info">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Nama Menu</label>
                            <select name="id_menu" id="" class="select2">
                                <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m->id_menu ?>">
                                    <?= $m->menu ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="">Sub Menu</label>
                            <input type="text" name="sub_menu" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Url</label>
                            <input type="text" name="url" class="form-control">
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

<form action="{{route('save_menu')}}" method="post">
    @csrf
    <div class="modal fade" id="tambah_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Nama Menu</label>
                            <input type="text" name="menu" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Icon</label>
                            <input type="text" name="icon" class="form-control">
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
<form action="{{route('save_urutan')}}" method="post">
    @csrf
    <div class="modal fade" id="urutan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Urutan Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Urutan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menu as $a) : ?>
                            <tr>
                                <td>
                                    <?= $a->menu ?>
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="id_menu[]"
                                        value="<?= $a->id_menu ?>">
                                    <input type="text" class="form-control" name="urutan[]" value="<?= $a->urutan ?>">
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>


                    </table>

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
<!-- /.control-sidebar -->
@endsection