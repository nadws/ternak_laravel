<style>
    table th {
        position: sticky;
        z-index: 1;
    }

    .table_css {
        border: 1px solid #629779;
        border-collapse: collapse;
    }
</style>

<div class="row">
    <div class="col-lg-12">

    </div>
    <div class="col-lg-12">
        <h4 class="float-left" style="color: #629779">CFM Setor : {{$nota}}</h4>
        <button type="button" class="btn  btn-costume  float-right" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-share-alt"></i>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item  post_center" href="#"><i class=" text-primary fas fa-print"></i> &nbsp;Cetak</a>
            <a class="dropdown-item  " href="#"><i style="color: #1F6E43" class=" fas fa-file-excel"></i> &nbsp;Export
                To Excel</a>
        </div>
    </div>
    <div class="col-lg-12">
        <hr style="border: 1px solid #629779">
    </div>
    <div class="col-lg-12">
        <table class="table mt-4">
            <thead class="table_css" style="background-color: #629779; color: white">
                <tr>
                    <th>Tanggal</th>
                    <th>No nota</th>
                    <th>Customer</th>
                    <th style="text-align: right">Total Rp</th>
                    <th width="20%">Setor</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0;
                @endphp
                @foreach ($list as $l)
                <tr>
                    <td>{{date('d-m-Y',strtotime($l->tgl))}}</td>
                    <td>{{$l->no_nota}}</td>
                    <td>{{$l->nm_post}} {{$l->urutan}}</td>
                    <td style="text-align: right">Rp.{{number_format($l->debit,0)}}</td>
                    <td><input style="text-align: right" type="number" value="{{$l->debit}}" class="form-control"></td>
                </tr>
                @php
                $total += $l->debit;
                $id_akun = $l->id_akun;
                @endphp
                @endforeach
            </tbody>
            <tfoot class="table_css" style="background-color: #629779; color: white">
                <tr>
                    <th colspan="2"></th>
                    <th style="text-align: right">Total</th>
                    <th style="text-align: right">Rp. {{number_format($total,0)}}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-lg-3">
        <label for="">Tanggal</label>
        <input type="date" class="form-control" name="tgl">
    </div>
    <div class="col-lg-3">
        <label for="">Akun</label>
        <input type="text" class="form-control" value="Kas Agri Linda" readonly>
        <input type="hidden" class="form-control" name="id_akun" value="55" readonly>
        <input type="hidden" class="form-control" name="id_akun2" value="{{$id_akun}}" readonly>
        <input type="hidden" class="form-control" name="no_nota" value="{{$nota}}" readonly>
    </div>
    <div class="col-lg-3">
        <label for="">Keterangan</label>
        <input type="text" class="form-control" name="keterangan">
    </div>
    <div class="col-lg-3">
        <label for="">Total</label>
        <input type="text" name="rupiah" style="text-align: right" class="form-control" value="{{$total}}" readonly>
    </div>


</div>