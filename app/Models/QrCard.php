<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QrCard extends Model {
    protected $primaryKey = 'qr_id';
    protected $fillable = ['emp_id','qr_code_path'];
    public function employee() { return $this->belongsTo(EmployeeProfile::class,'emp_id','emp_id'); }
}
