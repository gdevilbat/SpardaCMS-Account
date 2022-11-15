<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use DB;

use Gdevilbat\SpardaCMS\Modules\Core\Entities\Module;

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

        Module::firstOrCreate(
            ['slug' => 'account'],
            [
                'name' => 'Account',
                'is_scanable' => '1',
                'order' => 99999,
                'created_at' => \Carbon\Carbon::now()
            ]
        );
    }
}
