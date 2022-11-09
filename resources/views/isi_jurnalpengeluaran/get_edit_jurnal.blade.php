<form action="{{ route('edit_jurnal_biaya') }}" method="post">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="list_kategori">Tanggal</label>
                    <input class="form-control" type="date" name="tgl" id="tgl_peng"
                        value="{{date('Y-m-d' ,strtotime($kredit->tgl))}}" required>
                    <input type="hidden" name="id_kredit" value="{{ $kredit->id_jurnal }}">
                </div>
            </div>
            <div class="mt-3 ml-1">
                <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="list_kategori">Akun</label>
                    <select name="id_akun" class="form-control select id_debit" required>
                        <option value="">-Pilih Akun-</option>
                        @foreach ($akun as $a)
                        <option value="{{$a->id_akun }}" {{$a->id_akun == $debit->id_akun ? 'selected'
                            :''}}>{{$a->nm_akun}}</option>
                        @endforeach

                    </select>
                </div>

            </div>
            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Debit</label>
                    <input style="text-align: right" type="number" class="form-control  total" name="debit" readonly
                        value="{{$kredit->kredit}}">
                </div>
            </div>
            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Kredit</label>
                    <input type="number" class="form-control" readonly>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">

            </div>

            <div class="mt-1">
                <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
            </div>

            <div class="col-sm-3 col-md-3">

                <div class="form-group">
                    <input type="hidden" class="id_debit_akun">
                    <select name="id_akun_kredit" class="form-control post_atk akun_kredit select" count="1" required>
                        @foreach ($akun as $a)
                        <option value="{{$a->id_akun }}" {{$a->id_akun == $kredit->id_akun ? 'selected' :
                            ''}}>{{$a->nm_akun
                            }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <input type="number" class="form-control" readonly>
                </div>
            </div>
            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <input type="number" style="text-align: right" class="form-control total " name="kredit" readonly
                        value="{{$kredit->kredit}}">
                </div>
            </div>

            <div class="col-sm-3 col-md-3">

            </div>

        </div>
        <hr>
        @foreach ($debit_isi_biaya as $d)
        <input type="hidden" name="id_debit[]" value="{{$d->id_jurnal}}">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">No id</label>
                    <input type="text" class="form-control input_detail input_biaya" name="no_id[]" required
                        value="{{$d->no_id}}">
                    <input type="hidden" name="jenis" value="7" class="input_detail input_biaya">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Keterangan</label>
                    <input type="text" class="form-control input_detail input_biaya" name="keterangan[]"
                        value="{{$d->ket}}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Post Center</label>
                    <select name="id_post_center[]" class="form-control   select input_biaya">
                        <option value="">--Pilih Post Center-- </option>
                        @foreach ($post_center as $p)
                        <option value="{{$p->id_post}}" {{$d->id_post == $p->id_post ? 'selected' : ''}}>
                            {{$p->nm_post}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label for="list_kategori">Qty</label>
                    <input type="text" class="form-control input_detail input_biaya qty_monitoring1" name="qty[]"
                        value="{{$d->qty}}" required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Satuan</label>
                    <select name="id_satuan[]" class="form-control select satuan input_detail input_biaya" required>
                        <option value="">--Pilih Satuan--</option>
                        @foreach ($satuan as $p)
                        <option value="{{$p->id_satuan}}" {{$p->id_satuan == $d->id_satuan ? 'selected' :
                            ''}}>{{$p->nm_satuan}}
                        </option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Total Rp</label>
                    <input type="text" class="form-control text-right  input_detail input_biaya total_rp "
                        name="ttl_rp[]" value="{{$d->debit}}" required>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-costume" action="">Edit/Save</button>
    </div>
</form>