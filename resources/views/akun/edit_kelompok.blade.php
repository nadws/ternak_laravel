<div class="row">
    <div class="col-lg-12">
        <a href="" class="btn btn-sm btn-costume tambah_k_aktiva float-right" data-toggle="modal"
            data-target="#tambah_k_aktiva" id_akun="{{$id_akun}}"><i class="fas fa-plus"></i> Data</a>
        <br>
        <br>
        <table class="table table-bordered" width="100%">
            <thead style="text-align: center;">
                <tr>
                    <th>Nama Kelompok</th>
                    <th style="white-space: nowrap">Umur</th>
                    <th>Nilai/tahun (%)</th>
                    <th>Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aktiva as $a) : ?>
                <tr>
                    <td style="white-space: nowrap">{{$a->nm_kelompok}}</td>
                    <td style="white-space: nowrap">{{$a->umur}} {{$a->satuan == '1' ? 'Bulan' : 'Tahun'}}</td>
                    <td>{{$a->tarif * 100 }}%</td>
                    <td>{{$a->barang_kelompok}}</td>
                    <td style="white-space: nowrap">
                        <a href="" class="btn btn-costume btn-sm"><i class="fas fa-pen"></i></a>
                        <a href="#" class="btn btn-danger btn-sm delete_kelompok_baru" id_kelompok="{{$a->id_kelompok}}"
                            id_akun_kelompok="{{$a->id_akun}}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>