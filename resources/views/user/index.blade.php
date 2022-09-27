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
                        <h5 class="float-left">{{$title}}</h5>
                        <a href="" data-toggle="modal" data-target="#tambah"
                            class="btn btn-costume btn-sm float-right mr-1"><i class="fas fa-plus"></i> Tambah
                            User</a>
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
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Aktiv</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i=1;
                                            @endphp
                                            @foreach ($user as $u)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$u->name}}</td>
                                                <td>{{$u->email}}</td>
                                                <td>{{$u->nm_role}}</td>
                                                <td>{{$u->is_active == '1' ? 'Aktiv':'Tidak Aktiv'}}</td>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#akses"
                                                        id="<?= $u->id; ?>" class="btn btn-costume btn-sm permission"><i
                                                            class="fas fa-key"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-costume btn-sm"><i
                                                            class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="" class="btn btn-sm btn-danger"> <i
                                                            class="fas fa-trash-alt"></i></a>
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

<form action="{{route('updatepermission')}}" method="post">
    @csrf
    <div class="modal fade" id="akses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header btn-info">
                    <h5 class="modal-title" id="exampleModalLabel">Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="data_permission"></div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Edit/Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
            $('.permission').click(function() {
                var id = $(this).attr('id');
            

                $.ajax({
                    url: "{{ route('permission') }}",
                    method: "Get",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#data_permission').html(data);
                    }
                });

            });
        });
</script>



<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>



<!-- /.control-sidebar -->
@endsection