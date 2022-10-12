<a href="{{route('print_jurnal2',['nota' => $jurnal2->no_nota])}}" class="btn btn-sm btn-info"><i
        class="fas fa-print"></i>
    Print</a>
<br>
<br>

<div class="row" style="border: 1px solid #787878; padding: 30px;">
    <div class="col-lg-12">

        <h5 class="text-center"><u>AGRI LARAS</u></h5>
    </div>
    <br>
    <br>
    <div class="col-lg-6">
        <table width="100%">
            <tr>
                <th>Admin</th>
                <th>:</th>
                <th>{{$jurnal2->admin}}</th>
            </tr>
            <tr>
                <th>No Nota</th>
                <th>:</th>
                <th>{{$jurnal2->no_nota}}</th>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
        <table width="100%">
            <th>Tanggal</th>
            <th>:</th>
            <th>{{$jurnal2->tgl}}</th>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="col-lg-12">
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>Post Akun</th>
                    <th>Keterangan</th>
                    <th>Debit</th>
                    <th>kredit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jurnal as $j)
                <tr>
                    <td>{{$j->nm_akun}}</td>
                    <td>{{$j->ket}}</td>
                    <td>{{number_format($j->debit,0)}}</td>
                    <td>{{number_format($j->kredit,0)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="col-lg-4" style="font-weight: bold">
        <center>Customer</center>
        <br>
        <br>
        <br>
        <br>
        <br>
        <center>
            (..................)
        </center>
    </div>
    <div class="col-lg-4" style="font-weight: bold">
        <center>Diterima</center>
        <br>
        <br>
        <br>
        <br>
        <br>
        <center>
            (..................)
        </center>
    </div>
    <div class="col-lg-4" style="font-weight: bold">
        <center>Mengetahui</center>
        <br>
        <br>
        <br>
        <br>
        <br>
        <center>
            (..................)
        </center>
    </div>
</div>