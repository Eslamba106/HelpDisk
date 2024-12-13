<?php

namespace App\Http\Controllers\Complaint;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DepartmentController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){
        $this->authorize('departments');
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $departments = Department::when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate()->appends($query_param);

        if(isset($search) && empty($search)) {
            $departments = Department::with('departments')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }

        
        $data = [
            'departments' => $departments,
            'search' => $search,
        ];
        return view('admin-views.department.index', $data);
    }

    public function store(Request $request){
        $this->authorize('create_department');

        $request->validate([
            'name'              => "required|unique:departments",
         ],[
            'name.required'             => "الحقل مطلوب",
            'name.unique'               => "تم حجز الاسم مسبقا",
       ]);
        $department = Department::create([
            'name' => $request->name,
            'description' =>  $request->description ?? null, 
        ]);
        return redirect()->route('department')->with("success", __("تم الاضافة بنجاح"));

    }
    public function edit($id){

        $department = Department::findOrFail($id);
        return view("admin-views.department.edit", compact("department" ));
    }
    public function update(Request $request , $id){
        $this->authorize('edit_department');

        $department = Department::findOrFail($id);
        $validatedData = $request->validate([
             'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments')->ignore($department->id),
            ],
           
        ],[
            'name.unique'=> 'تم حجز الاسم من قبل ',
        ]);
        $department->update([
            "name"=> $request->name,
            "description"=> $request->description, 
        ]);
        
        return redirect()->route('department')->with("success", __("تم التحديث بنجاح"));
    }
    public function destroy(Request $request ){
        $this->authorize('delete_department');
        $department = Department::findOrFail($request->id);
        $department->delete();
        return redirect()->route("department")->with("success", __("تم الحذف بنجاح"));
    }
}
