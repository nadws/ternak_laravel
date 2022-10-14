<div class="col-lg-12">
    <table class="table table-bordered" width="100%">
        <thead style="text-align: center;">
            <tr>
                <th>Nama Kelompok</th>
                <th style="white-space: nowrap">Umur</th>
                <th>Nilai/tahun (%)</th>
                <th>Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aktiva as $a) : ?>
            <tr>
                <td>
                    <?= $a->nm_kelompok ?>
                </td>
                <td>
                    <?= $a->umur ?> {{$a->satuan == '1' ? 'Bulan' : 'Tahun'}}
                </td>
                <td>
                    <?= $a->tarif * 100 ?> %
                </td>
                <td>
                    <?= $a->barang_kelompok ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>