<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB; // Import DB facade

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed roles data
        $rolesData = [
            ['id' => 1, 'name' => 'superadmin',],
            ['id' => 2, 'name' => 'sekda',],
            ['id' => 3, 'name' => 'opd',]
        ];

        // Insert roles into the database
        foreach ($rolesData as $rolesData) {
            Roles::updateOrCreate(['id' => $rolesData['id']], $rolesData);
        }
    }
}
