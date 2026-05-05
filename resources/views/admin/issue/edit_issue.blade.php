@extends('admin.layouts.layout')
@section('content')
<div class="app-main__inner">
    <div class="app-page-title mb-0">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon"><i class="pe-7s-plus icon-gradient bg-mean-fruit"></i></div>
                <div>Form Edit Pengajuan Dana Apresiasi
                    <div class="page-title-subheading">
                        Admin -> Issue -> Edit form Pengajuan Dana Apresiasi
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel"
            aria-labelledby="tab-1">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ $message }}!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
            @endif
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Form</h5>
                    @if (isset($datas->id))
                    <form id="data-form" method="POST" action="{{ route($route, $datas->exists ? $datas->id : '') }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @else
                        <form id="data-form" method="POST"
                            action="{{ route($route, $datas->exists ? $datas->id : '') }}"
                            enctype="multipart/form-data">
                            @endif
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
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
                                        <option {{ $datas->bentuk_luaran==2 ? 'selected' : '' }} value="2">Publikasi
                                            Artikel
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
                                    <input value="{{$datas->judul}}" name="judul" id="judul"
                                        placeholder="Judul Buku atau Penelitian atau Nama Produk" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Jenis Buku</label>
                                <div class="col-sm-10">
                                    <select type="select" id="jenisBuku" name="jenis_buku" class="form-select">
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
                                    <input value="{{$datas->isbn_buku}}" name="isbn_buku" id="isbnBuku"
                                        placeholder="ISBN Buku" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Jenis Publikasi</label>
                                <div class="col-sm-10">
                                    <select type="select" id="jenisPublikasi" name="jenis_publikasi"
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
                                        <option {{ $datas->jenis_publikasi==7 ? 'selected' : '' }} value="7">Prosiding
                                            (ISSN
                                            atau ISBN) Nasional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Level Publikasi</label>
                                <div class="col-sm-10">
                                    <select type="select" id="levelPublikasi" name="level_publikasi"
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
                                    <input name="link_publikasi" id="linkPublikasi" placeholder="Link Publikasi"
                                        type="text" value="{{$datas->link_publikasi}}" class="form-control">
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Jenis Hak Cipta</label>
                                <div class="col-sm-10">
                                    <select type="select" id="jenisHakCipta" name="jenis_hak_cipta" class="form-select">
                                        <option value="">Select</option>
                                        <option {{ $datas->jenis_hak_cipta==1 ? 'selected' : '' }} value="1">Paten
                                            Desain
                                            Industri</option>
                                        <option {{ $datas->jenis_hak_cipta==2 ? 'selected' : '' }} value="2">Paten
                                            Sederhana
                                        </option>
                                        <option {{ $datas->jenis_hak_cipta==3 ? 'selected' : '' }} value="3">Hak Cipta
                                            dan
                                            Merek Produk Dagang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Nomor Hak Cipta/Paten</label>
                                <div class="col-sm-10">
                                    <input value="{{ $datas->no_hak_cipta}}" name="no_hak_cipta" id="noHakCipta"
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
                                            <input {{ $vdp->koresponden == "1" ? 'checked' :
                                            '' }} name="penulis_utama" value="{{$vdp->penulis_ke-1}}"
                                            type="radio"
                                            class="form-check-input form_input_penulis_utama">

                                        </div>
                                        <input value="{{$vdp->nama}}" placeholder="Penulis" type="text"
                                            class="form-control form_input_penulis" name="penulis[]">
                                        <select type="select" name="penulis_jabatan[]"
                                            class="form-select penulis_jabatan">
                                            <option value="">Jabatan/Instansi</option>
                                            <option {{ $vdp->issue_penulis_jabatan_id=='1' ? 'selected' : '' }}
                                                value="1">Dosen Poltek LPP</option>
                                            <option {{ $vdp->issue_penulis_jabatan_id=='2' ? 'selected' : '' }}
                                                value="2">Mahasiswa Poltek LPP</option>
                                            <option {{ $vdp->issue_penulis_jabatan_id=='3' ? 'selected' : '' }}
                                                value="3">Pihak Luar/Eksternal</option>
                                        </select>
                                        <input value="{{$vdp->penulis_bank}}" type="text" name="penulis_bank[]"
                                            class="form-control input_penulis_bank" placeholder="Bank">
                                        <input value="{{$vdp->no_rekening}}" type="text" name="penulis_norek[]"
                                            class="form-control input_penulis_norek" placeholder="No Rekening">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-2">
                                        <span id="btn_tambah_penulis" class="btn btn-secondary btn_tambah_penulis">+
                                            Tambah
                                            Penulis</span>
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Biaya APC</label>
                                <div class="col-sm-10 ">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input value="{{$datas->biaya_apc}}" name="biaya_apc" id="biayaAPC"
                                            placeholder="Rp" type="number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative row mb-3">
                                <label for="" class="form-label col-sm-2 col-form-label">Upload Bukti Pembayaran</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">File Bukti Pembayaran</span>
                                        <a class="disabled form-control"
                                            href="{{asset('storage/admin/bukti_pembayaran')}}/{{$datas->bukti_pembayaran}}"
                                            target="_blank">{{$datas->bukti_pembayaran}}</a>
                                    </div>
                                    <input name="bukti_pembayaran" id="buktiPembayaran" type="file"
                                        class="form-control">
                                    <small class="form-text text-muted">File diterima: PDF. (Maksimal: 10mb)</small>
                                </div>
                            </div>
                            <div class="position-relative row mb-3"><label for="checkbox2"
                                    class="form-label col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <div class="position-relative form-check"><label class="form-check-label">
                                            <input name="checkbox_confirm" id="checkbox2" type="checkbox"
                                                class="form-check-input"> Saya telah
                                            mengisi
                                            form data di atas dengan benar</label></div>
                                </div>
                            </div>
                            <div class="position-relative row form-check">
                                <div class="col-sm-10 offset-sm-2"><button type="submit" class="btn btn-primary">Submit
                                        Edit Ajuan</button>
                                </div>
                            </div>
                        </form>
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
        const formData = new FormData(form);
        // console.log(formData)
        const el2 = document.querySelector('#error-field');
        if (el2) {
            document.querySelectorAll('#error-field').forEach(el => el.remove());
        }

        axios({
            method: "POST",
            url: "{{ route($route, $datas->exists ? $datas->id : '') }}",
            data: formData,
            headers: { "Content-Type": "multipart/form-data", "accept": "application/json" },
        })
            .then(function (response) {
                //handle success
                console.log(response.data);
                if (response.data.errors) {
                    alert(response.data.message);
                }
                if (response.data.success) {
                    // console.log(data);
                    window.location.href = "{{ route('admin.issue.edit',$datas->id) }}";
                    // $('#saveBtn').html('Save Data');
                    // $('#saveBtn').attr('disabled', false);
                }
            })
            .catch(function (response) {
                // jika validate error
                if (response.status ==
                    422) {
                    const items = response.response.data.errors;
                    const item3 = Object.entries(items)
                    // console.log(item3)
                    item3.forEach(function (currentValue, error) {
                        const referenceElement = document.querySelector('[name="' + currentValue[0] + '"]');
                        if (referenceElement) {
                            referenceElement.insertAdjacentHTML('afterend', '<span id="error-field" style="color: red;">' +
                                currentValue[1] +
                                '</span>');
                        }
                    });

                    const element = document.querySelector('#error-field').parentElement
                    // const element = document.getElementById("error-field");
                    const headerOffset = 100; // tinggi header
                    const elementPosition = element.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                } else if (response.status == 500) {
                    // console.log("Server Error:", response, response);
                    alert(response);
                }
            });
    });
</script>
@include('admin.issue.js_issue')
@endsection