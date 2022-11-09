<form action="{{ route('edit_jurnal_aktiva') }}" method="post">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="list_kategori">Tanggal</label>
                    <input class="form-control" type="date" name="tgl" id="tgl_peng"
                        value="{{date('Y-m-d' ,strtotime($kredit->tgl))}}" required>
                    <input type="hidden" name="id_kredit" value="{{ $kredit->id_jurnal }}">
                    <input type="hidden" name="no_nota" value="{{ $kredit->no_nota }}">
                    <input type="hidden" name="id_aktiva" value="{{ $b_aktiva->id_aktiva }}">

                </div>
            </div>
            <div class="mt-3 ml-1">
                <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label for="list_kategori">Akun</label>
                    <select name="id_akun" class="form-control select id_debit" required>
                        <option value="">-Pilih Akun-</option>
                        @foreach ($akun as $a)
                        <option value="{{$a->id_akun }}" {{$a->id_akun == $debit->id_akun ? 'selected'
                            :''}}>{{$a->nm_akun}}</option>
                        @endforeach

                    </select>
                </div>

            </div>
            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Debit</label>
                    <input style="text-align: right" type="number" class="form-control  total" name="debit" readonly
                        value="{{$kredit->kredit}}">
                </div>
            </div>
            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Kredit</label>
                    <input type="number" class="form-control" readonly>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">

            </div>

            <div class="mt-1">
                <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
            </div>

            <div class="col-sm-3 col-md-3">

                <div class="form-group">
                    <input type="hidden" class="id_debit_akun">
                    <select name="id_akun_kredit" class="form-control post_atk akun_kredit select" count="1" required>
                        @foreach ($akun as $a)
                        <option value="{{$a->id_akun }}" {{$a->id_akun == $kredit->id_akun ? 'selected' :
                            ''}}>{{$a->nm_akun
                            }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <input type="number" class="form-control" readonly>
                </div>
            </div>
            <div class="col-sm-2 col-md-2">
                <div class="form-group">
                    <input type="number" style="text-align: right" class="form-control total " name="kredit" readonly
                        value="{{$kredit->kredit}}">
                </div>
            </div>

            <div class="col-sm-3 col-md-3">

            </div>

        </div>
        <hr>
        <div class="row">
            <input type="hidden" name="id_debit" value="{{$debit->id_jurnal}}">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">No id</label>
                    <input type="text" class="form-control input_detail input_biaya" name="no_id_aktiva"
                        value="{{$debit->no_id}}" required>
                    <input type="hidden" name="jenis" value="7" class="input_detail input_biaya">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="list_kategori">Keterangan</label>
                    <input type="text" class="form-control input_detail input_biaya" name="keterangan_aktiva"
                        value="{{$debit->ket}}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Post Center</label>
                    <select name="id_post_center_aktiva" class="form-control pos_aktiva select input_biaya">

                        @foreach ($post_center_aktiva as $p)
                        <option value="{{$p->id_post}}" value="{{$debit->id_post == $p->id_post ? 'selected' : ''}}">
                            {{$p->nm_post}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label for="list_kategori">Qty</label>
                    <input type="text" class="form-control  qty_aktiva text-right" name="qty_aktiva"
                        value="{{$debit->qty}}" required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Satuan</label>
                    <select name="id_satuan_aktiva" class="form-control select satuan " required>
                        <option value="">--Pilih Satuan--</option>
                        @foreach ($satuan as $p)
                        <option value="{{$p->id_satuan}}" {{$p->id_satuan == $debit->id_satuan ? 'selected' :
                            ''}}>{{$p->nm_satuan}}
                        </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Rp/Satuan</label>
                    <input type="text" class="form-control total_aktiva text-right" name="ttl_rp_aktiva"
                        value="{{$debit->debit}}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">PPN</label>
                    <input type="text" class="form-control ppn" name="ppn_aktiva" value="0" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="list_kategori">Rp + Pajak</label>
                    <input type="text" class="form-control ppn_ttl_rp text-right" name="ttl_rp_aktiva"
                        value="{{$debit->debit}}" required readonly>
                </div>
            </div>
            <hr>
            @php
            $aktiva = DB::table('tb_kelompok_aktiva')->where('id_akun',$debit->id_akun)->orderBy('id_kelompok',
            'ASC')->get();

            @endphp
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
                            <td><input type="radio" name="id_kelompok" id="" value="<?= $a->id_kelompok ?>"
                                    {{$b_aktiva->id_kelompok == $a->id_kelompok ? 'checked' : ''}}></td>
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
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-costume" action="">Edit/Save</button>
    </div>
</form>