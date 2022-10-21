<label for="">Tanggal</label>
<input type="date" name="tgl" class="form-control mb-4" style="width: 200px;" required>
<label for="" style="font-weight: bold; font-size: larger; color: #787878;">Kas </label>
<table width="100%" class="table">
    <thead>
        <tr>
            <th>CFM Invoice</th>
            <th>Nama Customer</th>
            <th>Akun</th>
            <th>Keterangan</th>
            <th>Total Kg</th>
            <th>Harga</th>
            <th>Total Rp</th>
            <th>Total Rp / Invoce</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = 0;
        @endphp
        @foreach ($nota as $n)
        @php
        $invoice = DB::selectOne("SELECT a.no_nota as nota_telur, b.id_akun, d.nm_post, a.urutan, b.no_nota,
        b.tgl,c.nm_akun,
        b.debit
        FROM invoice_telur AS a
        LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('T-',a.no_nota)
        LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
        LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post
        WHERE b.id_buku = '1' AND b.id_akun = '33' AND b.setor = 'T' and b.no_nota = '$n'
        GROUP BY a.no_nota
        order by a.id_invoice_telur ASC");

        $ket = DB::select("SELECT a.no_nota, b.jenis, a.pcs, a.kg_jual, a.rupiah,a.rp_kg
        From invoice_telur as a
        LEFT JOIN tb_jenis_telur AS b ON b.id = a.id_jenis_telur
        where concat('T-',a.no_nota) = '$n'
        ")
        @endphp

        @if (empty($invoice))

        @else
        <tr>
            <td style="vertical-align: middle;">{{$n}}</td>
            <td style="vertical-align: middle;">{{$invoice->nm_post}} {{$invoice->urutan}}</td>
            <td style="vertical-align: middle;">{{$invoice->nm_akun}}</td>
            <td>
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{$k->jenis}} <br>
                @endforeach
            </td>
            <td style="text-align: right">
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{$k->kg_jual}} <br>
                @endforeach
            </td>
            <td style="text-align: right">
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{number_format($k->rupiah,0)}} <br>
                @endforeach
            </td>
            <td style="text-align: right">
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{number_format($k->rp_kg,0)}} <br>
                @endforeach
            </td>
            <td style="text-align: right; vertical-align: middle;">{{number_format($invoice->debit,0)}}</td>
        </tr>
        @php
        $total += $invoice->debit;
        @endphp
        @endif

        @endforeach
    </tbody>
    <tfoot>
        <tr class="bg-costume">
            <th colspan="6"></th>
            <th>Total</th>
            <th style="text-align: right;">{{number_format($total,0)}}</th>
        </tr>
    </tfoot>




</table>
<br>
<br>
<label for="" style="font-weight: bold; font-size: larger; color: #787878;">BCA </label>
<table width="100%" class="table">
    <thead>
        <tr>
            <th>CFM Invoice</th>
            <th>Nama Customer</th>
            <th>Akun</th>
            <th>Keterangan</th>
            <th>Total Kg</th>
            <th>Harga</th>
            <th>Total Rp</th>
            <th>Total Rp / Invoce</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = 0;
        @endphp
        @foreach ($nota as $n)
        @php
        $invoice = DB::selectOne("SELECT a.no_nota as nota_telur, b.id_akun, d.nm_post, a.urutan, b.no_nota,
        b.tgl,c.nm_akun,
        b.debit
        FROM invoice_telur AS a
        LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('T-',a.no_nota)
        LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
        LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post
        WHERE b.id_buku = '1' AND b.id_akun = '32' AND b.setor = 'T' and b.no_nota = '$n'
        GROUP BY a.no_nota
        order by a.id_invoice_telur ASC");

        $ket = DB::select("SELECT a.no_nota, b.jenis, a.pcs, a.kg_jual, a.rupiah,a.rp_kg
        From invoice_telur as a
        LEFT JOIN tb_jenis_telur AS b ON b.id = a.id_jenis_telur
        where concat('T-',a.no_nota) = '$n'
        ")
        @endphp

        @if (empty($invoice))

        @else
        <tr>
            <td style="vertical-align: middle;">{{$n}}</td>
            <td style="vertical-align: middle;">{{$invoice->nm_post}} {{$invoice->urutan}}</td>
            <td style="vertical-align: middle;">{{$invoice->nm_akun}}</td>
            <td>
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{$k->jenis}} <br>
                @endforeach
            </td>
            <td style="text-align: right">
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{$k->kg_jual}} <br>
                @endforeach
            </td>
            <td style="text-align: right">
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{number_format($k->rupiah,0)}} <br>
                @endforeach
            </td>
            <td style="text-align: right">
                @foreach ($ket as $k)
                @if ($k->kg_jual == 0)
                @php
                continue;
                @endphp
                @endif
                {{number_format($k->rp_kg,0)}} <br>
                @endforeach
            </td>
            <td style="text-align: right; vertical-align: middle;">{{number_format($invoice->debit,0)}}</td>
        </tr>
        @php
        $total += $invoice->debit;
        @endphp
        @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr class="bg-costume">
            <th colspan="6"></th>
            <th>Total</th>
            <th style="text-align: right;">{{number_format($total,0)}}</th>
        </tr>
    </tfoot>




</table>