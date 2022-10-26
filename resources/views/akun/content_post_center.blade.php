<table class="table" id="tblPost">
    <thead>
        <tr>
            <td>#</td>
            <td>Post Center</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td>
                <input type="hidden" id="id_akun" value="{{ $id_akun }}">
                <input autofocus type="text" class="form-control" id="namaPostCenter">
            </td>
            <td>
                <button type="button" id="simpanPostCenter" class="btn btn-costume btn-sm">Simpan</button>
            </td>
        </tr>
        @foreach ($postCenter as $no => $p)
        <tr>
            <td>{{ $no+1 }}</td>
            <td>{{ $p->nm_post }}</td>
            <td>
                <button type="button" id="btnEditPostCenter" data-toggle="modal" data-target="#editPostCenter" class="btn btn-costume btn-sm" id_akun="{{ $id_akun }}" nm_post="{{ $p->nm_post }}" id_post="{{ $p->id_post }}"><i
                    class="fas fa-pen"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm"
                    id="hapusPostCenter" id_akun="{{ $id_akun }}" id_post="{{ $p->id_post }}"><i class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
