<?php

use Illuminate\Database\Seeder;

class MerchantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('merchants')->insert([
            [
                'id' => 1,
                'admin_id' => 1,
                'role_id' => 11,
                'parent_id' => null,
                'uid' => str_replace('-','',\Uuid::generate()),
                'name' => 'merchant100',
                'nick_name' => '商戶管理員',
                'status'=>1,
                'reset'=>1,
                'online'=>1,
                'password' => bcrypt('merchant100'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'admin_id' => 1,
                'role_id' => 12,
                'parent_id' => 1,
                'uid' => str_replace('-','',\Uuid::generate()),
                'name' => 'merchant111',
                'nick_name' => '分公司商戶',
                'status'=>1,
                'reset'=>1,
                'online'=>1,
                'password' => bcrypt('merchant111'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'admin_id' => 1,
                'role_id' => 13,
                'parent_id' => 2,
                'uid' => str_replace('-','',\Uuid::generate()),
                'name' => 'merchant222',
                'nick_name' => '股東商戶',
                'status'=>1,
                'reset'=>1,
                'online'=>1,
                'password' => bcrypt('merchant222'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
        DB::table('merchant_infos')->insert([
            [
                'merchant_id' => 1,
                'credit' => 0,
                'rate' => 0,
                'rate_limit' => 0,
                'rate_company' => 0,
                'replenish' => 0,
                'order_now' => 0,
                'charges'=>0,
            ],
            [
                'merchant_id' => 2,
                'credit' => 100000,
                'rate' => 20,
                'rate_limit' => 80,
                'rate_company' => 1,
                'replenish' => 1,
                'order_now' => 1,
                'charges'=>0,
            ],
            [
                'merchant_id' => 3,
                'credit' => 100000,
                'rate' => 30,
                'rate_limit' => 70,
                'rate_company' => 1,
                'replenish' => 1,
                'order_now' => 1,
                'charges'=>0,
            ],
        ]);
    }
}
