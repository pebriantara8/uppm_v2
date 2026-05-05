@extends('admin.layouts.layout')
@section('content')
<div class="app-main__inner">
    <div class="app-page-title mb-0">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon"><i class="pe-7s-note2 icon-gradient bg-mean-fruit"></i></div>
                <div>Detail Pengajuan
                    <div class="page-title-subheading">
                        Admin -> Issue -> Detail Pengajuan
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Biaya APC dan Dana Apresiasi</h5>
                    <div class="row">
                        <div class="col">
                            <div class="list-group list-group-flush nav">
                                <li class="nav-item-header nav-item" style="font-size: 15px;">APC</li>
                                <div class="list-group-item" style="display: flex;justify-content: space-between;">
                                    <div>Biaya APC Diajukan</div>
                                    <div>Rp. {{number_format($data['issue']->biaya_apc, 0, ',', '.')}}</div>
                                </div>
                                <li class="nav-item-header nav-item" style="font-size: 15px;">Apresiasi</li>
                                <div class="list-group-item" style="display: flex;justify-content: space-between;">
                                    <div>Apresiasi {{$data['apresiasi']['nama_apresiasi']}}</div>
                                    <div>Rp. {{number_format($data['apresiasi']['nominal'], 0, ',', '.')}}</div>
                                </div>
                                <div class="list-group-item" style="display: flex;justify-content: space-between;">
                                    <div>Total:</div>
                                    <div><b>Rp. {{number_format($data['apresiasi']['total'], 0, ',', '.')}}</b></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="list-group list-group-flush nav">
                                <li class="nav-item-header nav-item" style="font-size: 15px;">Apresiasi Penulis</li>
                                <div class="list-group-item" style="display: flex;justify-content: space-between;">
                                    <div>Total Apresiasi {{$data['apresiasi']['nama_apresiasi']}}</div>
                                    <div>Rp. {{number_format($data['apresiasi']['nominal'], 0, ',', '.')}}</div>
                                </div>
                                @foreach ($data['penulis'] as $kdp => $vdp)
                                <div class="list-group-item" style="display: flex;justify-content: space-between;">
                                    @if($vdp->koresponden==1)
                                    <b>
                                        <div>Penulis {{ $vdp->penulis_ke}}. {{$vdp->nama}} ({{$vdp->persen}}%)</div>
                                    </b>
                                    @else
                                    <div>Penulis {{ $vdp->penulis_ke}}. {{$vdp->nama}} ({{$vdp->persen}}%)</div>
                                    @endif
                                    <div>Rp. {{number_format($vdp->persen_nominal, 0, ',', '.')}}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="divider"></div>
                    @role('admin')
                    <div class="text-center">
                        @if($datas->issue_status==0)
                        <form id="data-form" method="PUT" action="{{ route($route, $datas->exists ? $datas->id : '') }}"
                            enctype="multipart/form-data">
                            <button class="btn btn-primary">VALIDASI AJUAN</button>
                        </form>
                        @else
                        <form display="hidden" id="data-form" method="PUT" action="#" enctype="multipart/form-data">
                        </form>
                        <button class="btn btn-secondary">AJUAN SUDAH DITERIMA/TERVALIDASI</button>
                        @endif
                    </div>
                    @endrole
                </div>
                <div class="card-body">
                    <h5 class="card-title">Form</h5>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Tanggal Pengajuan</label>
                        <div class="col-sm-10">
                            <input disabled value="{{$datas->created_at}}" name="judul" id="judul"
                                placeholder="Judul Buku atau Penelitian atau Nama Produk" type="text"
                                class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Bentuk Luaran</label>
                        <div class="col-sm-10">
                            <select disabled type="select" id="selectElementLuaran" name="bentuk_luaran"
                                class="form-select">
                                <option disabled value="">Select</option>
                                <option {{ $datas->bentuk_luaran==1 ? 'selected' : '' }} value="1">Buku
                                </option>
                                <option {{ $datas->bentuk_luaran==2 ? 'selected' : '' }} value="2">Publikasi Artikel
                                </option>
                                <option {{ $datas->bentuk_luaran==3 ? 'selected' : '' }} value="3">Prosiding
                                </option>
                                <option {{ $datas->bentuk_luaran==4 ? 'selected' : '' }} value="4">Hak Kekayaan
                                    Intelektual (HKI)</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input disabled value="{{$datas->judul}}" name="judul" id="judul"
                                placeholder="Judul Buku atau Penelitian atau Nama Produk" type="text"
                                class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Jenis Buku</label>
                        <div class="col-sm-10">
                            <select disabled type="select" id="jenisBuku" name="jenis_buku" class="form-select">
                                <option value="">Select</option>
                                <option {{ $datas->jenis_buku==1 ? 'selected' : '' }} value="1">Buku Referensi
                                    Internasional</option>
                                <option {{ $datas->jenis_buku==2 ? 'selected' : '' }} value="2">Buku Referensi
                                    Nasional</option>
                                <option {{ $datas->jenis_buku==3 ? 'selected' : '' }} value="3">Buku Monograf
                                    Internasional</option>
                                <option {{ $datas->jenis_buku==4 ? 'selected' : '' }} value="4">Buku Monograf
                                    Nasional</option>
                                <option {{ $datas->jenis_buku==5 ? 'selected' : '' }} value="5">Book Chapter
                                    Internasional</option>
                                <option {{ $datas->jenis_buku==6 ? 'selected' : '' }} value="6">Book Chapter
                                    Nasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">ISBN Buku</label>
                        <div class="col-sm-10">
                            <input disabled value="{{$datas->isbn_buku}}" name="isbn_buku" id="isbnBuku"
                                placeholder="ISBN Buku" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Jenis Publikasi</label>
                        <div class="col-sm-10">
                            <select disabled type="select" id="jenisPublikasi" name="jenis_publikasi"
                                class="form-select">
                                <option value="">Select</option>
                                <option {{ $datas->jenis_publikasi==1 ? 'selected' : '' }} value="1">Artikel di
                                    Jurnal
                                    Internasional Open Access</option>
                                <option {{ $datas->jenis_publikasi==2 ? 'selected' : '' }} value="2">Artikel di
                                    Jurnal Internasional Close Access</option>
                                <option {{ $datas->jenis_publikasi==3 ? 'selected' : '' }} value="3">Artikel di
                                    Jurnal Nasional Terakreditasi</option>
                                <option {{ $datas->jenis_publikasi==4 ? 'selected' : '' }} value="4">Artikel di
                                    Prosiding Nasional dan Internasional</option>
                                <option {{ $datas->jenis_publikasi==5 ? 'selected' : '' }} value="5">Prosiding
                                    Internasional Terindeks Scopus dan Scimagojr
                                </option>
                                <option {{ $datas->jenis_publikasi==6 ? 'selected' : '' }} value="6">Prosiding
                                    Internasional Terindeks Scopus, IEEE, SPIE</option>
                                <option {{ $datas->jenis_publikasi==7 ? 'selected' : '' }} value="7">Prosiding (ISSN
                                    atau ISBN) Nasional</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Level Publikasi</label>
                        <div class="col-sm-10">
                            <select disabled type="select" id="levelPublikasi" name="level_publikasi"
                                class="form-select">
                                <option value="">Select</option>
                                @foreach($datas_level_publikasi as $kdlp => $vdlp)
                                <option {{ $datas->level_publikasi==$vdlp->id ? 'selected' : '' }}
                                    value="{{$vdlp->id}}">{{$vdlp->nama_level_publikasi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Link Publikasi</label>
                        <div class="col-sm-10">
                            <a disabled id="linkPublikasi" class="disabled form-control"
                                href="{{$datas->link_publikasi}}" target="_blank">{{$datas->link_publikasi}}</a>
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Jenis Hak Cipta</label>
                        <div class="col-sm-10">
                            <select disabled type="select" id="jenisHakCipta" name="jenis_hak_cipta"
                                class="form-select">
                                <option value="">Select</option>
                                <option {{ $datas->jenis_hak_cipta==1 ? 'selected' : '' }} value="1">Paten Desain
                                    Industri</option>
                                <option {{ $datas->jenis_hak_cipta==1 ? 'selected' : '' }} value="2">Paten Sederhana
                                </option>
                                <option {{ $datas->jenis_hak_cipta==1 ? 'selected' : '' }} value="3">Hak Cipta dan
                                    Merek Produk Dagang</option>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Nomor Hak Cipta/Paten</label>
                        <div class="col-sm-10">
                            <input disabled value="{{ $datas->no_hak_cipta}}" name="no_hak_cipta" id="noHakCipta"
                                placeholder="Nomor Hak Cipta/Paten" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Tim Penulis</label>
                        <div class="col-sm-10" id="formPenulisParent">
                            @foreach($datas->penulis as $kdp => $vdp)
                            <div class="input-group mb-2 input_penulis_element" id="inputPenulisElementParent">
                                <div class="input-group-text btn btn-danger btnDeleteElementPenulis">
                                    <span class="btnDeleteElementPenulisX"
                                        style="display: block; width: 100%; height: 100%;">X</span>
                                </div>
                                <div class="input-group-text">
                                    <input disabled {{ $vdp->koresponden == "1" ? 'checked' :
                                    '' }} name="penulis_utama" value="{{$vdp->penulis_ke-1}}"
                                    type="radio"
                                    class="form-check-input form_input_penulis_utama">

                                </div>
                                <input disabled value="{{$vdp->nama}}" placeholder="Penulis" type="text"
                                    class="form-control form_input_penulis" name="penulis[]">
                                <select disabled type="select" name="penulis_jabatan[]"
                                    class="form-select penulis_jabatan">
                                    <option value="">Jabatan/Instansi</option>
                                    <option {{ $vdp->issue_penulis_jabatan_id==1 ? 'selected' : '' }}
                                        value="1">Dosen Poltek LPP</option>
                                    <option {{ $vdp->issue_penulis_jabatan_id==2 ? 'selected' : '' }}
                                        value="2">Mahasiswa Poltek LPP</option>
                                    <option {{ $vdp->issue_penulis_jabatan_id==3 ? 'selected' : '' }}
                                        value="3">Pihak Luar/Eksternal</option>
                                </select>
                                <input disabled value="{{$vdp->penulis_bank}}" type="text" name="penulis_bank[]"
                                    class="form-control input_penulis_bank" placeholder="Bank">
                                <input disabled value="{{$vdp->no_rekening}}" type="text" name="penulis_norek[]"
                                    class="form-control input_penulis_norek" placeholder="No Rekening">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="position-relative row mb-3">
                        <label for="" class="form-label col-sm-2 col-form-label">Bukti Pembayaran</label>
                        <div class="col-sm-10">
                            <a disabled class="disabled form-control"
                                href="{{asset('storage/admin/bukti_pembayaran')}}/{{$datas->bukti_pembayaran}}"
                                target="_blank">{{$datas->bukti_pembayaran}}</a>
                            <!-- <a disabled class="disabled form-control"
                                href="https://apresiasi-polteklpp.my.id/storage/app/public/admin/bukti_pembayaran/{{$datas->bukti_pembayaran}}"
                                target="_blank">{{$datas->bukti_pembayaran}}</a> -->
                        </div>
                    </div>
                    <!-- <div class="position-relative row form-check">
                            <div class="col-sm-10 offset-sm-2"><button type="submit"
                                    class="btn btn-primary">Ajukan</button>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagespecificscripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    const form = document.querySelector('#data-form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (confirm("Apakah anda yakin menerima pengajuan ini?")) {
            const formData = new FormData(form);
            // console.log(formData)
            const el2 = document.querySelector('#error-field');
            if (el2) {
                document.querySelectorAll('#error-field').forEach(el => el.remove());
            }

            axios({
                method: "put",
                url: "{{ route($route, $datas->exists ? $datas->id : '') }}",
                data: formData,
                headers: { "Content-Type": "multipart/form-data", "accept": "application/json" },
            })
                .then(function (response) {
                    //handle success
                    console.log(response.data);
                    if (response.data.errors) {
                        alert('Error saving data, please contact your adminnistrator!');
                    }
                    if (response.data.success) {
                        location.reload()
                    }
                })
                .catch(function (response) {
                    // jika validate error
                    if (response.status ==
                        422) {
                        alert(response);
                    } else if (response.status == 500) {
                        alert(response);
                    }
                });
        } else {
        }

    });
</script>
@include('admin.issue.js_show_issue')
@endsection