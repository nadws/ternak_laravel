<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nota</th>
                <th>Customer</th>
                <th>Piutang</th>
                <th width="20%">Dibayar</th>
            </tr>
        </thead>
        <tbody>
            @php
            $ttl=0;
            @endphp
            <?php for ($x = 0;  $x<count($nota); $x++): ?>
            @php
            $hutang = DB::selectOne("SELECT a.tgl, a.id_post, a.no_nota, sum(a.debit) AS debit, sum(a.kredit) AS kredit,
            c.nm_post,
            b.urutan, a.admin, b.no_nota as nota_invo
            FROM tb_jurnal AS a
            LEFT JOIN (SELECT b.no_nota, b.urutan, b.id_post FROM invoice_telur AS b GROUP BY b.no_nota ) AS
            b ON
            concat('P-',b.no_nota) = a.no_nota
            LEFT JOIN tb_post_center AS c ON c.id_post = b.id_post
            WHERE a.id_akun = '53' and a.no_nota = '$nota[$x]'
            GROUP BY a.no_nota")



            @endphp

            <tr>
                <td>{{date('d-m-Y',strtotime($hutang->tgl))}}</td>
                <td>{{$hutang->no_nota}}</td>
                <td>{{$hutang->nm_post}}{{$hutang->urutan}}</td>
                <td>{{number_format($hutang->debit - $hutang->kredit,0)}}</td>
                <td><input style="text-align: right" type="number" max="{{$hutang->debit - $hutang->kredit}}"
                        name="kredit_bayar[]" class="form-control byr" value="{{$hutang->debit - $hutang->kredit}}">
                </td>
            </tr>

            <input type="hidden" name="no_nota[]" value="{{$nota[$x]}}">
            <input type="hidden" name="kredit[]" value="{{$hutang->debit - $hutang->kredit}}">
            <input type="hidden" name="id_post[]" value="{{$hutang->id_post}}">
            <input type="hidden" name="nota_invo[]" value="{{$hutang->nota_invo}}">
            <?php 
            $ttl+=$hutang->debit - $hutang->kredit;
            endfor ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3"></th>
                <th>Total</th>
                <th style="text-align: right" class="total">{{number_format($ttl,0)}}</th>
                <input type="hidden" class="total2" value="{{$ttl}}">
            </tr>
        </tfoot>
    </table>


</div>

<div class="row">
    <div class="col-lg-3">
        <label for="">Tanggal</label>
        <input type="date" class="form-control" name="tgl" required>
    </div>
    <div class="col-lg-9">

    </div>
    <div class="col-lg-3 mt-2">
        <label for="">Pilih Akun</label>
        <select name="id_akun[]" id="" class="select form-control" required>
            <option value="">--Pilih Akun--</option>
            @foreach ($akun as $a)
            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 mt-2">
        <label for="">Debit</label>
        <input type="text" class="form-control debit" name="debit[]" value="0">
    </div>
    <div class="col-lg-2 mt-2">
        <label for="">Kredit</label>
        <input type="text" class="form-control kredit" name="kredit2[]" value="0">
    </div>
    <div class="col-lg-3 mt-2">
        <label for="">Keterangan</label>
        <input type="text" class="form-control" name="ket[]" required>
    </div>
    <div class="col-lg-1 mt-2">
        <label for="">Aksi</label>
        <button type="button" id="tambah_pembayaran" class="btn btn-sm btn-costume"><i class="fas fa-plus"></i></button>
    </div>

</div>
<div id="tambah">

</div>
<div class="row">
    <div class="col-lg-3 mt-2">
        <label for="">Total</label>
        <input type="text" class="form-control ttl_akhir" value="0">
    </div>
    <div class="col-lg-2 mt-2">
        <label for="">Sisa</label>
        <input type="text" class="form-control sisa" name="sisa" value="{{$ttl}}" readonly>
    </div>
</div>