<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SuperAdmin = $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'status' => '1',
            'password' => Hash::make('1234567890'),
            'created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        Role::create([
            'name' => 'SuperAdmin',
            'created_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        $user->assignRole('SuperAdmin');
    }
}
