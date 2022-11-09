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
            <label for="list_kategori">Post Center</label>
            <select name="id_post_center[]" class="form-control atk_post atk_post{{$count}}  select input_biaya"
                count="{{$count}}">

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
            <select name="id_satuan[]" class="form-control select satuan input_detail input_biaya" required>
                <?php foreach ($satuan as $p) : ?>
                <option value="<?= $p->id_satuan ?>">
                    <?= $p->nm_satuan ?>
                </option>
                <?php endforeach; ?>
            </select>

        </div>
    </div>



    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Total Rp</label>
            <input type="text" style="text-align: right"
                class="form-control  input_detail input_biaya total_rp ttl_atk ttl_atk{{$count}}" name="ttl_rp[]"
                required>
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