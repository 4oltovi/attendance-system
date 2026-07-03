<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'phone', 'position', 'is_active'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'is_active' => 'boolean'];
    }

    public function attendanceSessions() { return $this->hasMany(AttendanceSession::class, 'supervisor_id'); }
    public function activityLogs() { return $this->hasMany(ActivityLog::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function isAdmin(): bool { return $this->hasRole('admin'); }
    public function isDean(): bool { return $this->hasRole('dean'); }
    public function isSupervisor(): bool { return $this->hasRole('supervisor'); }
}
