<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>print</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets') }}/menu/img/agrilaras.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
    <div class="row">
        <div class="col-lg-12">

            <h5 class="text-center"><u>AGRI LARAS</u></h5>
        </div>
        <br>
        <br>
        <div class="col-lg-6">
            <table width="100%">
                <tr>
                    <th>Admin</th>
                    <th>:</th>
                    <th>{{$jurnal2->admin}}</th>
                </tr>
                <tr>
                    <th>No Nota</th>
                    <th>:</th>
                    <th>{{$jurnal2->no_nota}}</th>
                </tr>
            </table>
        </div>
        <div class="col-lg-6">
            <table width="100%">
                <th>Tanggal</th>
                <th>:</th>
                <th>{{$jurnal2->tgl}}</th>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div class="col-lg-12">
            <table class="table table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>Post Akun</th>
                        <th>Keterangan</th>
                        <th>Debit</th>
                        <th>kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurnal as $j)
                    <tr>
                        <td>{{$j->nm_akun}}</td>
                        <td>{{$j->ket}}</td>
                        <td>{{number_format($j->debit,0)}}</td>
                        <td>{{number_format($j->kredit,0)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <br>
        <div class="col-lg-4" style="font-weight: bold">
            <center>Customer</center>
            <br>
            <br>
            <br>
            <br>
            <br>
            <center>
                (..................)
            </center>
        </div>
        <div class="col-lg-4" style="font-weight: bold">
            <center>Diterima</center>
            <br>
            <br>
            <br>
            <br>
            <br>
            <center>
                (..................)
            </center>
        </div>
        <div class="col-lg-4" style="font-weight: bold">
            <center>Mengetahui</center>
            <br>
            <br>
            <br>
            <br>
            <br>
            <center>
                (..................)
            </center>
        </div>
    </div>
    <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
      $('.modal').on('hidden.bs.modal', function() {
        //If there are any visible
        if ($(".modal:visible").length > 0) {
          //Slap the class on it (wait a moment for things to settle)
          setTimeout(function() {
            $('body').addClass('modal-open');
          }, 200)
        }
      });
    })
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script src="{{ asset('assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets') }}/dist/js/demo.js"></script>
    <script
        src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $(function() {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
        });
        $('#example3').DataTable({
            // "paging": true,
            "bSort": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true,
            // "order": [[ 1, 'desc' ]],
            "fixedHeader": true,
        });
        $("#example1").DataTable({
            // "paging": true,
            "bSort": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true,
            // "order": [[ 1, 'desc' ]],
            "fixedHeader": true,
        });
        $('#tb_bkin').DataTable({
            "paging": false,
            "pageLength": 100,
            "scrollY": "350px",
            "lengthChange": false,
            // "ordering": false,
            "info": false,
            "stateSave": true,
            "autoWidth": true,
            // "order": [ 5, 'DESC' ],
            "searching": false,
        });



        //Initialize Select2 Elements
        $('.select2').select2()
        $(function() {
            $('.select').select2()
            $('.select').one('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Search...');
            });
        })

    });
    </script>
</body>


</html>