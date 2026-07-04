<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'module', 'description', 'model_type', 'model_id', 'old_values', 'new_values', 'ip_address', 'user_agent'];
    protected function casts(): array { return ['old_values' => 'array', 'new_values' => 'array']; }

    public function user() { return $this->belongsTo(User::class); }

    /**
     * Log an activity - Skip if user is superadmin (any variation of the name)
     */
    public static function log(string $action, string $module, ?string $description = null, mixed $model = null, ?array $oldValues = null, ?array $newValues = null): ?self
    {
        // Агар корбар superadmin бошад — лог сабт НАШАВАД
        if (auth()->check()) {
            $user = auth()->user();
            // Тафтиш аз рӯи нақш ВА email
            if ($user->hasRole('superadmin') || 
                $user->hasRole('super_admin') || 
                $user->email === 'superadmin@attendance.tj') {
                return null;
            }
        }

        return self::create([
            'user_id' => auth()->id(), 'action' => $action, 'module' => $module, 'description' => $description,
            'model_type' => $model ? get_class($model) : null, 'model_id' => $model?->id,
            'old_values' => $oldValues, 'new_values' => $newValues,
            'ip_address' => request()->ip(), 'user_agent' => request()->userAgent(),
        ]);
    }

    public function getActionLabelAttribute(): string {
        return match($this->action) { 'create' => 'Сохтан', 'update' => 'Тағйир додан', 'delete' => 'Нест кардан', 'login' => 'Воридшавӣ', 'logout' => 'Баромадан', 'attendance' => 'Ҳозирӣ', default => $this->action };
    }
    public function getModuleLabelAttribute(): string {
        return match($this->module) { 'users' => 'Корбарон', 'faculties' => 'Факултетҳо', 'specialties' => 'Ихтисосҳо', 'courses' => 'Курсҳо', 'groups' => 'Гурӯҳҳо', 'students' => 'Донишҷӯён', 'attendance' => 'Ҳозирӣ', 'auth' => 'Аутентификатсия', default => $this->module };
    }
}
