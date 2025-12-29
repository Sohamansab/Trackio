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
Schema::create('audit_logs', function (Blueprint $table) {
    $table->id('audit_id');
    $table->foreignId('user_id')->constrained('users','user_id')->onDelete('set null')->nullable();
    $table->string('action');
    $table->timestamp('timestamp')->useCurrent();
    $table->text('description')->nullable();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
