<select name="id_barang[]" id="" class="form-control select2 pilihPakan">
    <option value="">- Pilih Pakan -</option>
    @foreach ($pakan as $p)
        <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
    @endforeach
    <option value="tbh">+ Pakan</option>
</select>