<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;
    protected $primaryKey = 'user_id';
    protected $fillable = ['name','email','password','role','last_login','is_active'];

    public function employeeProfile() {
        return $this->hasOne(EmployeeProfile::class, 'user_id', 'user_id');
    }
    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }
    public function leaveApprovals() {
        return $this->hasMany(LeaveApprovalLog::class, 'approved_by', 'user_id');
    }
    public function auditLogs() {
        return $this->hasMany(AuditLog::class, 'user_id', 'user_id');
    }
}
