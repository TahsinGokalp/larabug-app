<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = new User();
        $item->name = 'Admin';
        $item->email = 'info@kodrika.com.tr';
        $item->password = 123456;
        $item->is_admin = true;
        $item->email_verified_at = now();
        $item->save();
    }
}
