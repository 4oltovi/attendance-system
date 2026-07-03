<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder {
    public function run(): void {
        $admin = User::create(['name'=>'Администратор','email'=>'admin@attendance.tj','password'=>Hash::make('password123'),'phone'=>'+992900000001','position'=>'Администратори система','is_active'=>true]);
        $admin->assignRole('admin');
        $dean = User::create(['name'=>'Раҳимов Аҳмад','email'=>'dean@attendance.tj','password'=>Hash::make('password123'),'phone'=>'+992900000002','position'=>'Декан','is_active'=>true]);
        $dean->assignRole('dean');
        $supervisor = User::create(['name'=>'Каримов Фарҳод','email'=>'supervisor@attendance.tj','password'=>Hash::make('password123'),'phone'=>'+992900000003','position'=>'Масъули ҳозирӣ','is_active'=>true]);
        $supervisor->assignRole('supervisor');
    }
}
