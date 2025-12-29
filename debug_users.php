<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::with('employeeProfile')->get();
foreach($users as $u) {
    $hasProfile = $u->employeeProfile ? 'YES' : 'NO';
    $role = $u->role == 1 ? 'Admin' : 'Employee';
    echo $u->email . ' (' . $role . ') - Profile: ' . $hasProfile;
    if ($u->employeeProfile) {
        echo ' - Dept ID: ' . ($u->employeeProfile->department_id ?? 'NULL');
        echo ' - Desig ID: ' . ($u->employeeProfile->designation_id ?? 'NULL');
    }
    echo PHP_EOL;
}