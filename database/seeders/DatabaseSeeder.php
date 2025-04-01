<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
        $user = User::where('username','admin')->first();
        if(!isset($user)){
            $data = [
                'name'     => 'Admin',
                'username'     => 'admin',
                'email'     => 'admin@gmail.com',
                'password'     => Hash::make('admin99999'),
            ];
            $user = User::create($data);
        }
        $user = User::where('username','agent')->first();
        if(!isset($user)){
            $data = [
                'name'     => 'Agent',
                'username'     => 'agent',
                'email'     => 'agent@gmail.com',
                'password'     => Hash::make('admin99999'),
            ];
            $user = User::create($data);
        }
    }
}
