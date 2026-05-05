<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Profile\ProfileAdminController;
use App\Http\Controllers\Admin\Issue\IssueController;
use App\Http\Controllers\Admin\Issue\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin/dashboard/home');
// });

Route::get('/', function () {
    // return view('dashboard');
    return redirect('/admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/logout', [ProfileController::class, 'edit'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //WORSHIP
    // Route::resource('/admin/worship', \App\Http\Controllers\Admin\Worship\WorshipController::class)->names('admin.worship');
});

// Route::get('admin', function () {
//     return "hellow";
// })->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::resource('/admin/dashboard', \App\Http\Controllers\Admin\Dashboard\DashboardController::class)->names('admin.dashboard');
    Route::resource('/admin/profile', \App\Http\Controllers\Admin\Profile\ProfileAdminController::class)->names('admin.profile');

    Route::get('/admin/issue/detail/{id}', [IssueController::class, 'detail'])->name('admin.issue.detail');
    Route::put('/admin/issue/validasi_ajuan/{id}', [IssueController::class, 'validasi_ajuan'])->name('admin.issue.validasi_ajuan');
    Route::get('/admin/issue/export_issue', [IssueController::class, 'export_issue'])->name('admin.issue.export_issue');
    Route::resource('/admin/issue', \App\Http\Controllers\Admin\Issue\IssueController::class)->names('admin.issue');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('/admin/user', \App\Http\Controllers\Admin\User\UserController::class)->names('admin.user');
    });
});
require __DIR__ . '/auth.php';
