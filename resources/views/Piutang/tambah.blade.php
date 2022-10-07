<div class="row" id="row{{$count}}">
    <div class="col-lg-3 mt-2">

        <select name="" id="" class="select form-control">
            <option value="">--Pilih Akun--</option>
            @foreach ($akun as $a)
            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 mt-2">

        <input type="text" class="form-control debit" value="0">
    </div>
    <div class="col-lg-2 mt-2">

        <input type="text" class="form-control kredit" value="0">
    </div>
    <div class="col-lg-3 mt-2">

        <input type="text" class="form-control">
    </div>
    <div class="col-lg-1 mt-2">

        <button type="button" class=" btn btn-sm btn-danger remove" count="{{$count}}"><i
                class="fas fa-minus"></i></button>
    </div>
</div>