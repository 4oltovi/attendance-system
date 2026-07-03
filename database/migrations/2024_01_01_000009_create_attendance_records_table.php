<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('status', ['present', 'absent', 'excused', 'late']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['attendance_session_id', 'student_id'], 'unique_record_per_student_per_session');
            $table->index('student_id');
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('attendance_records'); }
};
