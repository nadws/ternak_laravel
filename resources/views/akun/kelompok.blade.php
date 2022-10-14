<div class="row mt-2" id="row{{$count}}">
    <div class="col-lg-3">

        <input type="text" class="form-control kelompok" name="nm_kelompok[]" required>
    </div>
    <div class="col-lg-1">

        <input type="text" class="form-control kelompok" name="umur[]" required>
    </div>
    <div class="col-lg-2">

        <Select name="satuan_aktiva[]" class="form-control select kelompok" required>
            <option value="">Pilih Satuan</option>
            <option value="1">Bulan</option>
            <option value="2">Tahun</option>
        </Select>
    </div>
    <div class="col-lg-2">

        <input type="text" class="form-control kelompok" name="tarif[]" required>
    </div>
    <div class="col-lg-3">

        <input type="text" class="form-control kelompok" name="barang[]" required>
    </div>
    <div class="col-lg-1">

        <button type="button" class="btn btn-sm btn-danger remove_kelompok" count="{{$count}}"><i
                class="fas fa-minus"></i></button>
    </div>
</div>