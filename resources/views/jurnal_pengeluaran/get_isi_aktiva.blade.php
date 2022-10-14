<hr>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">No id</label>
            <input type="text" class="form-control input_detail input_biaya" name="no_id_aktiva" required>
            <input type="hidden" name="jenis" value="7" class="input_detail input_biaya">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="list_kategori">Keterangan</label>
            <input type="text" class="form-control input_detail input_biaya" name="keterangan_aktiva" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Post Center</label>
            <select name="id_post_center_aktiva" class="form-control pos_aktiva select input_biaya">
                {{-- <option value="">--Pilih Post Center--</option>
                @foreach ($post_center as $p)
                <option value="{{$p->id_post}}">{{$p->nm_post}}</option>
                @endforeach --}}
            </select>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Qty</label>
            <input type="text" class="form-control  qty_aktiva" name="qty_aktiva" value="1" required>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Satuan</label>
            <select name="id_satuan_aktiva" class="form-control select satuan " required>
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
            <label for="list_kategori">Rp/Satuan</label>
            <input type="text" class="form-control total_aktiva" name="ttl_rp_aktiva" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">PPN</label>
            <input type="text" class="form-control ppn" name="ppn_aktiva" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Rp + Pajak</label>
            <input type="text" class="form-control ppn_ttl_rp" name="ttl_rp_aktiva" required readonly>
        </div>
    </div>
    <hr>

    <div class="col-lg-12">
        <table class="table table-bordered table-sm" width="100%">
            <thead style="text-align: center;">
                <tr>
                    <th></th>
                    <th width="15%">Nama Kelompok</th>
                    <th width="15%">Umur</th>
                    <th width="70%">Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aktiva as $a) : ?>
                <tr>
                    <td><input type="radio" name="id_kelompok" id="" value="<?= $a->id_kelompok ?>"></td>
                    <td>
                        <?= $a->nm_kelompok ?>
                    </td>
                    <td>
                        <?= $a->umur ?> Tahun
                    </td>
                    <td>
                        <?= $a->barang_kelompok ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>


</div>