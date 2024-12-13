<?php

namespace App\Http\Controllers\RolesAndUsersManagement;

use App\Models\Role;
use App\Models\Section;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('Show_Admin_Roles');
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $roles = Role::when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate()->appends($query_param);

        if(isset($search) && empty($search)) {
            $roles = Role::with('users')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }

        
        $data = [
            'roles' => $roles,
            'search' => $search,
        ];

        return view('admin-views.roles.lists', $data);
    }

    public function create()
    {
        $this->authorize('Create_Admin_Roles');
        $roles = Role::with('users')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        $sections = Section::whereNull('section_group_id')
            ->with('children')
            ->get();

        $data = [
            'pageTitle' => trans('admin/main.role_new_page_title'),
            'sections' => $sections,
            'roles' => $roles,
        ];

        return view('admin-views.roles.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('Create_Admin_Roles');

        $request->validate(  [
            'name' => 'required|min:3|max:64|unique:roles,name',
            'caption' => 'required|min:3|max:64|unique:roles,caption',
        ]);

        $data = $request->all();

        $role = Role::create([
            'name' => $data['name'],
            'caption' => $data['caption'],
            'is_admin' => (!empty($data['is_admin']) and $data['is_admin'] == 'on'),
            'created_at' => time(),
        ]);

        if ($request->has('permissions')) {
            $this->storePermission($role, $data['permissions']);
        }

        Cache::forget('sections');

        return redirect()->route('roles')->with('success' , "Created Successfully");
    }

    public function edit($id)
    {
        $this->authorize('Edit_Admin_Roles');

        $role = Role::find($id);
        $permissions = Permission::where('role_id', '=', $role->id)->get();
        $sections = Section::whereNull('section_group_id')
            ->with('children')
            ->get();

        $data = [
            'role' => $role,
            'sections' => $sections,
            'permissions' => $permissions->keyBy('section_id')
        ];

        return view('admin-views.roles.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('Update_Admin_Roles');

        $role = Role::find($id);

        $data = $request->all();

        $role->update([
            'caption' => $data['caption'],
            'is_admin' => ((!empty($data['is_admin']) and $data['is_admin'] == 'on') or $role->name == Role::$admin),
        ]);

        Permission::where('role_id', '=', $role->id)->delete();

        if (!empty($data['permissions'])) {
            $this->storePermission($role, $data['permissions']);
        }

        Cache::forget('sections');

        return redirect()->route('roles')->with('success' , "Updated Successfully");
    }

    public function destroy(Request $request)
    {
        $this->authorize('Delete_Admin_Roles');

        $role = Role::find($request->id);
        if ($role->id !== 2) {
            $role->delete();
        }

        return redirect()->route('roles')->with('success' , "Deleted Successfully");
    }

    public function storePermission($role, $sections)
    {
        $sectionsId = Section::whereIn('id', $sections)->pluck('id');
        $permissions = [];
        foreach ($sectionsId as $section_id) {
            $permissions[] = [
                'role_id' => $role->id,
                'section_id' => $section_id,
                'allow' => true,
            ];
        }
        Permission::insert($permissions);
    }
}