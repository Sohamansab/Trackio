<?php

namespace App\Policies;

use App\Models\AttendanceAdjustment;
use App\Models\User;

class AttendanceAdjustmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role == 1;
    }

    public function view(User $user, AttendanceAdjustment $adjustment): bool
    {
        return $user->role == 1 || $user->user_id == $adjustment->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->role == 0;
    }

    public function update(User $user, AttendanceAdjustment $adjustment): bool
    {
        return $user->role == 1 && $adjustment->status == 'pending';
    }
}
