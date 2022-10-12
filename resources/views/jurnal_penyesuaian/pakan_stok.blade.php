<form action="{{route('save_pv')}}" method="post">
    @csrf
    <div class="row">

        <div class="col-lg-2">
            <label for="">Tanggal </label>
            <input type="date" name="tgl_pv" class="form-control" id="" value="{{$tgl}}">
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="nm_akun_debit_pv" value="{{$akun->akun2}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_debit_pv" value="{{$akun->id_relation_debit}}" class="form-control" id=""
                readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Debit</label>
            <input type="text" name="debit_pv" class="form-control ttl_debit_p" id="" readonly>
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="nm_akun_kredit_pv" value="{{$akun->nm_akun}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_kredit_pv" value="{{$akun->id_akun}}" class="form-control" id=""
                readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Kredit</label>
            <input type="text" name="kredit_pv" class="form-control ttl_debit_p" id="" readonly>
        </div>

    </div>
    <br>
    <br>
    <div class="row justify-content-center mt-6">
        <div class="col-lg-2">
            <label for="">Nama Barang</label>
        </div>
        <div class="col-lg-2">
            <label for="">Qty Program</label>
        </div>
        <div class="col-lg-2">
            <label for="">Qty aktual</label>
        </div>
        <div class="col-lg-2">
            <label for="">Selisih</label>
        </div>
        <div class="col-lg-2">
            <label for="">Harga satuan</label>
        </div>
        <div class="col-lg-2">
            <label for="">Total</label>
        </div>

        @foreach ($barang as $b)
        <div class="col-lg-2 mb-2">
            <input type="text" class="form-control" value="{{$b->nm_barang}}" readonly>
            <input type="hidden" name="id_barang[]" class="form-control" value="{{$b->id_barang}}" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control qty_a_pv{{$b->id_barang}}" value="{{$b->debit - $b->kredit}}"
                readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="qty_pv[]" class="form-control qty_aktual_pv qty_aktual_pv{{$b->id_barang}}"
                id_barang="{{$b->id_barang}}" value="0">
        </div>
        <div class="col-lg-2">
            <input type="text" value="0" name="selisih_pv[]" class="form-control slsh_pv{{$b->id_barang}}" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="h_satuan_pv[]" value="{{round($b->d_jurnal/$b->qty,0)}}"
                class="form-control h_satuan_pv{{$b->id_barang}}" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="ttl_rp_pv[]" class="form-control ttl_pv  ttl_pv{{$b->id_barang}}" value="0"
                readonly>
        </div>
        @endforeach




    </div>

    <br>
    <br>
    <br>
    <div class="row mt-6">
        <div class="col-lg-12">
            <hr>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-costume float-right" action="">Edit/Save</button>
        </div>
    </div>
</form>