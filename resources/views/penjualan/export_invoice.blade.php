<?php
$file = "Export_invoice_telur.xls";
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$file");
?>
<style>
    th,
    td {
        padding: 5px;
    }
</style>
<table border="1" style="padding: 80px; border-collapse: collapse">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Bulan</th>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Customer</th>
            <th rowspan="2">Customer2</th>
            <th rowspan="2">Npwp</th>
            <th rowspan="2">No Telpon</th>
            <th rowspan="2">No Nota</th>
            @php
            $n = 1;
            @endphp
            @foreach ($jenis as $j)
            @if ($n++ % 2 == 0)
            <th colspan="4" style="background-color: yellow">{{$j->jenis}}</th>
            @else
            <th colspan="4" style="background-color: #1EE8E8">{{$j->jenis}}</th>
            @endif

            @endforeach
            <th rowspan="2">Total Rp</th>
            <th rowspan="2">Pemabayaran Via</th>
            <th rowspan="2">Cfm bayar</th>
            <th rowspan="2">Status</th>
            <th rowspan="2">Tgl Setor Linda</th>
        </tr>
        <tr>
            @php
            $no = 1;
            @endphp
            @foreach ($jenis as $j)
            @if ($no++ % 2 == 0)
            <th style="background-color: yellow">Pcs</th>
            <th style="background-color: yellow">Kg + Rak</th>
            <th style="background-color: yellow">Kg Jual</th>
            <th style="background-color: yellow">Harga Satuan</th>
            @else
            <th style="background-color: #1EE8E8">Pcs</th>
            <th style="background-color: #1EE8E8">Kg + Rak</th>
            <th style="background-color: #1EE8E8">Kg Jual</th>
            <th style="background-color: #1EE8E8">Harga Satuan</th>
            @endif

            @endforeach

        </tr>
    </thead>
    <tbody>

        @php
        $i =1;
        @endphp
        @foreach ($invoice as $n)
        <tr>
            <td>{{$i++}}</td>
            <td>{{date('m',strtotime($n->tgl))}}</td>
            <td>{{$n->tgl}}</td>
            <td>{{$n->nm_post}}</td>
            <td>{{$n->nm_post}} {{$n->urutan}}</td>
            <td>{{$n->npwp}}</td>
            <td>{{$n->no_telpon}}</td>
            <td>T-{{$n->no_nota}}</td>

            @foreach ($jenis as $j)
            @php
            $telur = DB::selectOne("SELECT *
            FROM invoice_telur AS a
            WHERE a.no_nota = '$n->no_nota' and a.id_jenis_telur = '$j->id'")
            @endphp
            <td>{{$telur->pcs}}</td>
            <td>{{$telur->kg}}</td>
            <td>{{$telur->kg_jual}}</td>
            <td>{{$telur->rupiah}}</td>
            @endforeach
            <td>{{$n->rupiah}}</td>
            <td>{{$n->nm_akun}}</td>
            <td>{{$n->nota_setor}}</td>
            <td>{{$n->lunas == 'Y' ? 'Paid' : 'Unpaid' }}</td>
            <td>{{$n->tgl_setor}}</td>

        </tr>
        @endforeach
    </tbody>
</table>