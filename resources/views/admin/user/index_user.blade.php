@extends('admin.layouts.layout')
@section('content')
<div class="app-main__inner">
    <div class="app-page-title mb-0">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon"><i class="pe-7s-users icon-gradient bg-mean-fruit"></i></div>
                <div>Data User
                    <div class="page-title-subheading">
                        Admin -> User
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ $message }}!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
            @endif
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row me-2 mb-3">
                        <div class="col-md-2">
                            <div class="me-3">
                                <div class="dataTables_length" id="DataTables_Table_0_length">
                                    <label>
                                        <form method="GET">
                                            <input type="hidden" name="q" value="{{ $q }}">
                                            <select onchange="this.form.submit()" name="perPage" class="form-select">
                                                <option @if ($p==10) selected @endif value="10">10
                                                </option>
                                                <option @if ($p==25) selected @endif value="25">25
                                                </option>
                                                <option @if ($p==50) selected @endif value="50">50
                                                </option>
                                                <option @if ($p==100) selected @endif value="100">100
                                                </option>
                                            </select>
                                        </form>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>
                                        <form method="GET">
                                            <input type="hidden" name="perPage" value="{{ $p }}">
                                            <input type="search" name="q" class="form-control" value="{{ $q }}"
                                                placeholder="Search.." aria-controls="DataTables_Table_0">
                                        </form>
                                    </label>
                                </div>
                                <div class="dt-buttons btn-group flex-wrap">
                                    <div class="btn-group"><button disabled
                                            class="btn btn-secondary dropdown-toggle mx-3 waves-effect waves-light"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span><i class="ti ti-screen-share me-1 ti-xs"></i>Export</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.user.index') }}">Excel</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="d-inline-block dropdown">
                                        <a href="{{ route('admin.user.create') }}" type="button" aria-expanded="false"
                                            class="btn-shadow btn btn-info"><span class="btn-icon-wrapper opacity-7">
                                            </span>Tambah User</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title">Tabel Data User</h5>
                    <table class="mb-0 table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 50%;">Nama</th>
                                <th style="width: 30%;">Email</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $datas->perPage() * ($datas->currentPage() - 1)+1; ?>
                            @foreach ($datas as $key => $data)
                            <tr>
                                <th scope="row">{{ $no++ }}</th>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>
                                    <div class="d-inline-block dropdown">
                                        <div role="group" class="btn-group-sm btn-group btn-group-toggle"
                                            data-toggle="buttons" data-bs-toggle="dropdown">
                                            <div class="ms-auto badge bg-alternate me-1">Detail</div>
                                            <div class="ms-auto badge bg-alternate me-1">Aksi
                                                <i class="fa fa-angle-down ms-2 opacity-8">
                                                </i>
                                            </div>
                                        </div>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.user.edit', $data->id) }}"><i
                                                    class="ti ti-pencil me-1"></i>
                                                Edit</a>
                                            <a class="dropdown-item" href="{{ route('admin.user.edit', $data->id) }}"><i
                                                    class="ti ti-pencil me-1"></i>
                                                Change Password</a>
                                            <form method="POST" onsubmit="return confirm('Apakah Anda Yakin?');"
                                                action="{{ route('admin.user.destroy', $data->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ti ti-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="paginatep-box mt-3">
                        {!! $datas->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection