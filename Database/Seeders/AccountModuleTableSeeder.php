<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use DB;

class AccountModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('module')->insert([
            [
                'name' => 'Account',
                'slug' => 'account',
                'is_scanable' => '1',
                'order' => 99999,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
