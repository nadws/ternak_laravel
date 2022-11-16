<select name="id_barang[]" class="form-control select2 pilihObatVit">
    <option value="">- Pilih Obat & Vitamin -</option>
    @foreach ($pakan as $p)
        <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
    @endforeach
    <option value="tbh">+ Obat Vit</option>
</select>