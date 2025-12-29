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
       Schema::create('attendance', function (Blueprint $table) {
    $table->id('attendance_id');
    $table->foreignId('emp_id')->constrained('employee_profiles','emp_id')->onDelete('cascade');
    $table->date('date');
    $table->time('check_in')->nullable();
    $table->time('check_out')->nullable();
    $table->string('status')->default('present'); // e.g. present, absent, half_day, on_leave
    $table->enum('source_type',['biometric','qr','manual'])->default('manual');
    $table->timestamps();
});
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
