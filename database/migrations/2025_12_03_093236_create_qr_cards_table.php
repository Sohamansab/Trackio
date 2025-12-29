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
        Schema::create('qr_cards', function (Blueprint $table) {
    $table->id('qr_id');
    $table->foreignId('emp_id')->constrained('employee_profiles','emp_id')->onDelete('cascade');
    $table->string('qr_code_path')->nullable(); 
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_cards');
    }
};
