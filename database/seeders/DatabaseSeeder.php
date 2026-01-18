<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions untuk Login
        $permissions = [
            'create login',
            'read login',
            'update login',
            'delete login',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 1. Admin ORYZA - C, R, U, D
        $adminOryza = Role::create(['name' => 'Admin ORYZA']);
        $adminOryza->givePermissionTo([
            'create login',
            'read login',
            'update login',
            'delete login',
        ]);

        // 2. Admin Client - C, R, U
        $adminClient = Role::create(['name' => 'Admin Client']);
        $adminClient->givePermissionTo([
            'create login',
            'read login',
            'update login',
        ]);

        // 3. Front Office - R, D
        $frontOffice = Role::create(['name' => 'Front Office']);
        $frontOffice->givePermissionTo([
            'read login',
            'delete login',
        ]);

        // 4. Back Office - R, D
        $backOffice = Role::create(['name' => 'Back Office']);
        $backOffice->givePermissionTo([
            'read login',
            'delete login',
        ]);

        // 5. Dokter - R, D
        $dokter = Role::create(['name' => 'Dokter']);
        $dokter->givePermissionTo([
            'read login',
            'delete login',
        ]);

        // 6. Perawat - R, D
        $perawat = Role::create(['name' => 'Perawat']);
        $perawat->givePermissionTo([
            'read login',
            'delete login',
        ]);

        // Create users dengan role masing-masing
        $userAdminOryza = User::factory()->create([
            'name_lengkap' => 'Admin Oryza',
            'username' => 'adminoryza',
            'password' => bcrypt('Admin123'),
        ]);
        $userAdminOryza->assignRole('Admin ORYZA');

        $userAdminClient = User::factory()->create([
            'name_lengkap' => 'Admin Client',
            'username' => 'adminclient',
            'password' => bcrypt('Admin123'),
        ]);
        $userAdminClient->assignRole('Admin Client');

        $userFrontOffice = User::factory()->create([
            'name_lengkap' => 'Front Office',
            'username' => 'frontoffice',
            'password' => bcrypt('Front123'),
        ]);
        $userFrontOffice->assignRole('Front Office');

        $userBackOffice = User::factory()->create([
            'name_lengkap' => 'Back Office',
            'username' => 'backoffice',
            'password' => bcrypt('Back123'),
        ]);
        $userBackOffice->assignRole('Back Office');

        $userDokter = User::factory()->create([
            'name_lengkap' => 'Dokter',
            'username' => 'dokter',
            'password' => bcrypt('Dokter123'),
        ]);
        $userDokter->assignRole('Dokter');

        $userPerawat = User::factory()->create([
            'name_lengkap' => 'Perawat',
            'username' => 'perawat',
            'password' => bcrypt('Perawat123'),
        ]);
        $userPerawat->assignRole('Perawat');
    }
}
