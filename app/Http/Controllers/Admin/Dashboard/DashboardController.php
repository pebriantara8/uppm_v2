<?php

namespace App\Http\Controllers\Admin\Dashboard;

//return type View
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\Controller;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    //     /**
    //  * index
    //  *
    //  * @return View
    //  */
    // public function index() : View {
    //     return View('welcome');
    // }

    public function index()
    {
        $datas['total_issue'] = Issue::count();
        $datas['total_user'] = User::count();
        $datas['issue_acc'] = count(Issue::where('issue_status', 1)->get());
        return View('admin.dashboard.home', compact('datas'));
    }

    public function show(): View
    {
        return View('admin.dashboard.dashboard');
    }

    public function analytic()
    {
        return View('admin.auth.register');
    }

    public function amir()
    {
        // return view('admin.auth.register');
        return View('welcome');
    }
}
