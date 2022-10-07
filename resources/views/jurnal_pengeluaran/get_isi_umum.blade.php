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
            <label for="list_kategori">Post Center</label>
            <select name="id_post_center[]" class="form-control   select input_biaya">
                <option value="">--Pilih Post Center--</option>
                @foreach ($post_center as $p)
                <option value="{{$p->id_post}}">{{$p->nm_post}}</option>
                @endforeach
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
            <input type="text" class="form-control" readonly value="{{$satuan2->nm_satuan}}">

        </div>
    </div>



    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Total Rp</label>
            <input type="text" class="form-control  input_detail input_biaya total_rp total_rp1" name="ttl_rp[]"
                total_rp='1' required>
        </div>
    </div>

</div>


<div id="tambah_umum">

</div>

<div align="right" class="mt-2">
    <button type="button" class="btn btn-sm btn-costume tambah_umum" id_akun="{{$id_akun}}"><i
            class="fas fa-plus"></i></button>
</div>