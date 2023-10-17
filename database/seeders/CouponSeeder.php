<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = \Carbon\Carbon::now();
        DB::table('coupons')->insert([
            'code' => 'percentage2021',
            'type' => 'percentage',
            'value' => '[20, 30, 0]',
            'terms' => '["monthly", "yearly"]',
            'plans' => '[1, 2]',
            'notes' => 'JSM percentage test coupon',
            'enabled' => true,
            'created_at' => $timestamp,
        ]);
        DB::table('coupons')->insert([
            'code' => 'fixed2021',
            'type' => 'fixed',
            'value' => '[75, 150, 0]',
            'terms' => '["monthly", "yearly"]',
            'plans' => '[1, 2]',
            'notes' => 'JSM fixed test coupon',
            'enabled' => true,
            'created_at' => $timestamp,
        ]);
        DB::table('coupons')->insert([
            'code' => 'iamdisabled',
            'type' => 'percentage',
            'value' => '[20, 30, 0]',
            'terms' => '["monthly", "yearly"]',
            'plans' => '[1, 2]',
            'notes' => 'JSM percentage test coupon',
            'enabled' => false,
            'created_at' => $timestamp,
        ]);
        DB::table('coupons')->insert([
            'code' => 'contractfixed',
            'type' => 'fixed',
            'value' => '[0, 0, 50]',
            'terms' => '["contract"]',
            'plans' => '[1]',
            'notes' => 'JSM contact fixed test coupon',
            'enabled' => true,
            'created_at' => $timestamp,
        ]);
        DB::table('coupons')->insert([
            'code' => 'recurringtest',
            'type' => 'percentage',
            'value' => '[50, 50, 50]',
            'terms' => '["monthly", "yearly", "contract"]',
            'plans' => '[1, 2]',
            'notes' => 'JSM recurring percentage test coupon',
            'enabled' => true,
            'recurring' => true,
            'created_at' => $timestamp,
        ]);
    }
}
