<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    protected $fillable = ['emp_id','date','check_in','check_out','status','source_type'];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
    public function lateExemptions() { return $this->hasMany(LateExemptionRequest::class,'attendance_id','attendance_id'); }
}

