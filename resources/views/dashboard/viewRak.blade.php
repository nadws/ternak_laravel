<table class="table" width="100%" id="tblViewRak">
    <thead>
        <tr>
            <td>No</td>
            <td>Tanggal</td>
            <td>No Nota</td>
            <td>Admin</td>
            <td>Stok Masuk</td>
            <td>Stok Keluar</td>
            <td>Saldo</td>
            <td>Penyesuaian</td>
        </tr>
    </thead>
    <tbody>
        @php
            $saldo = 0;
        @endphp
        @foreach ($table as $no => $t)
        @php
            $saldo += $t->debit - $t->kredit;
        @endphp
            <tr>
                <td>{{ $no+1 }}</td>
                <td>{{ date('d-m-Y',strtotime($t->tgl)) }}</td>
                <td>{{ $t->no_nota }}</td>
                <td>{{ $t->admin }}</td>
                <td>{{ $t->debit }}</td>
                <td>{{ $t->kredit }}</td>
                <td>{{ $saldo }}</td>
                <td align="center">
                    <i class="fa fa-2x fa-{{$t->disesuaikan == 'T' ? 'times' : 'check'}}-circle text-danger"></i>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
