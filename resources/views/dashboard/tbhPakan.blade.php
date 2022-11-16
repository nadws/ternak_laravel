<div id="row{{ $c }}">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">No id</label>
                <input type="text" name="no_id[]" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Tujuan</label>
                <input type="text" name="tujuanPakan" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Keterangan</label>
                <input type="text" name="keterangan[]" class="form-control">    
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Pilih Pakan</label>
                <div id="kontenPilihPakan{{$c}}"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Pilih Pakan</label>
                <select name="id_postCenterPakan" id="" class="form-control select2">
                    <option value="">- Pilih post center -</option>
                    @foreach ($postCenter as $p)
                        <option value="{{ $p->id_post }}">{{ $p->nm_post }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="">Qty</label>
                <input type="text" name="qty[]" class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="">Satuan</label>
                <input readonly type="hidden" id="id-satuan-pakan{{$c}}" name="id_satuan[]" class="form-control">
                <input readonly type="text" id="nm-satuan-pakan{{$c}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Total Rp</label>
                <input type="text" name="ttl_rp[]" class="form-control total_rp">
            </div>
        </div>
        <div class="col-lg-2">
            <label for="">Aksi</label><br>
            <button type="button" class="btn btn-danger btn-sm removePakan" count="{{$c}}"><i class="fas fa-minus"></i></button>
        </div>
    </div>
</div>