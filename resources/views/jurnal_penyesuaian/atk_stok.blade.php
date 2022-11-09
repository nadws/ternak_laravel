<form action="{{route('save_penyesuaian_atk')}}" method="post">
    @csrf
    <div class="row">

        <div class="col-lg-2">
            <label for="">Tanggal </label>
            <input type="date" name="tgl_atk" class="form-control" id="" value="{{$tgl}}">
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="nm_akun_debit_atk" value="{{$akun->akun2}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_debit_atk" value="{{$akun->id_relation_debit}}" class="form-control"
                id="" readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Debit</label>
            <input type="text" name="debit_atk" class="form-control ttl_debit_p" id="" readonly>
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="nm_akun_kredit_atk" value="{{$akun->nm_akun}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_kredit_atk" value="{{$akun->id_akun}}" class="form-control" id=""
                readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Kredit</label>
            <input type="text" name="kredit_atk" class="form-control ttl_debit_p" id="" readonly>
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
            <input type="text" class="form-control" value="{{$b->nm_post}}" readonly>
            <input type="hidden" name="id_post[]" class="form-control" value="{{$b->id_post}}" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control qty_atk{{$b->id_post}}" value="{{$b->qty_debit - $b->qty_kredit}}"
                readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="qty_atk[]" class="form-control qty_atk_aktual qty_atk_aktual{{$b->id_post}}"
                id_atk="{{$b->id_post}}" value="0">
        </div>
        <div class="col-lg-2">
            <input type="text" value="0" name="selisih_atk[]" class="form-control slsh_atk{{$b->id_post}}" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="h_satuan_atk[]" value="{{round($b->h_satuan,0)}}"
                class="form-control h_satuan_atk{{$b->id_post}}" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="ttl_rp_atk[]" class="form-control ttl_atk  ttl_atk{{$b->id_post}}" value="0"
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