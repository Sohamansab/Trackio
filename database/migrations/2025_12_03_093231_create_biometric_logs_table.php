<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biometric_logs', function (Blueprint $table) {
    $table->id('log_id');
    $table->foreignId('emp_id')->constrained('employee_profiles','emp_id')->onDelete('cascade');
    $table->foreignId('device_id')->constrained('biometric_devices','device_id')->onDelete('cascade');
    $table->timestamp('timestamp');
    $table->enum('type',['finger','face'])->nullable();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biometric_logs');
    }
};
