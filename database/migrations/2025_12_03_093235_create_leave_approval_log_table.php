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
       Schema::create('leave_approval_log', function (Blueprint $table) {
    $table->id('log_id');
    $table->foreignId('leave_id')->constrained('leave_requests','leave_id')->onDelete('cascade');
    $table->foreignId('approved_by')->constrained('users','user_id')->onDelete('cascade');
    $table->string('status'); // approved/rejected
    $table->timestamp('timestamp')->useCurrent();
    $table->text('comment')->nullable();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_approval_logs');
    }
};
