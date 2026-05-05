@extends('admin.layouts.layout')
@section('content')
<div class="app-main__inner">
    <div class="row">
        <div class="col-md-12">
            <form id="data_form" class="data_form" method="POST" action="{{ route($route, $datas->id) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card-hover-shadow profile-responsive mb-3 card">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-success">
                            <div class="menu-header-content">
                                <div class="avatar-icon-wrapper btn-hover-shine mb-2 avatar-icon-xl">
                                    <div class="avatar-icon rounded">
                                        <img src="{{ asset('storage/template') }}/assets/images/avatars/pengguna.jpg"
                                            alt="Avatar 6">
                                    </div>
                                </div>
                                <div>
                                    <h5 class="menu-header-title">{{auth()->user()->name}}</h5>
                                    <h6 class="menu-header-subtitle">Detail Profil</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($message = Session::get('success'))
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ $message }}!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4">
                                <div class="card-title">Identitas</div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">Nama</label>
                                    <input value="{{$datas->name}}" id="nama" name="nama" type="text"
                                        class="form-control" placeholder="Enter a name ...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">Email</label>
                                    <input value="{{$datas->email}}" id="email" name="email" type="text"
                                        class="form-control" placeholder="Enter an email ...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="message">Tentang Diri</label>
                                    <textarea class="form-control" id="message" name="tentang" rows="3"
                                        placeholder="Enter a message ...">{{$datas->about}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-title">Ganti Password</div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">Password Lama</label>
                                    <input id="passLama" name="pass_lama" type="text" class="form-control"
                                        placeholder="Isi password lama">
                                    <small class="form-text text-muted">Isi hanya jika ingin mengganti
                                        password</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">Password Baru</label>
                                    <input id="passBaru" name="pass_baru" type="text" class="form-control"
                                        placeholder="Isi password baru">
                                    <small class="form-text text-muted">Isi hanya jika ingin mengganti
                                        password</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="title">Konfirmasi Password Baru</label>
                                    <input id="passBaruKonfirmasi" name="pass_baru_konfirmasi" type="text"
                                        class="form-control" placeholder="Isi konfirmasi password baru">
                                    <small class="form-text text-muted">Isi hanya jika ingin mengganti
                                        password</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-title">Avatar Profil</div>
                                <img src="{{ asset('storage/template') }}/assets/images/avatars/pengguna.jpg"
                                    style="width: 100%;" alt="">
                                <div class="mb-3">
                                    <label class="form-label" for="showEasing">Ganti Avatar</label>
                                    <input id="fileAvatar" name="avatar" type="file" placeholder="swing, linear"
                                        class="form-control" value="swing">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center d-block card-footer">
                        <button class="me-2 text-danger btn btn-link btn-sm">Cancel</button>
                        <button type="submit" class="btn-shadow-primary btn btn-primary btn-lg">Update Profil</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('pagespecificscripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">

    const form1 = document.querySelector('#data_form');
    document.addEventListener('submit', (e) => {
        if (e.target.classList.contains('data_form')) {
            e.preventDefault();
            // if (confirm("Are you sure you want to delete this?")) {
            // User clicked 'OK' (Yes)
            // CLEAR ERROR FILE SHOW
            const el2 = document.querySelector('#error-field');
            if (el2) {
                document.querySelectorAll('#error-field').forEach(el => el.remove());
            }

            console.log("Item deleted.");
            const formData = new FormData(e.target);
            axios({
                method: e.target.method,
                url: e.target.action,
                data: formData,
                headers: { "Content-Type": "multipart/form-data", "accept": "application/json" },
            })
                .then(function (response) {
                    // HANDLE SUCCESS RESPONSE
                    console.log(response.data);
                    if (response.data.errors) {
                        alert(response.data.message);
                    }
                    if (response.data.success) {
                        window.location.href = "{{ route('admin.profile.index') }}";
                        // location.reload()
                    }
                })
                .catch(function (response) {
                    // VALIDATE ERROR
                    if (response.status ==
                        422) {
                        const items = response.response.data.errors;
                        const item3 = Object.entries(items)
                        item3.forEach(function (currentValue, error) {
                            const referenceElement = document.querySelector('[name="' + currentValue[0] + '"]');
                            if (referenceElement) {
                                referenceElement.insertAdjacentHTML('afterend', '<span id="error-field" style="color: red;">' +
                                    currentValue[1] +
                                    '</span>');
                            }
                        });

                        // SCROLL TO ERROR FIELD WITH CUSTOM OFFSET
                        const element = document.querySelector('#error-field').parentElement
                        const headerOffset = 100; // TINGGI HEADER
                        const elementPosition = element.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: "smooth"
                        });
                    } else if (response.status == 500) {
                        console.log("Server Error: ", response);
                        // alert(response);
                    }
                });
            // } else {
            //     // User clicked 'Cancel' (No)
            //     // console.log("Action cancelled.");
            // }
        }
    })

</script>
@endsection