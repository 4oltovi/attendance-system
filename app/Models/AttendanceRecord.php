<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = ['attendance_session_id', 'student_id', 'status', 'notes'];

    public function attendanceSession() { return $this->belongsTo(AttendanceSession::class); }
    public function student() { return $this->belongsTo(Student::class); }
    public function getStatusLabelAttribute(): string {
        return match($this->status) { 'present' => 'Ҳозир', 'absent' => 'Ғоиб', 'excused' => 'Сабабнок', 'late' => 'Дер омад', default => $this->status };
    }
    public function getStatusColorAttribute(): string {
        return match($this->status) { 'present' => 'success', 'absent' => 'danger', 'excused' => 'warning', 'late' => 'info', default => 'secondary' };
    }
}
