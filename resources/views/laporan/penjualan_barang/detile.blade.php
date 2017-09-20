
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="10%" class="text-center">No</th>
            <th class="text-center">Tanggal Jual</th>
            <th class="text-center">Nota</th>
            
            <th class="text-center">Pelanggan</th>
            <th class="text-center">Jumlah Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $i =0;
            use App\Pelanggan;
            $total_sp = 0;
        ?>
        @forelse($data_transaksi as $item)
            <?php $pelanggan = Pelanggan::find($item->kode_pelanggan); ?>
            <tr>
                <td class="text-center">{{$i+1}}</td>
                <td class="text-center">{{date('d-m-Y', strtotime($item->tanggal_jual))}}</td>
                <td class="text-center">{{$item->nota}}</td>
                <td class="text-center">{{$pelanggan != null ? $pelanggan->no_plat : ''}}</td>
                <td class="text-center">{{$item->jumlah_sp}}</td>
            </tr>
            <?php 
                $i++;
                $total_sp = $total_sp+$item->jumlah_sp;
            ?>
        @empty
            <tr>
                <td colspan="5" align="center">Tidak Ada Data Transaksi Tercatat</td>
            </tr>
        @endforelse

        @if($data_transaksi != null)
            <tr>
                <td colspan="4" align="right"><b>Total</b></td>
                <td align="center">{{$total_sp}}</td>
            </tr>
        @endif
        
        
    </tbody>
</table>
