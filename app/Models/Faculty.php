<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function specialties() { return $this->hasMany(Specialty::class); }
    public function groups() { return $this->hasMany(Group::class); }
    public function students() { return $this->hasMany(Student::class); }
    public function attendanceSessions() { return $this->hasMany(AttendanceSession::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
}
