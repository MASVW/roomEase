<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            ['name' => 'Student Life', 'nickname' => 'SL'],
            ['name' => 'Academic', 'nickname' => 'AC'],
            ['name' => 'General Affairs', 'nickname' => 'GA'],
            ['name' => 'Majelis Perwakilan Mahasiswa', 'nickname' => 'MPM'],
            ['name' => 'Badan Eksekutif Mahasiswa', 'nickname' => 'BEM'],
            ['name' => 'Himpunan Mahasiswa Program Studi Sistem Informasi', 'nickname' => 'HMPSSI'],
            ['name' => 'Himpunan Mahasiswa Program Studi Akuntansi', 'nickname' => 'HMPSA'],
            ['name' => 'Himpunan Mahasiswa Program Studi Manajemen', 'nickname' => 'HMPSM'],
            ['name' => 'Himpunan Mahasiswa Program Studi Hukum', 'nickname' => 'HMPSH'],
            ['name' => 'Himpunan Mahasiswa Program Studi Informatika', 'nickname' => 'HMPSIF'],
            ['name' => 'Unit Layanan Mahasiswa Spiritual Growth For Student', 'nickname' => 'SGS'],
            ['name' => 'Unit Layanan Mahasiswa Brand Of Ambassador', 'nickname' => 'AoU'],
            ['name' => 'Unit Layanan Mahasiswa Mentoring', 'nickname' => 'Mentor'],
            ['name' => 'Unit Kegiatan Mahasiswa Art Band', 'nickname' => 'Art Band Club'],
            ['name' => 'Unit Kegiatan Mahasiswa Choir', 'nickname' => 'Choir Club'],
            ['name' => 'Unit Kegiatan Mahasiswa Dance', 'nickname' => 'Dance Club'],
        ];

        $roles = [
            'AC' => 2, // Academic
            'GA' => 3, // General Affairs
            'SL' => 4, // Student Life
        ];

        foreach ($accounts as $account) {
            $userId = DB::table('users')->insertGetId([
                'name' => $account['name'],
                'nickname' => $account['nickname'],
                'email' => strtolower(str_replace(' ', '.', $account['nickname'])) . '@uphroomease.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);

            $roleId = $roles[$account['nickname']] ?? 1;

            DB::table('model_has_roles')->insert([
                'role_id' => $roleId,
                'model_type' => User::class,
                'model_id' => $userId,
            ]);

            DB::table('teams')->insert([
                'user_id' => $userId,
                'name' => $account['nickname'] . "'s Team",
                'personal_team' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}
