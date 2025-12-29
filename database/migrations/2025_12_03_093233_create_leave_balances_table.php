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
       Schema::create('leave_balance', function (Blueprint $table) {
    $table->id('balance_id');
    $table->foreignId('emp_id')->constrained('employee_profiles','emp_id')->onDelete('cascade');
    $table->foreignId('leave_type_id')->constrained('leave_types','leave_type_id')->onDelete('cascade');
    $table->integer('remaining_leaves')->default(0);
    $table->timestamps();
});
    }    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
