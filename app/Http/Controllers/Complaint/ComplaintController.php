<?php

namespace App\Http\Controllers\Complaint;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Priority;
use App\Models\Complaint;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\ComplaintsExport;
use App\Models\ComplaintManagement;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\ComplaintNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComplaintController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('complaints');
        $ids = $request->bulk_ids;

        if ($request->bulk_action_btn === 'update_status'  && is_array($ids) && count($ids)) {
            $data = ['status' => 1, 'worker' => $request->worker];
            $update_status = Complaint::whereIn('id', $ids)->update($data);
            $complaints = Complaint::whereIn('id', $ids)->get();
            if ($update_status && $complaints) {
                foreach ($complaints as $complaint) {
                    $data = [
                        'title' => "تم تصليح المشكلة " . $complaint->complaint_management->name,
                        'body' => $complaint->description,
                        'id' => $complaint->id,
                        'url' => route('complaint'),
                    ];
                    $complaint->user->notify(new ComplaintNotification($data));
                }
            }

            return back()->with('success', __('تم التحديث بنجاح'));
        }

        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';
        if ($request->from && $request->to) {
            $fromDate = Carbon::parse($request->from)->startOfDay();
            $toDate = Carbon::parse($request->to)->subDay()->endOfDay();
        }
        // $complaints->whereBetween('created_at', [$fromDate, $toDate]);
        if (auth()->user()->role_id == 1) {
            if ($request->bulk_action_btn === 'filter' && isset($request->from) && isset($request->to)) {
                $complaints = Complaint::where('user_id', auth()->id())->whereBetween('created_at', [$fromDate, $toDate])->when($request['search'], function ($q) use ($request) {
                    $key = explode(' ', $request['search']);
                    foreach ($key as $value) {
                        $q->Where('name', 'like', "%{$value}%")
                            ->orWhere('id', $value);
                    }
                })
                    ->latest()->paginate()->appends($query_param);
            } else {
                $complaints = Complaint::where('user_id', auth()->id())->when($request['search'], function ($q) use ($request) {
                    $key = explode(' ', $request['search']);
                    foreach ($key as $value) {
                        $q->Where('name', 'like', "%{$value}%")
                            ->orWhere('id', $value);
                    }
                })
                    ->latest()->paginate()->appends($query_param);
            }
        } else {
            if ($request->bulk_action_btn === 'filter' && isset($request->from) && isset($request->to)) {
                $complaints = Complaint::when($request['search'], function ($q) use ($request) {
                    $key = explode(' ', $request['search']);
                    foreach ($key as $value) {
                        $q->Where('name', 'like', "%{$value}%")
                            ->orWhere('id', $value);
                    }
                })->whereBetween('created_at', [$fromDate, $toDate])
                    ->latest()->paginate()->appends($query_param);
            } else {
                $complaints = Complaint::when($request['search'], function ($q) use ($request) {
                    $key = explode(' ', $request['search']);
                    foreach ($key as $value) {
                        $q->Where('name', 'like', "%{$value}%")
                            ->orWhere('id', $value);
                    }
                })
                    ->latest()->paginate()->appends($query_param);
            }
        }


        if (isset($search) && empty($search)) {
            if (auth()->user()->role_id == 1) {
                $complaints = Complaint::with('complaints')->where('user_id', auth()->id())
                    ->orderBy('created_at', 'asc')
                    ->paginate(10);
            } else {
                $complaints = Complaint::with('complaints')
                    ->orderBy('created_at', 'asc')
                    ->paginate(10);
            }
        }
        $ids = $request->bulk_ids;
        if ($request->bulk_action_btn === 'update_status' && $request->role && is_array($ids) && count($ids)) {
            $data = ['role_id' => $request->role];
            $this->authorize('change_users_role');

            ($request->role == 1) ? $data['role_name'] = "user" : $data['role_name'] = 'admin';
            $is_update = User::whereIn('id', $ids)->update($data);

            return back()->with('success', __('تم التحديث بنجاح'));
        }

        $priorirties = Priority::get();
        $workers     = User::get();
        $departments = Department::get();
        $complaint_managements = ComplaintManagement::get();
        $data = [
            'complaints'    => $complaints,
            'search'        => $search,
            'priorirties'   => $priorirties,
            'workers'       => $workers,
            'departments'   => $departments,
            'complaint_managements' => $complaint_managements,
        ];
        return view('admin-views.complaint.index', $data);
    }
    public function not_fiexed(Request $request)
    {
        $this->authorize('complaints');
        $ids = $request->bulk_ids;

        if ($request->bulk_action_btn === 'update_status'  && is_array($ids) && count($ids)) {
            $data = ['status' => 1, 'worker' => $request->worker];
            Complaint::whereIn('id', $ids)->update($data);
            return back()->with('success', __('تم التحديث بنجاح'));
        }

        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';
        if (auth()->user()->role_id == 1) {
            $complaints = Complaint::where('status', '!=', 1)->orWhereNull('status')->where('user_id', auth()->id())->when($request['search'], function ($q) use ($request) {
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                        ->orWhere('id', $value);
                }
            })
                ->latest()->paginate()->appends($query_param);
        } else {
            $complaints = Complaint::where('status', '!=', 1)->orWhereNull('status')->when($request['search'], function ($q) use ($request) {
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                        ->orWhere('id', $value);
                }
            })
                ->latest()->paginate()->appends($query_param);
        }


        if (isset($search) && empty($search)) {
            if (auth()->user()->role_id == 1) {
                $complaints = Complaint::where('status', '!=', 1)->orWhereNull('status')->where('user_id', auth()->id())->with('complaints')
                    ->orderBy('created_at', 'asc')
                    ->paginate(10);
            } else {
                $complaints = Complaint::where('status', '!=', 1)->orWhereNull('status')->with('complaints')
                    ->orderBy('created_at', 'asc')
                    ->paginate(10);
            }
        }
        $ids = $request->bulk_ids;
        if ($request->bulk_action_btn === 'update_status' && $request->role && is_array($ids) && count($ids)) {
            $data = ['role_id' => $request->role];
            $this->authorize('change_users_role');

            ($request->role == 1) ? $data['role_name'] = "user" : $data['role_name'] = 'admin';
            $is_update = User::whereIn('id', $ids)->update($data);

            return back()->with('success', __('تم التحديث بنجاح'));
        }

        $priorirties = Priority::get();
        $workers     = User::get();
        $departments = Department::get();
        $complaint_managements = ComplaintManagement::get();
        $data = [
            'complaints'    => $complaints,
            'search'        => $search,
            'priorirties'   => $priorirties,
            'workers'       => $workers,
            'departments'   => $departments,
            'complaint_managements' => $complaint_managements,

        ];
        return view('admin-views.complaint.index', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('add_new_complaint');
        // $request->validate([
        //     'name'              => "required",
        // ], [
        //     'name.required'             => "الحقل مطلوب",
        // ]);
        $complaint = Complaint::create([
            // 'name'              => $request->name,
            'priorirty_id'      => $request->priorirty_id,
            'department_id'     => $request->department_id,
            'complaint_management_id'     => $request->complaint_management_id,
            'description'       => $request->description ?? null,
            'user_id'           => auth()->id() ?? null,
        ]);
        if (isset($complaint)) {
            $users = User::where('role_id', 2)->get();
            $data = [
                'title' => "تم اضافة شكوي " . $complaint->complaint_management->name,
                'body' => $complaint->description,
                'id' => $complaint->id,
                'url' => route('complaint'),
            ];
            foreach ($users as $user) {
                $user->notify(new ComplaintNotification($data));
            }
        }
        return redirect()->route('complaint')->with("success", __("تم الاضافة بنجاح"));
    }
    public function edit($id)
    {
        $this->authorize('edit_complaint');

        $complaint = Complaint::findOrFail($id);
        $priorirties = Priority::get();
        $departments = Department::get();
        $data = [
            'complaint'    => $complaint,
            'priorirties'   => $priorirties,
            'departments'   => $departments,
        ];
        return view("admin-views.complaint.edit", $data);
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit_complaint');

        $complaint = Complaint::findOrFail($id);
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

        ]);
        $complaint->update([
            "name"              => $request->name,
            'priorirty_id'      => $request->priorirty_id,
            'department_id'     => $request->department_id,
            'complaint_management_id'     => $request->complaint_management_id,
            "description"       => $request->description,
        ]);

        return redirect()->route('complaint')->with("success", __("تم التحديث بنجاح"));
    }
    public function destroy(Request $request)
    {
        $this->authorize('delete_complaint');

        $complaint = Complaint::findOrFail($request->id);
        $complaint->delete();
        return redirect()->route("complaint")->with("success", __("تم الحذف بنجاح"));
    }

    public function exportExcel()
    {
        return Excel::download(new ComplaintsExport, 'complaints.xlsx');
    }
    public function MarkAsRead_all(Request $request)
    {
        $userUnreadNotification = auth()->user()->unreadNotifications;
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }
}
