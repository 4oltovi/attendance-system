<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder {
    public function run(): void {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            'users.view','users.create','users.edit','users.delete',
            'faculties.view','faculties.create','faculties.edit','faculties.delete',
            'specialties.view','specialties.create','specialties.edit','specialties.delete',
            'courses.view','courses.create','courses.edit','courses.delete',
            'groups.view','groups.create','groups.edit','groups.delete',
            'students.view','students.create','students.edit','students.delete','students.import',
            'attendance.view','attendance.create','attendance.edit','attendance.delete',
            'reports.view','reports.export','statistics.view','logs.view','logs.clear','permissions.manage',
        ];
        foreach ($permissions as $p) { Permission::create(['name' => $p]); }
        
        // Super Admin — ҳамон admin вале логҳо сабт НАШАВАД
        $superAdmin = Role::create(['name' => 'super_admin', 'description' => 'Суперадмин (бе лог)']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin — дастрасии пурра, амалҳояш дар лог сабт МЕШАВАД
        $admin = Role::create(['name' => 'admin', 'description' => 'Администратори система']);
        $admin->givePermissionTo(Permission::all());
        
        $dean = Role::create(['name' => 'dean', 'description' => 'Декан / Мудири таълимӣ']);
        $dean->givePermissionTo(['faculties.view','specialties.view','courses.view','groups.view','students.view','attendance.view','reports.view','reports.export','statistics.view']);
        
        $supervisor = Role::create(['name' => 'supervisor', 'description' => 'Масъули ҳозирӣ']);
        $supervisor->givePermissionTo(['faculties.view','specialties.view','courses.view','groups.view','students.view','attendance.view','attendance.create','attendance.edit','reports.view','reports.export','statistics.view']);
    }
}
