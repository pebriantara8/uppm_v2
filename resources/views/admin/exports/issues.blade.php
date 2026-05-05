<table style="word-wrap:break-word">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Penulis</th>
            <th>Peran</th>
            <th>KUM(%)</th>
            <th>Jenis Luaran</th>
            <th>Judul/Nama Produk</th>
            <th>Jenis Buku</th>
            <th>ISBN Buku</th>
            <th>Jenis Publikasi Ilmiah</th>
            <th>Link Publikasi</th>
            <th>Jenis Hak Cipta</th>
            <th>Nomor Hak Cipta/Paten</th>
            <th>Biaya APC</th>
            <th>Reward Sesuai SK</th>
            <th>Reward KUM</th>
            <th>Total Reward + APC</th>
        </tr>
    </thead>
    <?php $no=1; ?>
    <tbody>
        @foreach($datas as $key => $data)
        @if($data->join_penulis)
        <?php $new=0; ?>
        <?php $rowspan=$data->total_penulis_internal; ?>
        @foreach($data->join_penulis as $kjpv => $jpv)
        @if($jpv->issue_penulis_jabatan_id==1 OR $jpv->issue_penulis_jabatan_id==2)
        <tr>
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$no}}
                <?php $no++; ?>
            </td>
            @endif
            <td>
                {{$jpv->nama}}
                @if($jpv->issue_penulis_jabatan_id==1)
                (Dosen)
                @elseif($jpv->issue_penulis_jabatan_id==2)
                (Mahasiswa)
                @endif
            </td>
            <td>
                @if($jpv->koresponden==1 & $data->bentuk_luaran!=4)
                Penulis ke-{{$jpv->penulis_ke}} Koresponden
                @else
                Penulis ke-{{$jpv->penulis_ke}}
                @endif

                @if($new==0 & $data->bentuk_luaran!=4)
                (Total Penulis = {{$data->total_penulis}})
                @elseif($new==0 & $data->bentuk_luaran==4)
                (Total Inventor = {{$data->total_penulis}})
                @endif

            </td>
            <td>
                {{round($jpv->kum, 2)}}
            </td>
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->bentuk_luaran_name}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->judul}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->jenis_buku_name}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->isbn_buku_name}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->level_publikasi_name}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->link_publikasi}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->jenis_hak_cipta_name}}
            </td>
            @endif
            @if($new==0)
            <td rowspan="{{$rowspan}}">
                {{$data->no_hak_cipta}}
            </td>
            @endif
            <td data-format="Rp#,##0_-">
                @if($new==0)
                {{$data->biaya_apc}}
                @endif
            </td>
            <td data-format="Rp#,##0_-">
                @if($new==0)
                {{$data->nominal_apresiasi}}
                @endif
            </td>
            <td data-format="Rp#,##0_-">
                <?php $reward_kum = ($jpv->kum)*$data->nominal_apresiasi/100; ?>
                {{round($reward_kum,2)}}
            </td>
            <td data-format="Rp#,##0_-">
                @if($new==0)
                {{$data->biaya_apc+$reward_kum}}
                @else
                {{round($reward_kum,2)}}
                @endif
            </td>

            <?php $new=1; $rowspan=1; ?>
        </tr>
        @endif
        @endforeach
        @endif
        @endforeach
    </tbody>
</table>