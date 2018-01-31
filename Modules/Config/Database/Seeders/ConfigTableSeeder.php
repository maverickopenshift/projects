<?php

namespace Modules\Config\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Config\Entities\Config;

class ConfigTableSeeder extends Seeder
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
        $admin->object_text = 'Penomoran Otomatis';
        $admin->object_key = 'auto-numb';
        $admin->object_value = 'off';
        $admin->object_desc = 'Konfigurasi penomoran otomatis';
        $admin->object_status = null;
        $admin->object_type = 'switch';
        $admin->save();
        
        $admin = new Config;
        $admin->object_text = 'PPN SP';
        $admin->object_key = 'ppn-sp';
        $admin->object_value = '5';
        $admin->object_desc = 'Konfigurasi PPN pada Surat Pesanan (SP)';
        $admin->object_status = null;
        $admin->object_type = null;
        $admin->save();
    }
}
