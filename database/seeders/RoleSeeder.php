<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed roles data
        $roles = [
            ['id' => 1, 'name' => 'Superadmin',],
            ['id' => 2, 'name' => 'SekDa',],
            ['id' => 3, 'name' => 'OPD',]
        ];

        // Insert roles into the database
        foreach ($roles as $roles) {
            Role::updateOrCreate(['id' => $roles['id']], $roles);
        }
    }
}
