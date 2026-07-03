<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('monthly_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->integer('year');
            $table->integer('month');
            $table->integer('total_days')->default(0);
            $table->integer('present_days')->default(0);
            $table->integer('absent_days')->default(0);
            $table->integer('excused_days')->default(0);
            $table->integer('late_days')->default(0);
            $table->decimal('attendance_percentage', 5, 2)->default(0);
            $table->decimal('absence_percentage', 5, 2)->default(0);
            $table->timestamps();
            $table->unique(['student_id', 'year', 'month'], 'unique_student_monthly_stats');
            $table->index(['year', 'month']);
        });
    }
    public function down(): void { Schema::dropIfExists('monthly_statistics'); }
};
