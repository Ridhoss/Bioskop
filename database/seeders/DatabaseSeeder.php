<?php

namespace Database\Seeders;

use App\Models\admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        // \App\Models\User::factory(10)->create();


        admin::create([
            'username' => 'admin',
            'password' => Hash::make('1'),
            'nama' => 'Ridho Sulistyo Saputro',
            'email' => 'ridhosulistyo1314@gmail.com',
            'no' => '0895401051613',
            'foto' => ''
        ]);

    }
}
