<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('employee_profiles', function (Blueprint $table) {
            $table->string('qr_code')->unique()->nullable();
            $table->string('qr_code_path')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('employee_profiles', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'qr_code_path']);
        });
    }
};
