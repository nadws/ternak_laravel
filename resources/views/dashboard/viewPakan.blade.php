<table class="table" width="100%" id="tblViewPakan">
    <thead>
        <tr>
            <td>No</td>
            <td>Tanggal</td>
            <td>Nama Pakan</td>
            <td>Stok Masuk</td>
            <td>Stok Keluar</td>
            <td>Penyesuaian</td>
            <td>Admin</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($table as $no => $t)
            <tr>
                <td>{{ $no+1 }}</td>
                <td>{{ date('d-m-Y',strtotime($t->tgl)) }}</td>
                <td>{{ $t->nm_barang }}</td>
                <td>{{ $t->debit }}</td>
                <td>{{ $t->kredit }}</td>
                <td align="center">
                    <i class="fa fa-2x fa-{{$t->disesuaikan == 'T' ? 'times' : 'check'}}-circle text-danger"></i>
                </td>
                <td>{{ $t->admin }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
