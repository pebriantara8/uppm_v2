<?php

namespace App\Http\Controllers\Admin\User;

use App\Exports\IssuesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

//import Facade "Storage" for image
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        $q = $request->get('q');
        if ($q == null) {
            $q = '';
        }
        $p = $request->get('perPage');
        if ($p == null) {
            $p = 10;
        }

        // count data for information above table
        $data_count['all_data'] = User::get()->count('*');

        $datas = User::latest()
            ->where('name', 'like', '%' . $q . '%')
            ->orWhere('email', 'like', '%' . $q . '%')
            ->paginate($p)->withQueryString();
        return view('admin.user.index_user', compact('datas', 'q', 'p', 'data_count'));
    }

    public function trash(Request $request)
    {
        $q = $request->get('q');
        if ($q == null) {
            $q = '';
        }
        $p = $request->get('perPage');
        if ($p == null) {
            $p = 10;
        }

        // count data for information above table
        $data_count['all_data'] = User::get()->count('*');

        $datas = User::onlyTrashed()
            ->where('name', 'like', '%' . $q . '%')
            ->OrWhere('email', 'like', '%' . $q . '%')
            ->whereNotNull('deleted_at')
            ->latest()
            ->paginate($p);
        return view('admin.user.index_trash', compact('datas', 'q', 'p', 'data_count'));
    }

    public function create()
    {
        $datas = new User;
        $permission = User::get();
        $form = 'c';
        $route = 'admin.user.store';
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('admin.user.create_user', compact('form', 'route', 'datas', 'roles'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required',
            'birthday_date' => 'required',
            'religion' => 'required',
            'address' => 'required',
            'password' => 'required|same:confirm_password|min:6',
            'roles' => 'required',
            'img' => 'required|image|mimes:jpeg,jpg,png,HEIC'
        ], [], [
            'name' => 'full name',
            'roles' => 'role',
            'img' => 'image'
        ]);

        $input['password'] = Hash::make($input['password']);

        // simpan image ke storage
        $image = $request->file('img');
        $img = Image::make($image);
        $img->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
            // $constraint->upsize();
        });
        $file_name = $image->hashName();
        $img->save(public_path('storage/admin/user_image/') . $file_name);
        $input['image'] = $image->hashName();

        // add user to db
        $user = User::create($input);

        // tambah role ke user
        $role = Role::find($input['roles']);
        $user->assignRole($role->name);

        session()->flash('success', 'User created successfully');
        // return redirect()->route('admin.user.index')
        //                 ->with('success','User created successfully');
        return response()->json([
            'success' => true,
            // 'errors' => true,
            'data' => $user,
            'code' => '200',
            'message' => 'success store data',
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.user.index', compact('user'));
    }

    public function edit($id)
    {
        $datas = User::withTrashed()->find($id);
        $roles = Role::orderBy('id', 'DESC')->get();
        $userRole = $datas->roles->pluck('name')->all();
        $form = 'e';
        $route = 'admin.user.update';
        return view('admin.user.create', compact('datas', 'roles', 'route', 'form', 'userRole'));
    }

    public function edit_password($id)
    {
        $datas = User::find($id);
        $roles = Role::orderBy('id', 'DESC')->get();
        $userRole = $datas->roles->pluck('name')->all();
        $form = 'e';
        $route = 'admin.user.update_password';
        $tittle = 'Change Password';
        return view('admin.user.password_edit', compact('datas', 'roles', 'route', 'form', 'userRole'));
    }

    public function update_password(Request $request, $id)
    {
        $user = User::find($id);
        $input = $request->all();
        $this->validate($request, [
            'password' => 'required|same:confirm_password|min:6',
        ], [], [
            // 'password.required' => 'not match with confirmation password',
        ]);

        return response()->json([
            'success' => false,
            'errors' => true,
            'data' => '',
            'code' => '500e',
            'message' => 'Error update data',
        ]);

        $save = $user->update($input);
        if ($save) {
            session()->flash('success', 'User update successfully');
            return response()->json([
                'success' => true,
                // 'errors' => true,
                'data' => $user,
                'code' => '200',
                'message' => 'success update data',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => true,
                'data' => $user,
                'code' => '200',
                'message' => 'Error update data',
            ]);
        }
        // for password change with old password
        // $this->validate($request, [
        //     'old_password' => [
        //         'required', function ($attribute, $value, $fail) {
        //             if (!Hash::check($value, 'asdasdasd')) {
        //                 $fail('Old Password didn\'t match');
        //             }
        //         },
        //     ],
        //     'password' => 'required|same:confirm_password|min:6',
        // ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'birthday_date' => 'required',
            'religion' => 'required',
            'address' => 'required',
            'password' => 'same:confirm_password|min:6',
            'roles' => 'required',
        ], [], [
            'name' => 'full name',
            'roles' => 'role',
            'img' => 'image'
        ]);

        if (!$input['username'] == $user['username']) {
            $this->validate($request, [
                'username' => 'required|unique:users,username'
            ]);
        };
        if (!$input['email'] == $user['email']) {
            $this->validate($request, [
                'email' => 'required|unique:users,email'
            ]);
        };
        if ($request->file('img')) {
            $this->validate($request, [
                'img' => 'image|mimes:jpeg,jpg,png,HEIC'
            ]);

            $image = $request->file('img');
            $img = Image::make($image);
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                // $constraint->upsize();
            });
            $file_name = $image->hashName();
            $img->save(public_path('storage/admin/user_image/') . $file_name);
            $input['image'] = $image->hashName();

            Storage::delete('public/admin/user_image/' . $user->image);
        };

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $save = $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        // tambah role ke user
        $role = Role::find($input['roles']);
        $user->assignRole($role->name);

        // return redirect()->route('users.index')
        //                 ->with('success','User updated successfully');
        $save = $user->update($input);
        if ($save) {
            session()->flash('success', 'User update successfully');
            return response()->json([
                'success' => true,
                // 'errors' => true,
                'data' => $user,
                'code' => '200',
                'message' => 'success update data',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => true,
                'data' => $user,
                'code' => '200',
                'message' => 'Error update data',
            ]);
        }
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.user.index')
            ->with('success', 'User deleted successfully');
    }

    function force_delete($id)
    {
        $data = User::findOrFail($id);

        // delete image
        Storage::delete('public/admin/user_image', $data->image);

        // delete row
        $data->forceDelete();
        return redirect()->route('admin.user.index')
            ->with('success', 'User deleted successfully');
    }

    function restore($id)
    {
        $data = User::withTrashed()->findOrFail($id);
        $data->restore();
        return redirect()->route('admin.user.trash')
            ->with('success', 'User restore successfully');
    }

    function export_excel()
    {
        return Excel::download(new UsersExport, 'user_export.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
