<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model {
    protected $primaryKey = 'emp_id';
protected $fillable = [
    'user_id',
    'employee_code',
    'name',
    'department_id',
    'designation_id',
    'shift_id',
    'email',
    'phone',
    'joining_date',
    'address',
    'status',
];

    public function user() { return $this->belongsTo(User::class,'user_id','user_id'); }
    public function department() { return $this->belongsTo(Department::class,'department_id','department_id'); }
    public function designation() { return $this->belongsTo(Designation::class,'designation_id','designation_id'); }
    public function shift() { return $this->belongsTo(Shift::class,'shift_id','shift_id'); }

    public function attendance() { return $this->hasMany(Attendance::class,'emp_id','emp_id'); }
    public function leaveRequests() { return $this->hasMany(LeaveRequest::class,'emp_id','emp_id'); }
    public function biometricLogs() { return $this->hasMany(BiometricLog::class,'emp_id','emp_id'); }
    public function qrLogs() { return $this->hasMany(QrLog::class,'emp_id','emp_id'); }
    public function leaveBalance() { return $this->hasMany(LeaveBalance::class,'emp_id','emp_id'); }
    public function qrCard() { return $this->hasOne(QrCard::class,'emp_id','emp_id'); }
}
