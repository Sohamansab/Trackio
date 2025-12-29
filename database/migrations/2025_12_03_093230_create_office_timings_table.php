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
        Schema::create('office_timings', function (Blueprint $table) {
    $table->id('office_timing_id');
    $table->time('start_time');
    $table->time('end_time');
    $table->integer('break_minutes')->default(0);
    $table->integer('grace_minutes')->default(0);
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_timings');
    }
};
