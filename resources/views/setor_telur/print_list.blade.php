<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Nota</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- CSS only -->

</head>
<style>
    body {
        font-family: 'Roboto', sans-serif;
        color: #787878;
    }
</style>
<style>
    @media print {

        .no_print,
        .no-print * {
            display: none !important;
        }
    }

    .table1 {
        font-family: sans-serif;
        color: #232323;
        border-collapse: collapse;
    }

    .table1,
    th,
    td {
        border: 1px solid #999;
        padding: 1px 20px;
        font-size: 11px;
    }
</style>


<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-5 col-sm-5">
                <h2 style="white-space: nowrap;">Invoice Setoran Telur Linda</h2>
            </div>
            <div class="col-10">
                <table class="table1">
                    <thead style="background-color: #E9ECEF;">
                        <tr>
                            <th>CFM Setor</th>
                            <th>Tanggal Setor</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?= $nota_s->nota_setor ?>
                            </td>
                            <td>
                                <?= date('d-m-Y', strtotime($nota_s->tgl)) ?>
                            </td>
                            <td>
                                {{ Auth::user()->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table1 table-bordered" width="100%">
                    <thead style="background-color: #E9ECEF;">
                        <tr>
                            <th style="text-align: center;">Tanggal</th>
                            <th style="text-align: center;">CFM</th>
                            <th style="text-align: center;">Pembayaran</th>

                            <th style="text-align: right;">Debit</th>
                            <th style="text-align: right;">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $ttl = 0;
                        foreach ($list as $n) :
                            $ttl += $n->debit
                        ?>
                        <tr>
                            <td style="text-align: center;">{{ date('d-m-Y', strtotime($n->tgl)) }}</td>
                            <td style="text-align: center;">{{ $n->no_nota }}</td>
                            <td style="text-align: center;">{{ $n->nm_akun }}</td>
                            <td style="text-align: right;">{{ number_format($n->debit, 0) }}</td>
                            <td style="text-align: right;">{{ number_format($n->kredit, 0) }}</td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>

            </div>

            <br><br><br>

        </div>
    </div>


</body>

</html>

<script>
    window.print()
</script>