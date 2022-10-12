<form action="{{route('save_penyesuaian_stok')}}" method="post">
    @csrf
    <div class="row">
        @foreach ($tgl as $j)

        @php
        $tgl1 = date('Y-m-01',strtotime($j->tgl));
        $tgl2 = date('Y-m-t',strtotime($j->tgl));
        $tgl_ini = date('Y-m-d');


        $jurnal = DB::selectOne("SELECT a.id_akun, min(a.tgl) AS tgl, SUM(a.debit) AS debit , SUM(a.kredit) AS kredit,
        b.qty, b.modal,
        d.nm_akun , e.nm_akun as nm_akun2, e.id_akun as id_akun2
        FROM tb_asset_umum AS a
        LEFT JOIN (SELECT b.id_akun, SUM(b.qty) AS qty , SUM(b.debit) AS modal
        FROM tb_jurnal AS b where b.tgl BETWEEN '2022-01-01' AND '$tgl2' GROUP BY b.id_akun) AS b ON b.id_akun =
        a.id_akun

        LEFT JOIN tb_relasi_akun AS c ON c.id_akun = a.id_akun
        LEFT JOIN tb_akun AS d ON d.id_akun = a.id_akun
        LEFT JOIN tb_akun AS e ON e.id_akun = c.id_relation_debit
        WHERE a.id_akun = '$j->id_akun' AND a.tgl BETWEEN '2022-01-01' AND '$tgl2'
        GROUP BY a.id_akun");
        @endphp

        <?php if($tgl2 > $tgl_ini): ?>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Tanggal</label>
            <input type="text" class="form-control" name="tgl[]" value="Belum bisa disesuaikan" disabled>
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Qty program</label>
            <input type="text" class="form-control stk_program_umum{{$j->id_akun}}"
                value="{{$jurnal->debit - $jurnal->kredit}}" readonly disabled>
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Qty aktual</label>
            <input type="text" name="qty_aktual[]" class="form-control stk_aktual_umum stk_aktual_umum{{$j->id_akun}}"
                id_akun="{{$j->id_akun}}" disabled value="">
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Selisih</label>
            <input type="text" name="selisih[]" class="form-control selisih{{$j->id_akun}}" readonly>
            <input type="hidden" class="form-control h_satuan{{$j->id_akun}}" value="{{$jurnal->modal/$jurnal->qty }}"
                readonly disabled>
        </div>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Akun</label>
            <input type="text" class="form-control" value="{{$jurnal->nm_akun2}}" readonly>
            <input type="hidden" class="form-control" name="id_akun[]" value="{{$jurnal->id_akun2}}" readonly disabled>
        </div>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Debit</label>
            <input type="text" name="debit[]" class="form-control debit{{$j->id_akun}}" value="" readonly disabled>
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Akun</label>
            <input type="text" class="form-control" name="nm_akun[]" value="{{$jurnal->nm_akun}}" readonly disabled>
            <input type="hidden" class="form-control" name="id_akun2[]" value="{{$j->id_akun}}" readonly disabled>
        </div>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Kredit</label>
            <input type="text" class="form-control debit{{$j->id_akun}}" value="" readonly disabled>
        </div>
        <?php else: ?>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Tanggal</label>
            <input type="date" class="form-control" name="tgl[]" value="{{date('Y-m-t',strtotime($j->tgl))}}">
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Qty program</label>
            <input type="text" class="form-control stk_program_umum{{$j->id_akun}}"
                value="{{$jurnal->debit - $jurnal->kredit}}" readonly>
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Qty aktual</label>
            <input type="text" name="qty_aktual[]" class="form-control stk_aktual_umum stk_aktual_umum{{$j->id_akun}}"
                id_akun="{{$j->id_akun}}">
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Selisih</label>
            <input type="text" name="selisih[]" class="form-control selisih{{$j->id_akun}}" readonly>
            <input type="hidden" class="form-control h_satuan{{$j->id_akun}}" value="{{$jurnal->modal/$jurnal->qty }}"
                readonly>
        </div>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Akun</label>
            <input type="text" class="form-control" value="{{$jurnal->nm_akun2}}" readonly>
            <input type="hidden" class="form-control" name="id_akun[]" value="{{$jurnal->id_akun2}}" readonly>
        </div>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Debit</label>
            <input type="text" name="debit[]" class="form-control debit{{$j->id_akun}}" value="" readonly>
        </div>
        <div class="col-lg-1 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Akun</label>
            <input type="text" class="form-control" name="nm_akun[]" value="{{$jurnal->nm_akun}}" readonly>
            <input type="hidden" class="form-control" name="id_akun2[]" value="{{$j->id_akun}}" readonly>
        </div>
        <div class="col-lg-2 mt-2">
            <label for="" style="white-space: nowrap; font-size: 13px">Kredit</label>
            <input type="text" class="form-control debit{{$j->id_akun}}" value="" readonly>
        </div>
        <?php endif ?>

        @endforeach


        <br>
        <br>
        <br>

        <div class="col-lg-12">
            <hr>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-costume float-right" action="">Edit/Save</button>
        </div>

    </div>



</form>