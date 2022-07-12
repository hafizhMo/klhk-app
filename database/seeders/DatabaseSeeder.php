<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Users
        DB::table('users')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'User Biasa',
                    'email' => 'user@mail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => 'user',
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => 2,
                    'name' => 'Penelaah Berkas',
                    'email' => 'berkas@mail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => 'penelaah_berkas',
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => 3,
                    'name' => 'PBPHH',
                    'email' => 'pbphh@mail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => 'pbphh',
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => 4,
                    'name' => 'Kabid PHPL',
                    'email' => 'phpl@mail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => 'kabid_phpl',
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => 5,
                    'name' => 'Kepala Dinas',
                    'email' => 'kadin@mail.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => 'kadin',
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
        // Pengajuan
        // Pengajuan::factory()->count(10)->create();
    }
}
