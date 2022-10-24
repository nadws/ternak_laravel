<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table" id="detail_list_orderan_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Nota</th>
                            <th>Akun</th>
                            <th style="text-align: right">Debit</th>
                            <th style="text-align: right">Kredit</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no =1;
                        @endphp
                        @foreach ($no_nota as $n)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{date('d-m-Y',strtotime($n->tgl))}}</td>
                            <td>{{$n->no_nota}}</td>
                            <td>{{$n->nm_akun}}</td>
                            <td style="text-align: right">{{number_format($n->debit,0)}}</td>
                            <td style="text-align: right">{{number_format($n->kredit,0)}}</td>
                            <td>{{$n->admin}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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
    $(function() {
        $("#detail_list_orderan_table").DataTable({
            // "paging": true,
            "bSort": true,
            "paging": true,
            "stateSave": true,
            "scrollCollapse": true,
            // "order": [[ 1, 'desc' ]],
            "fixedHeader": true,
        });
     });
</script>