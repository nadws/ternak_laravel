<form action="{{route('save_aktiva')}}" method="post">
    @csrf
    <div class="row">
        @php
        $total = 0;
        @endphp
        @foreach ($aktiva as $a)
        @php
        $total += $a->b_penyusutan;
        @endphp
        @endforeach

        <div class="col-lg-2">
            <label for="">Tanggal </label>
            <input type="date" name="tgl" class="form-control" id="" value="{{$tgl}}">
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="nm_akun_debit" value="{{$akun->akun2}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_debit" value="{{$akun->id_relation_debit}}" class="form-control" id=""
                readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Debit</label>
            <input type="text" style="text-align: right" name="debit" class="form-control ttl_debit_p"
                value="{{$total}}" id="" readonly>
        </div>
        <div class="col-lg-3">
            <label for="">Akun</label>
            <input type="text" name="nm_akun_kredit" value="{{$akun->nm_akun}}" class="form-control" id="" readonly>
            <input type="hidden" name="id_akun_kredit" value="{{$akun->id_akun}}" class="form-control" id="" readonly>
        </div>
        <div class="col-lg-2">
            <label for="">Kredit</label>
            <input type="text" style="text-align: right" name="kredit" class="form-control ttl_debit_p"
                value="{{$total}}" id="" readonly>
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-lg-2">
            <label for="">Tanggal</label>
        </div>
        <div class="col-lg-3">
            <label for="">Barang</label>
        </div>
        <div class="col-lg-3">
            <label for="">Nilai Buku</label>
        </div>
        <div class="col-lg-3">
            <label for="">Biaya Penyusutan</label>
        </div>

        @foreach ($aktiva as $a)
        <div class="col-lg-2 mt-2">
            <input type="date" class="form-control" value="{{$a->tgl}}" readonly>
        </div>
        <div class="col-lg-3 mt-2">
            <input type="text" class="form-control" value="{{$a->nm_post}}" readonly>
        </div>
        <div class="col-lg-3 mt-2">
            <input type="text" style="text-align: right" class="form-control" value="{{$a->debit - $a->kredit}}"
                readonly>
        </div>
        <div class="col-lg-3 mt-2">
            <input type="text" style="text-align: right" name="b_penyusutan[]" class="form-control"
                value="{{$a->b_penyusutan}}">
            <input type="hidden" style="text-align: right" name="id_post[]" class="form-control"
                value="{{$a->id_post}}">
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