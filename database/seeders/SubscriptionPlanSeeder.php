<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = \Carbon\Carbon::now();
        DB::table('subscription_plans')->insert([
            'name' => 'Standard Video',
            'color' => 'primary',
            'monthly' => 799,
            'yearly' => 4490,
            'contract' => 499,
            'max_licenses' => 1,
            'features' => '1 video license per month;Access to entire video library;Videos licensed to a company;Video exclusivity based on area of operation',
            'created_at' => $timestamp->toDateTimeString(),
            'updated_at' => $timestamp->toDateTimeString(),
        ]);
        DB::table('subscription_plans')->insert([
            'name' => 'Video + Marketing',
            'color' => 'success',
            'monthly' => 1699,
            'yearly' => 14875.17,
            'max_licenses' => 1,
            'features' => 'Professional Facebook Ad Management Service;1 video license per month;Access to entire video library;Videos licensed to a company;Video exclusivity based on area of operation',
            'created_at' => $timestamp->toDateTimeString(),
            'updated_at' => $timestamp->toDateTimeString(),
        ]);
    }
}
