@if (empty($nota))
<center>
    <div class="modal-body">
        <br>
        <img src="{{asset('assets')}}/img/no-data.svg" width="200px" alt="">
        <h3 class="mt-2">Data tidak ditemukan</h3>
    </div>
    <div class="modal-footer">
        <button type="submit" id="btn_bayar" disabled class="btn btn-costume">Edit/Save</button>
    </div>

</center>
@else
<div class="modal-body">
    <label for="">Tanggal</label>
    <input type="date" name="tgl" class="form-control mb-4" style="width: 200px;" required>
    <label for="" style="font-weight: bold; font-size: larger; color: #629779;">Kas </label>
    <table width="100%" class="table table-bordered">
        <thead class="bg-costume">
            <tr>
                <th>CFM Invoice</th>
                <th>Nama Customer</th>
                <th>Akun</th>
                <th style="text-align: right">Total Rp</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            @endphp
            @foreach ($nota as $n)
            @php
            $invoice = DB::selectOne("SELECT a.no_nota as nota_ayam, b.id_akun, d.nm_post, a.urutan, b.no_nota,
            b.tgl,c.nm_akun,
            b.debit
            FROM invoice_ayam AS a
            LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('A-',a.no_nota)
            LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
            LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post
            WHERE b.id_buku = '1' AND b.id_akun = '33' AND b.setor = 'T' and b.no_nota = '$n'
            GROUP BY a.no_nota
            order by a.id_invoice_ayam ASC");

            @endphp

            @if (empty($invoice))

            @else
            <tr>
                <td style="vertical-align: middle;">{{$n}}</td>
                <td style="vertical-align: middle;">{{$invoice->nm_post}} {{$invoice->urutan}}</td>
                <td style="vertical-align: middle;">{{$invoice->nm_akun}}</td>
                <td style="text-align: right; vertical-align: middle;">
                    {{number_format($invoice->debit,0)}}

                    <input type="hidden" name="no_nota[]" value="{{$n}}">
                    <input type="hidden" name="debit[]" value="{{$invoice->debit}}">
                    <input type="hidden" name="id_akun[]" value="{{$invoice->id_akun}}">
                </td>
            </tr>
            @php
            $total += $invoice->debit;
            @endphp
            @endif

            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-costume">
                <th colspan="2"></th>
                <th style="text-align: right">Total</th>
                <th style="text-align: right;">{{number_format($total,0)}}</th>
            </tr>
        </tfoot>
    </table>
    <br>
    <br>
    <label for="" style="font-weight: bold; font-size: larger; color: #629779;">BCA </label>
    <table width="100%" class="table table-bordered">
        <thead class="bg-costume">
            <tr>
                <th>CFM Invoice</th>
                <th>Nama Customer</th>
                <th>Akun</th>
                <th style="text-align: right">Total Rp / Invoce</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            @endphp
            @foreach ($nota as $n)
            @php
            $invoice = DB::selectOne("SELECT a.no_nota as nota_ayam, b.id_akun, d.nm_post, a.urutan, b.no_nota,
            b.tgl,c.nm_akun,
            b.debit
            FROM invoice_ayam AS a
            LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('A-',a.no_nota)
            LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
            LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post
            WHERE b.id_buku = '1' AND b.id_akun = '32' AND b.setor = 'T' and b.no_nota = '$n'
            GROUP BY a.no_nota
            order by a.id_invoice_ayam ASC");
            @endphp

            @if (empty($invoice))

            @else
            <tr>
                <td style="vertical-align: middle;">{{$n}}</td>
                <td style="vertical-align: middle;">{{$invoice->nm_post}} {{$invoice->urutan}}</td>
                <td style="vertical-align: middle;">{{$invoice->nm_akun}}</td>
                <td style="text-align: right; vertical-align: middle;">
                    {{number_format($invoice->debit,0)}}
                    <input type="hidden" name="no_nota[]" value="{{$n}}">
                    <input type="hidden" name="debit[]" value="{{$invoice->debit}}">
                    <input type="hidden" name="id_akun[]" value="{{$invoice->id_akun}}">
                </td>
            </tr>
            @php
            $total += $invoice->debit;
            @endphp
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-costume">
                <th colspan="2"></th>
                <th style="text-align: right">Total</th>
                <th style="text-align: right;">{{number_format($total,0)}}</th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal-footer">
    <button type="submit" id="btn_bayar" class="btn btn-costume">Edit/Save</button>
</div>

@endif