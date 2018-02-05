<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'id'           => 1,
                'name'         => 'system',
                'display_name' => '系统配置',
                'description'  => '系统配置',
                'model_name'   => \App\Models\Setting::class,
            ],
        ]);
    }
}
