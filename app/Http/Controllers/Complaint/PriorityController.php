<?php

namespace App\Http\Controllers\Complaint;

use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PriorityController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $this->authorize('priority');
        $this->authorize('all_priority');
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $priorities = Priority::when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate()->appends($query_param);

        if(isset($search) && empty($search)) {
            $priorities = Priority::with('priority')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }

        
        $data = [
            'priorities' => $priorities,
            'search' => $search,
        ];
        return view('admin-views.priority.index', $data);
    }
    public function store(Request $request){
        $this->authorize('add_new_priority');

        $request->validate([
            'name'              => "required|unique:priorities",
            'time'         => "required",
        ],[
            'name.required'             => "الحقل مطلوب",
            'time.required'             => "الحقل مطلوب",
            'name.unique'               => "تم حجز الاسم مسبقا",
            'password.required'         => "الحقل مطلوب",
        ]);
        $priority = Priority::create([
            'name' => $request->name,
            'time' =>  $request->time, 
        ]);
        return redirect()->route('priority')->with("success", __("تم الاضافة بنجاح"));

    }
    public function edit($id){
        $this->authorize('edit_priority');

        $priority = Priority::findOrFail($id);
        return view("admin-views.priority.edit", compact("priority" ));
    }
    public function update(Request $request , $id){
        $this->authorize('edit_priority');
        $priority = Priority::findOrFail($id);
        $validatedData = $request->validate([
            'time' => 'required',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('priorities')->ignore($priority->id),
            ],
           
        ],[
            'name.unique'=> 'تم حجز الاسم من قبل ',
        ]);
        $priority->update([
            "name"=> $request->name,
            "time"=> $request->time, 
        ]);
        
        return redirect()->route('priority')->with("success", __("تم التحديث بنجاح"));
    }
    public function destroy(Request $request ){
        $this->authorize('delete_priority');
        $priority = Priority::findOrFail($request->id);
        $priority->delete();
        return redirect()->route("priority")->with("success", __("تم الحذف بنجاح"));
    }
}
