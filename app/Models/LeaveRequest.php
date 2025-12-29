<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model {
    protected $primaryKey = 'leave_id';
    protected $fillable = ['emp_id','leave_type_id','start_date','end_date','status','reason'];
    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
    public function type() { return $this->belongsTo(LeaveType::class,'leave_type_id','leave_type_id'); }
    public function approvals() { return $this->hasMany(LeaveApprovalLog::class,'leave_id','leave_id'); }
}
