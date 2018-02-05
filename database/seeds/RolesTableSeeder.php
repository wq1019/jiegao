<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('permission.table_names');
        $defaultGuardName = config('auth.defaults.guard');
        DB::table($tableNames['roles'])->insert([
            [
                'id'           => 1,
                'name'         => 'super_admin',
                'guard_name'   => $defaultGuardName,
                'display_name' => '超级管理员',
                'description'  => '超级管理员',
                'order'        => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ], [
                'id'           => 2,
                'name'         => 'poster',
                'guard_name'   => $defaultGuardName,
                'display_name' => '文章发布者',
                'description'  => '文章发布者',
                'order'        => 0,
                'created_at'   => \Carbon\Carbon::now(),
                'updated_at'   => \Carbon\Carbon::now(),
            ],
        ]);
        DB::table($tableNames['role_has_permissions'])->insert([
            [
                'permission_id' => 4,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 5,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 6,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 7,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 8,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 9,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 10,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 11,
                'role_id'       => 1,
            ],
        ]);
    }
}
