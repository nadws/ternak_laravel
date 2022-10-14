<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; AgrikaGroup 2022. </strong>
    All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- jQuery -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>

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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js">
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
@yield('script')
</body>

</html>