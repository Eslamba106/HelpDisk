<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function priority(){
        return $this->belongsTo(Priority::class , 'priorirty_id');
    }
    public function complaint_management(){
        return $this->belongsTo(ComplaintManagement::class , 'complaint_management_id');
    }

}
