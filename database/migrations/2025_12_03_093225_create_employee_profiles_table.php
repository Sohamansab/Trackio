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
        Schema::create('employee_profiles', function (Blueprint $table) {
    $table->id('emp_id');
    $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
    $table->string('employee_code')->unique();
    $table->string('name');
    $table->foreignId('department_id')->constrained('departments','department_id')->onDelete('restrict');
    $table->foreignId('designation_id')->constrained('designations','designation_id')->onDelete('restrict');
    $table->date('joining_date');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->foreignId('shift_id')->constrained('shifts','shift_id')->onDelete('set null')->nullable();
    $table->boolean('status')->default(true);
    $table->text('address')->nullable();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
