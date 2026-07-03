<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['student_id', 'first_name', 'last_name', 'middle_name', 'gender', 'date_of_birth', 'phone', 'faculty_id', 'specialty_id', 'course_id', 'group_id', 'enrollment_year', 'is_active'];
    protected function casts(): array { return ['date_of_birth' => 'date', 'is_active' => 'boolean']; }

    public function faculty() { return $this->belongsTo(Faculty::class); }
    public function specialty() { return $this->belongsTo(Specialty::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function group() { return $this->belongsTo(Group::class); }
    public function attendanceRecords() { return $this->hasMany(AttendanceRecord::class); }
    public function monthlyStatistics() { return $this->hasMany(MonthlyStatistic::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeSearch($query, $search) {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('student_id', 'like', "%{$search}%");
        });
    }
    public function getFullNameAttribute(): string {
        return "{$this->last_name} {$this->first_name}" . ($this->middle_name ? " {$this->middle_name}" : "");
    }
    public function getTotalPresentDays(): int { return $this->attendanceRecords()->where('status', 'present')->count(); }
    public function getTotalAbsentDays(): int { return $this->attendanceRecords()->where('status', 'absent')->count(); }
    public function getTotalExcusedDays(): int { return $this->attendanceRecords()->where('status', 'excused')->count(); }
    public function getTotalLateDays(): int { return $this->attendanceRecords()->where('status', 'late')->count(); }
    public function getTotalDays(): int { return $this->attendanceRecords()->count(); }
    public function getAttendancePercentage(): float {
        $total = $this->getTotalDays();
        if ($total === 0) return 0;
        return round((($this->getTotalPresentDays() + $this->getTotalLateDays()) / $total) * 100, 2);
    }
    public function getAbsencePercentage(): float {
        $total = $this->getTotalDays();
        if ($total === 0) return 0;
        return round(($this->getTotalAbsentDays() / $total) * 100, 2);
    }
    public function getMonthlyAttendance(int $year, int $month): array {
        $records = $this->attendanceRecords()->whereHas('attendanceSession', function ($q) use ($year, $month) {
            $q->whereYear('date', $year)->whereMonth('date', $month);
        })->get();
        $total = $records->count();
        return [
            'total' => $total, 'present' => $records->where('status', 'present')->count(),
            'absent' => $records->where('status', 'absent')->count(), 'excused' => $records->where('status', 'excused')->count(),
            'late' => $records->where('status', 'late')->count(),
            'attendance_percentage' => $total > 0 ? round((($records->where('status', 'present')->count() + $records->where('status', 'late')->count()) / $total) * 100, 2) : 0,
            'absence_percentage' => $total > 0 ? round(($records->where('status', 'absent')->count() / $total) * 100, 2) : 0,
        ];
    }
}
