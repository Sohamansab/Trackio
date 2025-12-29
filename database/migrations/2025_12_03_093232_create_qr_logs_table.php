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
       Schema::create('qr_logs', function (Blueprint $table) {
    $table->id('qr_log_id');
    $table->foreignId('emp_id')->constrained('employee_profiles','emp_id')->onDelete('cascade');
    $table->timestamp('timestamp');
    $table->string('type')->nullable(); // e.g. 'ecard-scan'
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_logs');
    }
};
