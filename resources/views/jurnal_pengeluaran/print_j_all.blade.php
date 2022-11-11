<?php
// $file = "Jurnal Pengeluaran.xls";
// header('Content-Type: application/vnd.ms-excel');
// header("Content-Disposition: attachment; filename=$file");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<style>
    th,
    td {
        padding: 5px;
    }

    .table_css {
        border: 1px solid #629779;
        border-collapse: collapse;
    }

    .table_css_head {
        border: 1px solid white;
        border-collapse: collapse;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: #787878
    }
</style>

<body>
    <table width="100%" class="table_css_head" border="1">
        <thead class="table_css_head" style="background-color: #629779; color: white">
            <tr role="row" style="white-space: nowrap">
                <th class="table_css_head">#</th>
                <th class="table_css_head">Tanggal</th>
                <th class="table_css_head">No Nota</th>
                <th class="table_css_head">No Id</th>
                <th class="table_css_head">Post Akun</th>
                <th class="table_css_head">Keterangan</th>
                <th class="table_css_head" style="text-align: right">Debit <br>
                    ({{ number_format($total_jurnal->debit, 0) }})</th>
                <th class="table_css_head" style="text-align: right">Kredit <br>
                    ({{ number_format($total_jurnal->kredit, 0) }})</th>
                <th class="table_css_head">Admin</th>
            </tr>
        </thead>
        <tbody class="table_css">
            @php
            $no = 1;
            @endphp
            @foreach ($jurnal as $a)
            <tr>
                <td class="table_css">{{ $no++ }}</td>
                <td class="table_css" style="white-space: nowrap">
                    {{ date('d-m-Y', strtotime($a->tgl)) }}</td>
                <td class="table_css">{{ $a->no_nota }}</td>
                <td class="table_css">{{ $a->no_id }}</td>
                <td class="table_css">{{ $a->nm_akun }}</td>
                <td class="table_css">{{ $a->ket }}</td>
                <td class="table_css" style="text-align: right">{{ number_format($a->debit, 0) }}
                </td>
                <td class="table_css" style="text-align: right">
                    {{ number_format($a->kredit, 0) }}
                </td>
                <td class="table_css">{{ $a->admin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>


<script>
    window.print()
</script>

</html>