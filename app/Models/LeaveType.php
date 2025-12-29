<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model {
    protected $primaryKey = 'leave_type_id';
    protected $fillable = ['name','annual_allowed'];
    public function leaves() { return $this->hasMany(LeaveRequest::class,'leave_type_id','leave_type_id'); }
    public function balances() { return $this->hasMany(LeaveBalance::class,'leave_type_id','leave_type_id'); }
}
