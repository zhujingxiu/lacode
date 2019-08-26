<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_roles')->insert([
            [
                'id'=> 1,
                'role' => 'admin',
                'name' => '超管',
                'code' => 'superoot',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 2,
                'role' => 'admin',
                'name' => '管理员',
                'code' => 'admin',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 3,
                'role' => 'admin',
                'name' => '财务',
                'code' => 'finance',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 11,
                'role' => 'merchant',
                'name' => '管理员',
                'code' => 'admin',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 12,
                'role' => 'merchant',
                'name' => '分公司',
                'code' => 'company',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 13,
                'role' => 'merchant',
                'name' => '股东',
                'code' => 'shareholder',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 14,
                'role' => 'merchant',
                'name' => '总代理',
                'code' => 'agent',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 15,
                'role' => 'merchant',
                'name' => '代理',
                'code' => 'proxy',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'=> 16,
                'role' => 'merchant',
                'name' => '子帐号',
                'code' => 'child',
                'is_system'=>1,
                'status'=>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

        ]);
        DB::table('admins')->insert([
            [
                'id'=> 1,
                'admin_id' => 0,
                'name' => 'admin888',
                'nick_name' => '超管',
                'status'=>1,
                'reset'=>1,
                'online'=>1,
                'password' => bcrypt('admin888'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'admin_id' => 1,
                'name' => 'admin999',
                'nick_name' => '机构管理员',
                'status'=>1,
                'reset'=>1,
                'online'=>1,
                'password' => bcrypt('admin999'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'admin_id' => 1,
                'name' => 'admin000',
                'nick_name' => '机构财务',
                'status'=>1,
                'reset'=>1,
                'online'=>1,
                'password' => bcrypt('admin000'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        DB::table('admin_role_admin')->insert([
            [
                'role_id' => 1,
                'admin_id' => 1,
            ],
            [
                'role_id' => 2,
                'admin_id' => 2,
            ],
            [
                'role_id' => 3,
                'admin_id' => 3,
            ],
        ]);
    }
}
