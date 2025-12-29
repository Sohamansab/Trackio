<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model {
    protected $table = 'leave_balance';
    protected $primaryKey = 'balance_id';
    protected $fillable = ['emp_id','leave_type_id','remaining_leaves'];
    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
    public function leaveType() { return $this->belongsTo(LeaveType::class,'leave_type_id','leave_type_id'); }
}
