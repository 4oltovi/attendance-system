<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['course_number', 'name', 'description', 'is_active'];
    protected function casts(): array { return ['is_active' => 'boolean']; }

    public function groups() { return $this->hasMany(Group::class); }
    public function students() { return $this->hasMany(Student::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function getDisplayNameAttribute(): string { return $this->name ?? "Курси {$this->course_number}"; }
}
