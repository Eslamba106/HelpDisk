<?php

namespace App\Http\Controllers\RolesAndCompanyManagement;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyManagementController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $this->authorize('user_management');
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $companies = User::when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate()->appends($query_param);

        if(isset($search) && empty($search)) {
            $companies = User::with('users')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }

        
        $data = [
            'companies' => $companies,
            'search' => $search,
        ];
        
        // $ids = $request->bulk_ids;
        // $now = Carbon::now()->toDateTimeString();
        // if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
        //     $data = ['status' => $request->status];
        //     $this->authorize('change_users_status');
          
        //     User::whereIn('id', $ids)->update($data);
        //     return back()->with('success', __('تم التحديث بنجاح'));
        // }
        //  if ($request->bulk_action_btn === 'update_status' && $request->role && is_array($ids) && count($ids)) {
        //     $data = ['role_id' => $request->role];
        //     $this->authorize('change_users_role');

        //     ($request->role == 1) ? $data['role_name'] = "user" : $data['role_name'] = 'admin' ;
        //     $is_update = User::whereIn('id', $ids)->update($data);
            
        //     return back()->with('success', __('تم التحديث بنجاح'));
        // }
        // if ($request->bulk_action_btn === 'update_role' && $request->role_id && is_array($ids) && count($ids)) {
        //     $data = ['role_id' => $request->role_id];
        //     User::whereIn('id', $ids)->update($data);
        //     return back()->with('success', __('تم التحديث بنجاح'));
        // }
        // if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


        //     User::whereIn('id', $ids)->delete();
        //     return back()->with('success', __('تم الحذف بنجاح'));
        // }
        // $users = User::orderBy("created_at","desc")->paginate(10);
        return view("admin-views.companies.all_companies", $data);
    }

    public function edit($id){

        $company = User::findOrFail($id);
        return view("admin-views.companies.edit", compact("company"));
    }

    public function create(){
        $roles = Role::all();
        return view("admin.users.create" , compact("roles"));
    }
    public function store(Request $request){
        $request->validate([
            'name'              => "required",
            'user_name'         => "required|unique:users",
            'password'          => "required",
        ],[
            'name.required'         => "الحقل مطلوب",
            'user_name.required'         => "الحقل مطلوب",
            'user_name.unique'         => "تم حجز اسم المستخدم مسبقا",
            'password.required'         => "الحقل مطلوب",
        ]);
        $role = Role::where("id", $request->role)->first();
        $user = User::create([
            'name' => $request->name,
            'user_name' =>  $request->user_name,
            'role_name' => $role->role_name ?? 'user',
            'role_id' => $role->role_id ?? 1,
            'email' => $request->email ?? null,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.user_managment')->with("success", __("تم الاضافة بنجاح"));

    }
    public function update(Request $request , $id){
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
           
        ],[
            'user_name.unique'=> 'تم حجز اسم المستخدم من شخص اخر',
        ]);
        $user->update([
            "name"=> $request->name,
            "user_name"=> $request->user_name,
        ]);
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        return redirect()->route('admin.user_managment')->with("success", __("تم التحديث بنجاح"));
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("admin.user_managment")->with("success", __("تم الحذف بنجاح"));
    }

    public function signature()
    {
        $this->authorize('add_sginature');
        $user = Auth::user();
        return view('admin.users.add_signature', compact(['user']));
    }
    public function storeSignature(Request $request)
    {
        $this->authorize('add_sginature');
        $request->validate([
            'signatures.*' => 'string',
            'user_id' => 'required',
        ]);
        $user = User::find($request->user_id);
        $user->update([
            'signature'=> $request->signatures[0],
        ]);
        return redirect()->route('dashboard' )->with('success', 'All signatures saved successfully!');
    }
}
