<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentLeaders = Role::create(['name' => 'student-leaders']);
        $academic = Role::create(['name' => 'academic']);
        $generalAffairs = Role::create(['name' => 'general-affairs']);
        $studentLife = Role::create(['name' => 'student-life']);

        // Membuat permissions
        $viewHome = Permission::create(['name' => 'view home']);
        $submitRental = Permission::create(['name' => 'submit rental']);
        $autoApproval = Permission::create(['name' => 'auto approve']);
        $manageRooms = Permission::create(['name' => 'manage rooms']);
        $manageAll = Permission::create(['name' => 'manage all']);

        // Menetapkan permissions ke roles
        $studentLeaders->givePermissionTo(['view home', 'submit rental']);
        $academic->givePermissionTo(['view home', 'submit rental', 'auto approve']);
        $generalAffairs->givePermissionTo(['manage rooms']);
        $studentLife->givePermissionTo(Permission::all());
    }
}
