<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>CFM Setor</th>
            <th>Post Akun</th>
            <th style="text-align: right">Total Rp</th>
            <th style="text-align: center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list as $l)
        <tr>
            <td>{{date('d-m-Y',strtotime($l->tgl))}}</td>
            <td>{{$l->nota_setor}}</td>
            <td>{{$l->nm_akun}}</td>
            <td style="text-align: right">Rp.{{number_format($l->debit,0)}}</td>
            <td style="text-align: center">

                <button type="button" data-toggle="modal" data-target="#view_list"
                    class="btn btn-sm btn-costume view_list" nota="{{$l->nota_setor}}"><i class="fas fa-search"></i>
                </button>

                <a href="" class="btn btn-sm btn-costume"><i class="fas fa-print"></i></a>
                <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>