<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BiometricLog extends Model {
    protected $primaryKey = 'log_id';
    protected $fillable = ['emp_id','device_id','timestamp','type'];
    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
    public function device() { return $this->belongsTo(BiometricDevice::class,'device_id','device_id'); }
}
