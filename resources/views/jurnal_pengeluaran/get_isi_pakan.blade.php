<hr>
<div class="row">
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
            <select name="id_barang[]" class="form-control get_barang get_barang1  select input_biaya" count="1">
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
            <input type="text" class="form-control input_detail input_biaya qty_monitoring1" name="qty[]" required>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Satuan</label>
            <select name="id_satuan[]" class="form-control satuan_barang1 select satuan input_detail input_biaya"
                required>

            </select>

        </div>
    </div>



    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Total Rp</label>
            <input type="text" class="form-control  input_detail input_biaya total_rp " name="ttl_rp[]" required>
        </div>
    </div>

</div>


<div id="tambah_input_vitamin">

</div>

<div align="right" class="mt-2">
    <button type="button" class="btn btn-sm btn-costume tambah_input_vitamin" id_akun="{{$id_akun}}"><i
            class="fas fa-plus"></i></button>
</div>