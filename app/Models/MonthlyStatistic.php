<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyStatistic extends Model
{
    use HasFactory;
    protected $table = 'monthly_statistics';
    protected $fillable = ['student_id', 'year', 'month', 'total_days', 'present_days', 'absent_days', 'excused_days', 'late_days', 'attendance_percentage', 'absence_percentage'];
    public function student() { return $this->belongsTo(Student::class); }
}
