<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@test.com';
        $password = Hash::make('12345678');
        if (!app()->environment(['local', 'development'])) {
            $password = Hash::make(Str::random(25));
        }
        $user->password = $password;
        $user->save();
    }
}
