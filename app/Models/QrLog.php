<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QrLog extends Model {
    protected $primaryKey = 'qr_log_id';
    protected $fillable = ['emp_id','timestamp','type'];
    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
}
