<div class="row" id="row{{$count}}">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">No id</label>
            <input type="text" class="form-control input_detail input_biaya" name="no_id[]" required>
            <input type="hidden" name="jenis" value="7" class="input_detail input_biaya">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Keterangan</label>
            <input type="text" class="form-control input_detail input_biaya" name="keterangan[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Pilih Barang</label>
            <select name="id_barang[]" class="form-control get_barang get_barang{{$count}} select input_biaya"
                count="{{$count}}">
                <option value="">--Pilih Barang--</option>
                @foreach ($barang as $p)
                <option value="{{$p->id_barang}}">{{$p->nm_barang}}</option>
                @endforeach
                <option value="pls_barang">+Barang</option>
            </select>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Qty</label>
            <input type="text" class="form-control input_detail input_biaya qty_monitoring1" qty=1 name="qty[]"
                required>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Satuan</label>
            <select name="id_satuan[]"
                class="form-control select satuan input_detail satuan_barang{{$count}} input_biaya" required>

            </select>

        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Total Rp</label>
            <input type="text" class="form-control  input_detail input_biaya total_rp total_rp1" name="ttl_rp[]"
                total_rp='1' required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="">Aksi</label> <br>
            <button type="button" class="btn btn-danger btn-sm remove_monitoring" count="{{$count}}"><i
                    class="fas fa-minus"></i></button>
        </div>
    </div>

</div>