<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['faculty_id', 'specialty_id', 'course_id', 'name', 'academic_year', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function faculty() { return $this->belongsTo(Faculty::class); }
    public function specialty() { return $this->belongsTo(Specialty::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function students() { return $this->hasMany(Student::class); }
    public function attendanceSessions() { return $this->hasMany(AttendanceSession::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
}
