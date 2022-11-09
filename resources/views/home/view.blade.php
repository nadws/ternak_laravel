<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 style="color: #629779">Akun : {{$akun->nm_akun}}</h5>
                <h5 style="color: #629779">Bulan : {{$bulan}}-{{$tahun}}</h5>
            </div>
            <div class="card-body">
                <table class="table" id="detail_list_orderan_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Nota</th>
                            <th>Post Akun</th>
                            <th>Post Center</th>
                            <th>Keterangan</th>
                            <th style="text-align: right">Debit</th>
                            <th style="text-align: right">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($jurnal as $j)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{date('d-m-Y',strtotime($j->tgl))}}</td>
                            <td>{{$j->no_nota}}</td>
                            <td>{{$j->nm_akun}}</td>
                            <td>{{$j->nm_post}}</td>
                            <td>{{$j->ket}}</td>
                            <td align="right">{{number_format($j->debit,0)}}</td>
                            <td align="right">{{number_format($j->kredit,0)}}</td>
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