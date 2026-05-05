<?php

namespace App\Http\Controllers\Admin\Issue;

//return type View
use Illuminate\View\View;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Issue;
use App\Models\Issue_jenis_buku;
use App\Models\Issue_level_publikasi;
use App\Models\Issue_penulis;
use App\Models\Issue_jenis_hak_cipta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Validation\ValidationException;

use App\Exports\IssuesExport;
use Maatwebsite\Excel\Facades\Excel;


class IssueController extends Controller
{
    function __construct()
    {
        // $this->middleware(['permission:role-list|role-create|role-edit|role-delete'], ['only' => ['index', 'store']]);
        // $this->middleware(['permission:role-create'], ['only' => ['create', 'store']]);
        // $this->middleware(['permission:role-edit'], ['only' => ['edit', 'update']]);
        // $this->middleware(['permission:role-delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // $q = $request->get('q');
        $q = $request->q;
        if ($q == null) {
            $q = '';
        }
        // $p = $request->get('perPage');
        $p = $request->perPage;
        if ($p == null) {
            $p = 10;
        }

        // count data for information above table
        $data_count['all_data'] = Issue::get()->count('*');

        if (auth()->user()->hasRole('admin')) {
            $datas = Issue::latest()
                ->where('judul', 'like', '%' . $q . '%')
                ->orWhere('link_publikasi', 'like', '%' . $q . '%')
                ->paginate($p)->withQueryString();
            // dd('admin');
        } else {
            $datas = Issue::latest()
                ->where('user_id', Auth::id())
                ->Where('judul', 'like', '%' . $q . '%')
                // ->orWhere('link_publikasi', 'like', '%' . $q . '%')
                ->paginate($p)->withQueryString();
        }

        foreach ($datas as $kd => $vd) {
            $dt_penulis = Issue_penulis::latest()
                ->where('issue_id', $vd->id)->get();
            $datas[$kd]['penulis_group'] = $dt_penulis;
        }
        // dd($datas);
        return view('admin.issue.index_issue', compact('datas', 'q', 'p', 'data_count'));
    }

    public function create()
    {
        $datas = new Issue;
        $datas_level_publikasi = Issue_level_publikasi::get();
        $form = 'c';
        $route = 'admin.issue.store';
        $breadcrumbs = 'create_new_issue';
        return view('admin.issue.create_issue', compact('route', 'form', 'datas', 'datas_level_publikasi', 'breadcrumbs'));
    }

    public function detail($id)
    {
        return view('admin.issue.detail_issue');
    }

    public function validasi_ajuan(Request $request, $id)
    {
        $dt = Issue::find($id);
        $input['issue_status'] = 1;
        $save = $dt->update($input);
        if ($save) {
            session()->flash('success', 'User update successfully');
            return response()->json([
                'success' => true,
                'errors' => false,
                'data' => $dt,
                'code' => '200',
                'message' => 'success update data',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => true,
                'data' => $dt,
                'code' => '200',
                'message' => 'Error update data',
            ]);
        }
    }

    public function show($id)
    {

        $dt['issue'] = Issue::find($id);
        $datas = $dt['issue'];
        if (!auth()->user()->hasRole('admin')) {
            if ($datas->user_id != Auth::id()) {
                return redirect()->route('admin.issue.index')
                    ->with('s', 'User restore successfully');
            }
        }
        $datas_level_publikasi = Issue_level_publikasi::get();
        $form = 's';
        $route = 'admin.issue.validasi_ajuan';
        $breadcrumbs = 'create_new_issue';

        $dt_issue = $dt['issue'];
        // dd($dt_issue);
        $dt_penulis = Issue_penulis::where('issue_id', $id)
            ->orderBy('penulis_ke', 'asc')
            ->get();
        $datas['penulis'] = $dt_penulis;

        if ($dt_issue->bentuk_luaran == "1") {
            // JIKA BENTUK LUARAN BUKU
            $dt['apresiasi'] = Issue_jenis_buku::find($dt['issue']->jenis_buku);
            $dt['apresiasi']['nama_apresiasi'] = $dt['apresiasi']->nama_jenis_buku;
            $dt['apresiasi']['nominal'] = $dt['apresiasi']->nominal_jenis_buku;
            $dt['apresiasi']['total'] = $dt['issue']->biaya_apc + $dt['apresiasi']->nominal_jenis_buku;

            // APRESIASI PENULIS 1 KORESPONDEN
            if ($dt_penulis[0]->koresponden == 1) {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 100;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'];
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    $dt_penulis[1]['persen'] = 40;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 40 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            } else {
                $dt['penulis_utama_ini'] = 'asdasd';
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 100;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'];
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    $dt_penulis[1]['persen'] = 40;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 40 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            }
        } elseif ($dt['issue']->bentuk_luaran == 2) {
            // JIKA BENTUK LUARAN PUBLIKASI
            $dt['apresiasi'] = Issue_level_publikasi::find($dt['issue']->level_publikasi);
            $dt['apresiasi']['nama_apresiasi'] = $dt['apresiasi']->nama_level_publikasi;
            $dt['apresiasi']['nominal'] = $dt['apresiasi']->nominal_level_publikasi;
            $dt['apresiasi']['total'] = $dt['issue']->biaya_apc + $dt['apresiasi']->nominal_level_publikasi;

            // APRESIASI PUBLIKASI PENULIS 1 KORESPONDEN
            if ($dt_penulis[0]->koresponden == 1) {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    $dt_penulis[1]['persen'] = 40;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 40 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            } else {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    $dt_penulis[1]['persen'] = 50;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 20 / (count($dt_penulis) - 2);
                    $dt_penulis[0]['persen'] = 40;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                    $dt_penulis[1]['persen'] = 40;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                    for ($i = 2; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            }
        } elseif ($dt['issue']->bentuk_luaran == 3) {
            // JIKA BENTUK LUARAN PUBLIKASI
            $dt['apresiasi'] = Issue_level_publikasi::find($dt['issue']->level_publikasi);
            $dt['apresiasi']['nama_apresiasi'] = $dt['apresiasi']->nama_level_publikasi;
            $dt['apresiasi']['nominal'] = $dt['apresiasi']->nominal_level_publikasi;
            $dt['apresiasi']['total'] = $dt['issue']->biaya_apc + $dt['apresiasi']->nominal_level_publikasi;

            // APRESIASI PROSIDING PENULIS 1 KORESPONDEN
            if ($dt_penulis[0]->koresponden == 1) {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    $dt_penulis[1]['persen'] = 40;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 40 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 60;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 60 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            } else {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    $dt_penulis[1]['persen'] = 50;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 20 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 40;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                    $dt_penulis[1]['persen'] = 40;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 40 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            }
        } elseif ($dt['issue']->bentuk_luaran == 4) {
            // JIKA BENTUK LUARAN HKI
            $dt['apresiasi'] = Issue_jenis_hak_cipta::find($dt['issue']->jenis_hak_cipta);
            $dt['apresiasi']['nama_apresiasi'] = $dt['apresiasi']->nama_jenis_hak_cipta;
            $dt['apresiasi']['nominal'] = $dt['apresiasi']->nominal_jenis_hak_cipta;
            $dt['apresiasi']['total'] = $dt['issue']->biaya_apc + $dt['apresiasi']->nominal_jenis_hak_cipta;

            // APRESIASI PUBLIKASI PENULIS 1 KORESPONDEN
            if ($dt_penulis[0]->koresponden == 1) {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 100;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'];
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    $dt_penulis[1]['persen'] = 50;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 50 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            } else {
                if (count($dt_penulis) < 2) {
                    $dt_penulis[0]['persen'] = 100;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'];
                } elseif (count($dt_penulis) == 2) {
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    $dt_penulis[1]['persen'] = 50;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                } elseif (count($dt_penulis) > 2) {
                    $persen_bagi = 20 / (count($dt_penulis) - 1);
                    $dt_penulis[0]['persen'] = 50;
                    $dt_penulis[0]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    $dt_penulis[1]['persen'] = 50;
                    $dt_penulis[1]['persen_nominal'] = $dt['apresiasi']['nominal'] * 50 / 100;
                    for ($i = 1; $i < count($dt_penulis); $i++) {
                        $dt_penulis[$i]['persen'] = $persen_bagi;
                        $dt_penulis[$i]['persen_nominal'] = $dt['apresiasi']['nominal'] * $persen_bagi / 100;
                    }
                }
                $dt['penulis'] = $dt_penulis;
            }
        }

        $data = $dt;
        // dd($data);
        // return view('admin.issue.show_issue', compact('data'));
        return view('admin.issue.show_issue', compact('route', 'form', 'datas', 'data', 'datas_level_publikasi', 'breadcrumbs'));
    }

    public function store($request)
    {
        $input = $request->all();
        if ($input['bentuk_luaran'] === "1") {
            $this->validate($request, [
                'bentuk_luaran' => 'required',
                'judul' => 'required',
                'jenis_buku' => 'required',
                'isbn_buku' => 'required',
                'penulis_utama' => 'required',
                'penulis.*' => 'required',
                'biaya_apc' => 'required',
                'bukti_pembayaran' => 'required|mimes:pdf',
                // 'penulis_bank.*' => 'required',
                // 'penulis_norek.*' => 'required',
                'penulis_jabatan.*' => 'required',
                'checkbox_confirm' => 'required',
            ], [], [
                'judul' => 'Judul',
            ]);
        } elseif ($input['bentuk_luaran'] === "2"  or $input['bentuk_luaran'] === "3") {
            $this->validate($request, [
                'bentuk_luaran' => 'required',
                'judul' => 'required',
                'jenis_publikasi' => 'required',
                'level_publikasi' => 'required',
                'link_publikasi' => 'required',
                'penulis_utama' => 'required',
                'penulis.*' => 'required',
                'biaya_apc' => 'required',
                'bukti_pembayaran' => 'required|mimes:pdf',
                // 'penulis_bank.*' => 'required',
                // 'penulis_norek.*' => 'required',
                'penulis_jabatan.*' => 'required',
                'checkbox_confirm' => 'required',
            ], [], [
                'judul' => 'Judul',
            ]);
        } elseif ($input['bentuk_luaran'] === "4") {
            $this->validate($request, [
                'bentuk_luaran' => 'required',
                'judul' => 'required',
                'penulis_utama' => 'required',
                'penulis.*' => 'required',
                'biaya_apc' => 'required',
                'jenis_hak_cipta' => 'required',
                'no_hak_cipta' => 'required',
                'bukti_pembayaran' => 'required|mimes:pdf',
                // 'penulis_bank.*' => 'required',
                // 'penulis_norek.*' => 'required',
                'penulis_jabatan.*' => 'required',
                'checkbox_confirm' => 'required',
            ], [], [
                'judul' => 'Judul',
            ]);
        } else {
            $this->validate($request, [
                'bentuk_luaran' => 'required',
            ], [], [
                'bentuk_luaran' => 'bentuk_luaran',
            ]);
        }

        // dd($input);
        // simpan image ke storage
        $file = $request->file('bukti_pembayaran');
        $hashedName = $file->hashName(); // Generates the hash
        $path = $file->storeAs('admin/bukti_pembayaran/', $hashedName, 'public');
        if ($path) {
            $input['bukti_pembayaran'] = $hashedName;
        } else {
            $input['bukti_pembayaran'] = "";
        }

        $input['user_id'] = Auth::id();
        // add data to db
        $array = $input;
        unset($array['penulis']);
        unset($array['penulis_utama']);
        $data = Issue::create($array);
        if ($data) {

            // INPUT DATA PENULIS KE TABEL PENULIS
            $issue_id = $data->id;
            $input_penulis = $input['penulis'];
            $input_penulis_jabatan = $input['penulis_jabatan'];
            $input_penulis_bank = $input['penulis_bank'];
            $input_penulis_norek = $input['penulis_norek'];
            $arr_penulis = [];
            foreach ($input_penulis as $kip => $vip) {

                // CEK SIAPA PENULIS UTAMA
                $arr_penulis[] = [
                    'issue_id' => $issue_id,
                    'penulis_ke' => $kip + 1,
                    'nama' => $vip,
                    'koresponden' => $input['penulis_utama'] == $kip ? 1 : 0,
                    'status' => '0',
                    'issue_penulis_jabatan_id' => $input_penulis_jabatan[$kip],
                    'penulis_bank' => $input_penulis_bank[$kip],
                    'no_rekening' => $input_penulis_norek[$kip],
                ];
            }
            $create_issue_penulis = Issue_penulis::insert($arr_penulis);
            if ($create_issue_penulis) {
                // dd('ok');
                session()->flash('success', 'Data created successfully');
                return response()->json([
                    'success' => true,
                    // 'errors' => true,
                    'data' => $data,
                    'code' => '200',
                    'message' => 'success store data',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => true,
                    'data' => $arr_penulis,
                    'code' => '200',
                    'message' => 'success store data',
                ]);
            }
        } else {
            return response()->json([
                'success' => true,
                'errors' => true,
                'data' => $data,
                'code' => '500',
                'message' => 'error store data',
            ]);
        }
    }

    public function edit($id)
    {
        $dt['issue'] = Issue::find($id);
        $datas = $dt['issue'];
        if (!auth()->user()->hasRole('admin')) {
            if ($datas->user_id != Auth::id()) {
                return redirect()->route('admin.issue.index')
                    ->with('s', 'User restore successfully');
            }
        }
        $form = 's';
        $route = 'admin.issue.update';
        $breadcrumbs = 'edit_pengajuan';
        $datas_level_publikasi = Issue_level_publikasi::get();
        $datas = Issue::find($id);
        $datas['penulis'] = Issue_penulis::where('issue_id', $id)
            ->orderBy('penulis_ke', 'asc')
            ->get();
        return view('admin.issue.edit_issue', compact('datas', 'route', 'form', 'datas_level_publikasi'));
    }

    public function update(Request $request, $id)
    {
        $datas = Issue::withTrashed()->find($id);
        if ($datas->issue_status == 1 and !auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'errors' => true,
                'data' => "error delete data penulis lama",
                'code' => '200',
                'message' => 'Tidak dapat mengubah ajuan setelah status ajuan diterima',
            ]);
        }
        $input = $request->all();
        $input['bentuk_luaran'] = $datas->bentuk_luaran;
        if ($input['bentuk_luaran'] == "1") {
            $this->validate($request, [
                // 'bentuk_luaran' => 'required',
                'judul' => 'required',
                'jenis_buku' => 'required',
                'isbn_buku' => 'required',
                'penulis_utama' => 'required',
                'penulis.*' => 'required',
                'biaya_apc' => 'required',
                'bukti_pembayaran' => 'mimes:pdf',
                // 'penulis_bank.*' => 'required',
                // 'penulis_norek.*' => 'required',
                'penulis_jabatan.*' => 'required',
                'checkbox_confirm' => 'required',
            ], [], [
                'judul' => 'Judul',
            ]);
        } elseif ($input['bentuk_luaran'] == "2"  or $input['bentuk_luaran'] == "3") {
            $this->validate($request, [
                // 'bentuk_luaran' => 'required',
                'judul' => 'required',
                'jenis_publikasi' => 'required',
                'level_publikasi' => 'required',
                'link_publikasi' => 'required',
                'penulis_utama' => 'required',
                'penulis.*' => 'required',
                'biaya_apc' => 'required',
                'bukti_pembayaran' => 'mimes:pdf',
                // 'penulis_bank.*' => 'required',
                // 'penulis_norek.*' => 'required',
                'penulis_jabatan.*' => 'required',
                'checkbox_confirm' => 'required',
            ], [], [
                'judul' => 'Judul',
            ]);
        } elseif ($input['bentuk_luaran'] == "4") {
            $this->validate($request, [
                // 'bentuk_luaran' => 'required',
                'judul' => 'required',
                'penulis_utama' => 'required',
                'penulis.*' => 'required',
                'biaya_apc' => 'required',
                'jenis_hak_cipta' => 'required',
                'no_hak_cipta' => 'required',
                'bukti_pembayaran' => 'mimes:pdf',
                // 'penulis_bank.*' => 'required',
                // 'penulis_norek.*' => 'required',
                'penulis_jabatan.*' => 'required',
                'checkbox_confirm' => 'required',
            ], [], [
                'judul' => 'Judul',
            ]);
        } else {
            $this->validate($request, [
                // 'bentuk_luaran' => 'required',
            ], [], [
                // 'bentuk_luaran' => 'bentuk_luaran',
            ]);
        }

        // SIMPAN DI STORAGE BILA ADA UPDATE FILE
        $file = $request->file('bukti_pembayaran');
        if ($file) {
            $hashedName = $file->hashName(); // Generates the hash
            $path = $file->storeAs('admin/bukti_pembayaran/', $hashedName, 'public');
            if ($path) {
                $input['bukti_pembayaran'] = $hashedName;
                Storage::disk('public')->delete('admin/bukti_pembayaran/' . $datas->bukti_pembayaran);
            } else {
                $input['bukti_pembayaran'] = "";
            }
            $input['bukti_pembayaran'] = $input['bukti_pembayaran'];
        } else {
            $input['bukti_pembayaran'] = $datas->bukti_pembayaran;
        }

        $input['user_id'] = $datas->user_id;
        // add data to db
        $array = $input;
        unset($array['penulis']);
        unset($array['penulis_utama']);
        $data = $datas->update($array);
        if ($data) {

            // INPUT DATA PENULIS KE TABEL PENULIS
            $issue_id = $datas->id;
            $input_penulis = $input['penulis'];
            $input_penulis_jabatan = $input['penulis_jabatan'];
            $input_penulis_bank = $input['penulis_bank'];
            $input_penulis_norek = $input['penulis_norek'];
            $arr_penulis = [];
            foreach ($input_penulis as $kip => $vip) {

                // CEK SIAPA PENULIS UTAMA
                $arr_penulis[] = [
                    'issue_id' => $issue_id,
                    'penulis_ke' => $kip + 1,
                    'nama' => $vip,
                    'koresponden' => $input['penulis_utama'] == $kip ? 1 : 0,
                    'status' => '0',
                    'issue_penulis_jabatan_id' => $input_penulis_jabatan[$kip],
                    'penulis_bank' => $input_penulis_bank[$kip],
                    'no_rekening' => $input_penulis_norek[$kip],
                    'status' => '0'
                ];
            }

            // HAPUS DATA PENULIS LAMA
            $data_penulis_old = Issue_penulis::where('issue_id', $id);
            $del_data_penulis_old = $data_penulis_old->delete();
            if ($del_data_penulis_old) {
                $create_issue_penulis = Issue_penulis::insert($arr_penulis);
                if ($create_issue_penulis) {
                    session()->flash('success', 'Data edit successfully');
                    return response()->json([
                        'success' => true,
                        // 'errors' => true,
                        'data' => $datas->id,
                        'code' => '200',
                        'message' => 'success store data',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'errors' => true,
                        'data' => $arr_penulis,
                        'code' => '200',
                        'message' => 'success store data',
                    ]);
                }
            } else {
                // JIKA GAGAL HAPUS DATA PENULIS LAMA
                return response()->json([
                    'success' => false,
                    'errors' => true,
                    'data' => "error delete data penulis lama",
                    'code' => '200',
                    'message' => 'error',
                ]);
            }
        } else {
            //
            return response()->json([
                'success' => true,
                'errors' => true,
                'data' => "error input data ajuan",
                'code' => '500',
                'message' => 'error store data',
            ]);
        }
    }

    public function export_issue()
    {
        return Excel::download(new IssuesExport, 'Issue.xlsx');
    }

    public function destroy($id)
    {
        $data = Issue::findOrFail($id);
        if (!auth()->user()->hasRole('admin')) {
            // User is an admin
            if ($data->issue_status != 0) {
                return response()->json([
                    'success' => false,
                    'errors' => true,
                    'data' => "Data deleted successfully",
                    'code' => '500',
                    'message' => 'Tidak dapat menghapus ajuan yg sudah diterima!',
                ]);
            } else {
            }
        }
        $data->delete();
        session()->flash('success', 'Data deleted successfully');
        return response()->json([
            'success' => true,
            'errors' => false,
            'data' => "Data deleted successfully",
            'code' => '500',
            'message' => 'Data deleted successfully',
        ]);
    }
}
