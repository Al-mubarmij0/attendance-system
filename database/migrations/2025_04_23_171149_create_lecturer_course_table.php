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
        Schema::create('lecturer_course', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for the pivot table itself (optional, but harmless)

            // Foreign key for lecturers table
            $table->foreignId('lecturer_id')->constrained()->onDelete('cascade');
            // Foreign key for courses table (assuming you have a 'courses' table)
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // Add unique constraint to prevent duplicate entries (optional but good practice)
            $table->unique(['lecturer_id', 'course_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_course');
    }
};