<table class="table table-bordered">
    <thead class="warning">                            
        <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center" width="10%">Kode Barang</th>
            <th class="text-center" width="40%">Nama</th>
            <th class="text-center">Kode Tipe</th>
            <th class="text-center">Stok</th>
            <th width="15%" class="text-center">Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        @forelse ($data_barang as $barang)
            <tr>
                <td align="center" style="vertical-align:middle;">{{$i+1}}</td>
                <td align="center" style="vertical-align:middle;">{{$barang->kode}}</td>
                <td style="vertical-align:middle;">{{$barang->nama_barang}}</td>
                <td align="center" style="vertical-align:middle;">{{$barang->kode_tipe_motor}}</td>
                <td align="center" style="vertical-align:middle;">{{$barang->stok_barang}}</td>
                <td align="center" style="vertical-align:middle;">
                    <a href="{{url('/master/barang/edit').'/'.$barang->id}}" class="btn btn-warning btn-xs btn-rounded" ><i class="fa fa-pencil"></i></a>
                    <a  class="btn btn-danger btn-xs btn-rounded btn-hapus" id="{{$barang->id}}" ><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php $i++; ?>
        @empty
            <tr>
                <td colspan="6" align="center">Tidak Ada Data</td>
            </tr>
        @endforelse
        
    </tbody>
</table>

{{$data_barang->links()}}