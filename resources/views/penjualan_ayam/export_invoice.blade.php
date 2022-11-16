<?php
$file = "Export_invoice_ayam.xls";
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$file");
?>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Customer2</th>
            <th>NPWP</th>
            <th>No Telpon</th>
            <th>No Nota</th>
            <th>Ekor</th>
            <th>Berat Kg</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Tgl Bayar</th>
            <th>Pembayaran Via</th>
            <th>CFM Bayar</th>
            <th>Tgl Setor Linda</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i =1;
        @endphp
        @foreach ($ayam as $a)
        <tr>
            <td>{{$i++}}</td>
            <td>{{date('m',strtotime($a->tgl))}}</td>
            <td>{{date('d-m-Y',strtotime($a->tgl))}}</td>
            <td>{{$a->nm_post}}</td>
            <td>{{$a->nm_post}} {{$a->urutan}}</td>
            <td>{{$a->npwp}}</td>
            <td>{{$a->no_telpon}}</td>
            <td>A-{{$a->no_nota}}</td>
            <td>{{$a->ekor}}</td>
            <td>{{$a->berat}}</td>
            <td>{{$a->harga}}</td>
            <td>{{$a->ttl_harga}}</td>
            <td>{{date('d-m-Y',strtotime($a->tgl_setor))}}</td>
            <td>{{$a->nm_akun}}</td>
            <td>{{$a->nota_setor}}</td>
            <td>{{date('d-m-Y',strtotime($a->tgl_setor))}}</td>
        </tr>
        @endforeach
    </tbody>
</table>