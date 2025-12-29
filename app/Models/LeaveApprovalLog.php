<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeaveApprovalLog extends Model {
    protected $table = 'leave_approval_log';
    protected $primaryKey = 'log_id';
    protected $fillable = ['leave_id','approved_by','status','timestamp','comment'];
    public $timestamps = false;
    public function leave() { return $this->belongsTo(LeaveRequest::class,'leave_id','leave_id'); }
    public function approver() { return $this->belongsTo(User::class,'approved_by','user_id'); }
}
