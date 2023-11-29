<?php

namespace Database\Seeders;

use App\Models\Dinas;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadminDinas = Dinas::where('nama_dinas', 'Dinas Komunikasi dan Informatika')->first();
        // Check if superadmin role exists
        $superadminRole = Roles::where('name', 'superadmin')->first();

        if (!$superadminRole) {
            $this->command->error('Superadmin role does not exist. Please create it first.');
            return;
        }

        // Check if a superadmin user already exists
        $existingSuperadmin = User::where('email', 'superadmin@example.com')->first();

        if (!$existingSuperadmin) {
            // Create Superadmin user
            $superadmin = User::create([
                'nama' => 'Superadmin',
                'nip' => '19191919',
                'jabatan' => 'Staf',
                'telp'=> '081234567789',
                'email' => 'avissaamadea21@gmail.com',
                'password' => Hash::make('avissa21'),
                'dinas_id' => $superadminDinas->id,
                'role_id' => $superadminRole->id,
            ]);

            $this->command->info('Superadmin created successfully.');
        } else {
            $this->command->info('Superadmin already exists.');
        }
    }
}
