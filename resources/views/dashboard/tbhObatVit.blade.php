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
                <label for="">Pilih Obat & Vitamin</label>
                <div id="kontenPilihObatVit{{$c}}"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
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
                <input type="text" name="qty[]" class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <input readonly type="hidden" id="id-satuan-obat{{$c}}" name="id_satuan[]" class="form-control">
                <input readonly type="text" id="nm-satuan-obat{{$c}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input type="text" name="ttl_rp[]" class="form-control total-rp-obat">
            </div>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-danger btn-sm removeObatVit" count="{{$c}}"><i class="fas fa-minus"></i></button>
        </div>
    </div>
</div>