@if ($tgl2 == '0')
<div class="row">
    <div class="col-lg-12">
        <center>
            <img src="{{ asset('assets') }}/img/no_data2.svg" width="100px" alt="">
            <h5 style="color: #629779" class="mt-2">Data tidak ditemukan</h5>
        </center>
    </div>
</div>
@else
<div class="row">


    <div class="col-lg-12">
        <h5 style="color: #629779">Pendapatan</h5>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Tanggal</label>
    </div>
    <div class="col-lg-3">
        <label for="" style="color: #629779">Akun</label>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Debit</label>
    </div>
    <div class="col-lg-3">
        <label for="" style="color: #629779">Akun</label>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Kredit</label>
    </div>


    @php
    $total_penjualan = 0;
    @endphp
    @foreach ($akun_penjualan as $a)
    @if ($a->kredit == 0)
    @php
    continue;
    @endphp
    @else
    @php
    $total_penjualan += $a->kredit;
    @endphp
    @endif

    <div class="col-lg-2 mt-2">
        <input type="date" class="form-control" name="tgl_pendapatan[]" value="{{ $tgl2 }}" readonly>
    </div>
    <div class="col-lg-3 mt-2">
        <input type="text" class="form-control" value="{{ $a->nm_akun }}" readonly>
        <input type="hidden" name="id_akun_debit_penjualan[]" class="form-control" value="{{ $a->id_akun }}" readonly>
    </div>
    <div class="col-lg-2 mt-2">
        <input style="text-align: right" type="text" name="debit_penjualan[]" class="form-control"
            value="{{ $a->kredit }}" readonly>
    </div>
    <div class="col-lg-3 mt-2">
        <input type="text" class="form-control" value="Ikhtisar laba rugi" readonly>
        <input type="hidden" class="form-control" name="id_akun_kredit_penjualan[]" value="59" readonly>

    </div>
    <div class="col-lg-2 mt-2">
        <input style="text-align: right" type="text" name="kredit_penjualan[]" class="form-control"
            value="{{ $a->kredit }}" readonly>
    </div>
    @endforeach
    <div class="col-lg-10 mt-2">

    </div>
    <div class="col-lg-2 mt-4">
        <h5 class="float-right" style="color: #629779">Total : {{ number_format($total_penjualan, 0) }} </h5>
    </div>


</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <hr style="border: 1px solid #629779;">
    </div>
    <div class="col-lg-12">
        <h5 style="color: #629779">Biaya</h5>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Tanggal</label>
    </div>
    <div class="col-lg-3">
        <label for="" style="color: #629779">Akun</label>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Debit</label>
    </div>
    <div class="col-lg-3">
        <label for="" style="color: #629779">Akun</label>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Kredit</label>
    </div>
    @php
    $total_biaya = 0;
    @endphp
    @foreach ($akun_biaya as $a)
    @if ($a->debit - $a->kredit == 0)
    @php
    continue;
    @endphp
    @else
    @php
    $total_biaya += $a->debit - $a->kredit;
    @endphp
    @endif
    <div class="col-lg-2 mt-2">
        <input type="date" class="form-control" name="tgl_biaya[]" value="{{ $tgl2 }}" readonly>
    </div>
    <div class="col-lg-3 mt-2">
        <input type="text" class="form-control" value="Ikhtisar laba rugi" readonly>
        <input type="hidden" class="form-control" name="id_akun_debit_biaya[]" value="59" readonly>

    </div>
    <div class="col-lg-2 mt-2">
        <input style="text-align: right" type="text" name="debit_biaya[]" class="form-control"
            value="{{ $a->debit - $a->kredit }}" readonly>
    </div>

    <div class="col-lg-3 mt-2">
        <input type="text" class="form-control" value="{{ $a->nm_akun }}" readonly>
        <input type="hidden" name="id_akun_kredit_biaya[]" class="form-control" value="{{ $a->id_akun }}" readonly>
    </div>
    <div class="col-lg-2 mt-2">
        <input style="text-align: right" type="text" name="kredit_biaya[]" class="form-control"
            value="{{ $a->debit - $a->kredit }}" readonly>
    </div>
    @endforeach
    <div class="col-lg-12 mt-4">
        <h5 class="float-right" style="color: #629779">Total Biaya : {{ number_format($total_biaya, 0) }}</h5>
    </div>
</div>

<br>
<div class="row">
    <div class="col-lg-12">
        <hr style="border: 1px solid #629779;">
    </div>
    <div class="col-lg-4">
        <table class="table " width="100%">
            <tr>
                <th style="text-align: center;color: #629779" width="39%">Pendapatan</th>
                <th style="text-align: center;color: #629779" width="2%"></th>
                <th style="text-align: center;color: #629779" width="39%">Biaya</th>
                <th style="text-align: center;color: #629779" width="20%">Total</th>
            </tr>
            <tr>
                <th style="text-align: center;color: #629779" width="49%">
                    {{ $tgl2 == '0' ? '0' : number_format($total_penjualan, 0) }}
                </th>
                <th style="text-align: center;color: #629779" width="2%">-</th>
                <th style="text-align: center;color: #629779" width="49%">
                    {{ $tgl2 == '0' ? '0' : number_format($total_biaya, 0) }}
                </th>

                @php
                $penjualan = $tgl2 == 0 ? 0 : $total_penjualan;
                $biaya = $tgl2 == 0 ? 0 : $total_biaya;
                $laba = $penjualan - $biaya;
                @endphp
                <th style="text-align: center;color: #629779; white-space: nowrap;" width="20%">=
                    {{ number_format($laba, 0) }}
                </th>
            </tr>

        </table>
    </div>







</div>
<div class="row">
    <div class="col-lg-2">
        <label for="" style="color: #629779">Tanggal</label>
    </div>
    <div class="col-lg-3">
        <label for="" style="color: #629779">Akun</label>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Debit</label>
    </div>
    <div class="col-lg-3">
        <label for="" style="color: #629779">Akun</label>
    </div>
    <div class="col-lg-2">
        <label for="" style="color: #629779">Kredit</label>
    </div>

    @if ($laba < 0) <div class="col-lg-2 mt-2">
        <input type="date" name="tgl_modal" class="form-control" value="{{ $tgl2 }}" readonly>
</div>
<div class="col-lg-3 mt-2">
    <input type="text" class="form-control" value="Modal Pemilik" readonly>
    <input type="hidden" name="id_akun_debit_modal" class="form-control" value="16" readonly>
</div>

<div class="col-lg-2 mt-2">
    <input style="text-align: right" type="text" name="debit_modal" class="form-control" value="{{ $laba * -1 }}"
        readonly>
</div>
<div class="col-lg-3 mt-2">
    <input type="text" class="form-control" value="Ikhtisar laba rugi" readonly>
    <input type="hidden" class="form-control" name="id_akun_kredit_modal" value="59" readonly>

</div>
<div class="col-lg-2 mt-2">
    <input style="text-align: right" type="text" name="kredit_modal" class="form-control" value="{{ $laba * -1 }}"
        readonly>
</div>
@else
<div class="col-lg-2 mt-2">
    <input type="date" name="tgl_modal" class="form-control" value="{{ $tgl2 }}" readonly>
</div>
<div class="col-lg-3 mt-2">
    <input type="text" class="form-control" value="Ikhtisar laba rugi" readonly>
    <input type="hidden" class="form-control" name="id_akun_kredit_modal" value="59" readonly>

</div>


<div class="col-lg-2 mt-2">
    <input style="text-align: right" type="text" name="debit_modal" class="form-control" value="{{ $laba }}" readonly>
</div>
<div class="col-lg-3 mt-2">
    <input type="text" class="form-control" value="Modal Pemilik" readonly>
    <input type="hidden" name="id_akun_debit_modal" class="form-control" value="16" readonly>
</div>
<div class="col-lg-2 mt-2">
    <input style="text-align: right" type="text" name="kredit_modal" class="form-control" value="{{ $laba }}" readonly>
</div>
@endif


{{-- prive --}}
<div class="col-lg-2 mt-2">
    <input type="date" name="tgl_prive" class="form-control" value="{{ $tgl2 }}" readonly>
</div>
<div class="col-lg-3 mt-2">
    <input type="text" class="form-control" value="Modal Pemilik" readonly>
    <input type="hidden" class="form-control " name="id_akun_debit_prive" value="16" readonly>

</div>
<div class="col-lg-2 mt-2">
    <input style="text-align: right" type="text" name="debit_prive" class="form-control prive">
</div>

<div class="col-lg-3 mt-2">
    <input type="text" class="form-control" value="Prive" readonly>
    <input type="hidden" name="id_akun_kredit_prive" class="form-control" value="61" readonly>
</div>
<div class="col-lg-2 mt-2">
    <input style="text-align: right" type="text" name="kredit_prive" class="form-control prive">
</div>
</div>
@endif