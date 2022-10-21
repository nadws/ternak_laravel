<div class="row" id="row{{$count}}">
    <div class="col-lg-5"></div>
    <div class="col-lg-3 mb-2">
        <select name="id_akun[]" id="" class="form-control select" required>
            <option value="">--Pilih Akun--</option>
            <option value="{{$akun->id_akun}}">{{$akun->nm_akun}}</option>
            @foreach ($akun2 as $a)
            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 mb-2">
        <input type="text" name="debit[]" class="form-control bayar" style="text-align: right" required>
    </div>
    <div class="col-lg-1 mb-2">
        <button type="button" class="btn btn-danger btn-sm remove" count="{{$count}}"><i
                class="fas fa-minus"></i></button>
    </div>
</div>