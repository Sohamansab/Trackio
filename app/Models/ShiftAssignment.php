<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ShiftAssignment extends Model {
    protected $primaryKey = 'assignment_id';
    protected $fillable = ['emp_id','shift_id','effective_date'];
    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
    public function shift() { return $this->belongsTo(Shift::class,'shift_id','shift_id'); }
}
