<form action="{{route('save_penyesuaian_stok')}}" method="post">
    @csrf
    <div class="row">

        <div class="col-lg-2">
            <label for="">Tanggal </label>
            <input type="date" name="tgl_pakan" class="form-control" id="" value="">
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="" value="{{$akun->akun2}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_debit_pakan" value="{{$akun->id_relation_debit}}" class="form-control"
                id="" readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Debit</label>
            <input type="text" name="debit_pakan" class="form-control ttl_debit_p" id="" readonly>
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="" value="{{$akun->nm_akun}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_kredit_pakan" value="{{$akun->id_akun}}" class="form-control" id=""
                readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Kredit</label>
            <input type="text" name="kredit_pakan" class="form-control ttl_debit_p" id="" readonly>
        </div>

    </div>
    <br>
    <br>
    <div class="row justify-content-center mt-6">
        <div class="col-lg-2">
            <label for="">Nama Pakan</label>
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

        <div class="col-lg-2 mb-2">
            <input type="text" class="form-control" value="Sirad B 204 SG" readonly>
            <input type="hidden" name="id_pakan[]" class="form-control" value="" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control qty_p_pro" value="7166" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="qty_pakan[]" class="form-control qty_p_aktual qty_ak_p" id_pakan="" value="0">
        </div>
        <div class="col-lg-2">
            <input type="text" value="0" name="selisih_pakan[]" class="form-control slsh_p" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="h_satuan_pakan[]" value="6287" class="form-control h_satuan_p" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control ttl_pakan tl_pakan" value="0" readonly>
        </div>

        <div class="col-lg-2 mb-2">
            <input type="text" class="form-control" value="Pokpan 524 Alfa" readonly>
            <input type="hidden" name="id_pakan[]" class="form-control" value="" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control qty_p_pro" value="3367" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="qty_pakan[]" class="form-control qty_p_aktual qty_ak_p" id_pakan="" value="0">
        </div>
        <div class="col-lg-2">
            <input type="text" value="0" name="selisih_pakan[]" class="form-control slsh_p" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" name="h_satuan_pakan[]" value="7000" class="form-control h_satuan_p" readonly>
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control ttl_pakan tl_pakan" value="0" readonly>
        </div>



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