<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Complaint\PriorityController;
use App\Http\Controllers\Complaint\ComplaintController;
use App\Http\Controllers\ComplaintManagementController;
use App\Http\Controllers\Complaint\DepartmentController;
use App\Http\Controllers\RolesAndUsersManagement\RoleController;
use App\Http\Controllers\RolesAndUsersManagement\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// // Translation

Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
    session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang');


// Login Routes
Route::get('/', function () {
    if (auth()->check()) {    
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login-page');

Route::group(["prefix" => "auth"], function () {
    Route::post("login", [AuthController::class, "login"])->name("login");
    Route::get("logout", [AuthController::class, "logout"])->name("logout")->middleware('auth');
});


// Dashboard 
Route::group(["prefix"=> "dashboard"], function () {
    Route::get("/" , [DashboardController::class,"index"])->name("dashboard")->middleware('auth');
 });


// User Managment
Route::group(['prefix' => 'user_management'], function () {

    Route::get('/', [UserManagementController::class, 'index'])->name('user_management');
    Route::get('/create', [UserManagementController::class , 'create'])->name('user_management.create');
    Route::post('/create', [UserManagementController::class , 'store'])->name('user_management.store');
    Route::get('/edit/{id}' , [UserManagementController::class , 'edit'])->name('user_management.edit');
    Route::patch('/update/{id}' , [UserManagementController::class , 'update'])->name('user_management.update');
    Route::get('/delete', [UserManagementController::class ,'destroy'])->name('user_management.delete');

    Route::get('/signature', [UserManagementController::class, 'signature'])->name('user_management.signature');
    Route::post('/signature/store', [UserManagementController::class, 'storeSignature'])->name('user_management.store_signature');

});

// Roles
Route::group(['prefix' => 'roles'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/delete', [RoleController::class, 'destroy'])->name('roles.delete');
});

// Priority 

Route::group(['prefix'=> 'priority'], function () {
    Route::get('/', [PriorityController::class,'index'])->name('priority');
    Route::post('/store', [PriorityController::class, 'store'])->name('priority.store');
    Route::get('/edit/{id}', [PriorityController::class, 'edit'])->name('priority.edit');
    Route::post('/{id}/update', [PriorityController::class, 'update'])->name('priority.update');
    Route::get('/delete', [PriorityController::class, 'destroy'])->name('priority.delete');
});

// Departments 

Route::group(['prefix'=> 'department'], function () {
    Route::get('/', [DepartmentController::class,'index'])->name('department');
    Route::post('/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::patch('/{id}/update', [DepartmentController::class, 'update'])->name('department.update');
    Route::get('/delete', [DepartmentController::class, 'destroy'])->name('department.delete');
});

// Complaints 

Route::group(['prefix'=> 'complaints'], function () {
    Route::get('/', [ComplaintController::class,'index'])->name('complaint');
    Route::get('/not_fiexed', [ComplaintController::class,'not_fiexed'])->name('complaint.not_fiexed');
    Route::post('/store', [ComplaintController::class, 'store'])->name('complaint.store');
    Route::get('/edit/{id}', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::patch('/{id}/update', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::get('/delete', [ComplaintController::class, 'destroy'])->name('complaint.delete');
    Route::get('/export', [ComplaintController::class, 'exportExcel'])->name('complaint.export');

});


// Departments 

Route::group(['prefix'=> 'management_complaint'], function () {
    Route::get('/', [ComplaintManagementController::class,'index'])->name('complaint_management');
    Route::post('/store', [ComplaintManagementController::class, 'store'])->name('complaint_management.store');
    Route::get('/edit/{id}', [ComplaintManagementController::class, 'edit'])->name('complaint_management.edit');
    Route::patch('/{id}/update', [ComplaintManagementController::class, 'update'])->name('complaint_management.update');
    Route::get('/delete', [ComplaintManagementController::class, 'destroy'])->name('complaint_management.delete');
});

