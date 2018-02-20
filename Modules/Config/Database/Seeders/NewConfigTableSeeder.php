<?php

namespace Modules\Config\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Config\Entities\Config;

class NewConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        
        
        $admin = new Config;
        $admin->object_text = 'Mulai Penomoran';
        $admin->object_key = 'start-number';
        $admin->object_value = '1';
        $admin->object_desc = 'Konfigurasi running number untuk penomoran kontrak';
        $admin->object_status = null;
        $admin->object_type = null;
        $admin->save();
    }
}
