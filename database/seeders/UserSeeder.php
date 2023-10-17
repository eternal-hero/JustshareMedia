<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = \Carbon\Carbon::now();
        DB::table('users')->insert([
            'first_name' => 'Ron',
            'email' => 'ron@zarbyte.com',
            'password' => Hash::make(env('ADMIN_PASSWORD_RON')),
            'created_at' => $timestamp->toDateTimeString(),
            'email_verified_at' => $timestamp->toDateTimeString(),
            'is_admin' => true,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Ryan',
            'email' => 'ryan@justsharemedia.com',
            'password' => Hash::make(env('ADMIN_PASSWORD_RYAN')),
            'created_at' => $timestamp->toDateTimeString(),
            'email_verified_at' => $timestamp->toDateTimeString(),
            'is_admin' => true,
        ]);
    }
}
