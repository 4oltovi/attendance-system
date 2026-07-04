<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder {
    public function run(): void {
        // Create superadmin role if not exists
        $role = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web'], ['description' => 'Суперадмин (бе лог)']);
        
        // Give all permissions
        $role->syncPermissions(Permission::all());

        // Create or update super admin user
        $user = User::firstOrCreate(
            ['email' => 'superadmin@attendance.tj'],
            [
                'name' => 'Суперадмин',
                'password' => Hash::make('super123'),
                'phone' => '+992900000000',
                'position' => 'Суперадмин',
                'is_active' => true,
            ]
        );
        $user->syncRoles(['superadmin']);

        echo "Суперадмин сохта шуд: superadmin@attendance.tj / super123\n";
    }
}
