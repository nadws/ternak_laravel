<style>
    th,
    td {
        padding: 5px;
    }

    .table_css {
        border: 1px solid #629779;
        border-collapse: collapse;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <a target="_blank" href="{{route('print_jurnal2',['nota' => $nota])}}"
            class="float-right btn btn-costume btn-sm tes_button"><i class="fas fa-print"></i> Print</a>
    </div>
    <div class="col-lg-12">
        <h3 style="color: #629779">Jurnal Pengeluaran</h3>
    </div>
    <div class="col-lg-12">
        <hr style="border: 1px solid #629779">
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4">
                <table width="100%">
                    <tr>
                        <td>Nota</td>
                        <td>:</td>
                        <td>{{$jurnal2->no_nota}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{date('d-m-Y',strtotime($jurnal2->tgl))}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4 float-right">
                <table width="100%" style="padding: 15px">
                    <tr>
                        <td>Departement</td>
                        <td>:</td>
                        <td>Agrilaras</td>
                    </tr>
                    <tr>
                        <td>Admin</td>
                        <td>:</td>
                        <td>{{$jurnal2->admin}}</td>
                    </tr>
                </table>
            </div>

            <div class="col-lg-12">
                <br>
                <br>
                <table width="100%" class="table_css">
                    <thead class="table_css" style="background-color: #629779; color: white">
                        <tr>
                            <th class="table_css">Post Akun</th>
                            <th class="table_css">Keterangan</th>
                            <th style="text-align: right" class="table_css">Debit</th>
                            <th style="text-align: right" class="table_css">kredit</th>
                        </tr>
                    </thead>
                    <tbody class="table_css">
                        @php
                        $debit = 0;
                        $kredit = 0;
                        @endphp
                        @foreach ($jurnal as $j)
                        <tr>
                            <td class="table_css">{{$j->nm_akun}}</td>
                            <td class="table_css">{{$j->ket}}</td>
                            <td style="text-align: right" class="table_css">{{number_format($j->debit,0)}}</td>
                            <td style="text-align: right" class="table_css">{{number_format($j->kredit,0)}}</td>
                        </tr>
                        @php
                        $debit += $j->debit;
                        $kredit += $j->kredit;
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot class="table_css" style="background-color: #629779; color: white">
                        <tr>
                            <th class="table_css">Total</th>
                            <th class="table_css"></th>
                            <th style="text-align: right" class="table_css">Rp.{{number_format($debit,0)}}</th>
                            <th style="text-align: right" class="table_css">Rp.{{number_format($kredit,0)}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-lg-2 ml-4">
                <br>
                <br>
                <p>Created by:</p>
                <br>
                <br>
                <hr style="border: 1px solid black">
            </div>
        </div>
    </div>
</div>