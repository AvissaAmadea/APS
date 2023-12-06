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
            ['id' => 1, 'name' => 'superadmin',],
            ['id' => 2, 'name' => 'sekda',],
            ['id' => 3, 'name' => 'opd',]
        ];

        // Insert roles into the database
        foreach ($roles as $roles) {
            Role::updateOrCreate(['id' => $roles['id']], $roles);
        }
    }
}
