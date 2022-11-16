<div class="row">
    <div class="col-lg-12">
        <a href="" data-toggle="modal" data-target="#tbh_post" id_akun='<?= $id_akun ?>'
            class="btn btn-costume float-right tbh_post">Tambah Post Center</a>
        <br>
        <br>
        <table class="table" id="tb-history">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Post Center</th>
                    <th>NPWP</th>
                    <th>No Telpon</th>
                    <th>
                        <center>
                            Aksi
                        </center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($post_center as $p) : ?>
                <tr>
                    <td>
                        <?= $i++ ?>
                    </td>
                    <td>
                        <?= $p->nm_post ?>
                    </td>
                    <td>
                        <?= $p->npwp ?>
                    </td>
                    <td>
                        <?= $p->no_telpon ?>
                    </td>
                    <td>
                        <center>
                            <a href="" data-toggle="modal" data-target="#edit" id_post="<?= $p->id_post ?>"
                                class="btn btn-sm btn-costume btn_edit"><i class="fas fa-edit"></i></a>
                            <a href="#" id_post="<?= $p->id_post ?>" id_akun2='<?= $id_akun ?>'
                                class="btn btn-sm btn-danger delete_post"><i class="fas fa-trash-alt"></i></a>
                        </center>

                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script>
    $("#tb-history").DataTable({
        "lengthChange": false,
        "autoWidth": false,
        "stateSave": true,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>