<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $role = Role::whereName('Super Admin')->firstOrFail();
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => 'password',
            'role_id' => $role->id,
        ]);
    }
}
