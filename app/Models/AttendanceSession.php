<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['date', 'faculty_id', 'specialty_id', 'course_id', 'group_id', 'supervisor_id', 'notes'];
    protected function casts(): array { return ['date' => 'date']; }

    public function faculty() { return $this->belongsTo(Faculty::class); }
    public function specialty() { return $this->belongsTo(Specialty::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function group() { return $this->belongsTo(Group::class); }
    public function supervisor() { return $this->belongsTo(User::class, 'supervisor_id'); }
    public function records() { return $this->hasMany(AttendanceRecord::class); }
    public function getPresentCountAttribute(): int { return $this->records()->where('status', 'present')->count(); }
    public function getAbsentCountAttribute(): int { return $this->records()->where('status', 'absent')->count(); }
    public function getExcusedCountAttribute(): int { return $this->records()->where('status', 'excused')->count(); }
    public function getLateCountAttribute(): int { return $this->records()->where('status', 'late')->count(); }
}
