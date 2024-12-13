<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ComplaintManagement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComplaintManagementController extends Controller
{

    use AuthorizesRequests;
    public function index(Request $request){
        $this->authorize('departments');
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';
        $departments = ComplaintManagement::when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate()->appends($query_param);

        if(isset($search) && empty($search)) {
            $departments = ComplaintManagement::with('departments')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }

        
        $data = [
            'complaint_managements' => $departments,
            'search' => $search,
        ];
        return view('admin-views.complaint_management.index', $data);
    }

    public function store(Request $request){
        $this->authorize('create_department');

        $request->validate([
            'name'              => "required|unique:departments",
         ],[
            'name.required'             => "الحقل مطلوب",
            'name.unique'               => "تم حجز الاسم مسبقا",
       ]);
        $department = ComplaintManagement::create([
            'name' => $request->name,
        ]);
        return redirect()->route('complaint_management')->with("success", __("تم الاضافة بنجاح"));

    }
    public function edit($id){

        $complaint = ComplaintManagement::findOrFail($id);
        return view("admin-views.complaint_management.edit", compact("complaint" ));
    }
    public function update(Request $request , $id){
        $this->authorize('edit_department');

        $department = ComplaintManagement::findOrFail($id);
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
        ]);
        
        return redirect()->route('complaint_management')->with("success", __("تم التحديث بنجاح"));
    }
    public function destroy(Request $request ){
        $this->authorize('delete_department');
        $department = ComplaintManagement::findOrFail($request->id);
        $department->delete();
        return redirect()->route("complaint_management")->with("success", __("تم الحذف بنجاح"));
    }

}
