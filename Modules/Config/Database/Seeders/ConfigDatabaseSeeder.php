<?php

namespace Modules\Config\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Config\D\DocCategory;

class ConfigDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //$this->call(ConfigTableSeeder::class);
        $this->call(NewConfigTableSeeder::class);
    }
}
