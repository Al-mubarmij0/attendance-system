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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('course_id');
            $table->string('day'); // Replaces class_date
            $table->time('start_time');
            $table->time('end_time');
            $table->string('venue')->nullable(); // Renamed from location
            $table->text('notes')->nullable();
            $table->timestamps();
    
            $table->foreign('lecturer_id')->references('id')->on('lecturers');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
