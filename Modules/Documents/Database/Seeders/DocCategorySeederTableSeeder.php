<?php

namespace Modules\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Documents\Entities\DocCategory;

class DocCategorySeederTableSeeder extends Seeder
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
        $admin = new DocCategory;
        $admin->name = 'kategori_1';
        $admin->title = 'Kategori 1';
        $admin->desc = 'Kategori 1';
        $admin->save();
        
        $admin = new DocCategory;
        $admin->name = 'kategori_2';
        $admin->title = 'Kategori 2';
        $admin->desc = 'Kategori 2';
        $admin->save();
        
        $admin = new DocCategory;
        $admin->name = 'kategori_3';
        $admin->title = 'Kategori 3';
        $admin->desc = 'Kategori 3';
        $admin->save();
    }
}
