<?php
$file = "Export_telur.xls";
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
            <th>No</th>
            <th>Bulan</th>
            <th>Tanggal</th>
            @foreach ($jenis as $j)
            <th>Pcs {{$j->jenis}}</th>
            <th>Kg {{$j->jenis}} <br> (+rak)</th>
            <th>Kg rak</th>
            <th>Kg {{$j->jenis}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
        $i = 1;
        @endphp
        @foreach ($telur as $t)
        <tr>
            <td>{{$i++}}</td>
            <td>{{date('M-Y',strtotime($t->tgl))}}</td>
            <td>{{date('d-M-Y',strtotime($t->tgl))}}</td>
            @foreach ($jenis as $j)
            @php
            $t_jenis = DB::selectOne("SELECT a.tgl, SUM(a.pcs) AS pcs, SUM(a.kg) AS kg
            FROM tb_telur AS a
            WHERE a.id_jenis ='$j->id' and a.tgl = '$t->tgl'
            GROUP BY a.tgl, a.id_jenis")
            @endphp
            <td>{{empty($t_jenis->pcs) ? '0' : $t_jenis->pcs}}</td>
            <td>{{empty($t_jenis->kg) ? '0' : $t_jenis->kg}}</td>
            <td>{{ empty($t_jenis->pcs) ? '0' : round($t_jenis->pcs / 180,2)}}</td>
            <td>{{empty($t_jenis->pcs) ? '0' : round($t_jenis->kg - ($t_jenis->pcs / 180),2)}}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th>Total</th>
            @foreach ($jenis as $j)
            @php
            $t_jenis2 = DB::selectOne("SELECT a.tgl, SUM(a.pcs) AS pcs, SUM(a.kg) AS kg
            FROM tb_telur AS a
            WHERE a.id_jenis ='$j->id' and a.tgl between '$tgl1' and '$tgl2'
            group by a.id_jenis")
            @endphp
            <th>{{$t_jenis2->pcs}}</th>
            <th>{{$t_jenis2->kg}}</th>
            <th>{{ round($t_jenis2->pcs / 180,2)}}</th>
            <th>{{round($t_jenis2->kg - ($t_jenis2->pcs / 180),2)}}</th>
            @endforeach
        </tr>
    </tfoot>

</table>