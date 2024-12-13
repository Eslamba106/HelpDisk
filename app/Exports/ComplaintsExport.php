<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\ComplaintManagement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComplaintsExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $serial = 1; 

        return Complaint::with(['user', 'priority'])
            ->get()
            ->map(function ($complaint) use (&$serial) {
                return [
                    'serial_number' => $serial++,
                    'complaint_management' => ComplaintManagement::where('id', $complaint->name)->first()->name ?? 'غير متوفر',
                    'department' => Department::where('id', $complaint->department_id)->first()->name ?? 'غير متوفر',
                    'user_name' => $complaint->user->name ?? 'غير متوفر',
                    'priority' => $complaint->priority->name ?? 'غير متوفر',
                    'description' => $complaint->description ?? 'لا يوجد',
                    'worker' => User::where('id', $complaint->worker)->first()->name ?? 'لم تحل بعد!',
                    'created_at' => $complaint->created_at->format('Y-m-d h:i A'),
                ];
            });    
        
    }
    public function headings(): array
    {
        return [
            'م',
            'اسم الشكوى',
            'القسم',
            'صاحب الشكوى',
            'الأولوية',
            'وصف الشكوى',
            'من قام بحل المشكلة',
            'أضيفت منذ',
        ];
    }
}
