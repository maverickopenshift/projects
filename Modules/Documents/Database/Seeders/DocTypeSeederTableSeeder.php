<?php

namespace Modules\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Documents\Entities\DocType;

class DocTypeSeederTableSeeder extends Seeder
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
        $admin = new DocType;
        $admin->name = 'kontrak';
        $admin->title = 'Kontrak';
        $admin->desc = 'Dokumen Kontrak';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'mou';
        $admin->title = 'MoU';
        $admin->desc = 'Dokumen MoU';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'nda';
        $admin->title = 'NDA';
        $admin->desc = 'Dokumen NDA';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'nota_kesepakatan';
        $admin->title = 'Nota Kesepakatan';
        $admin->desc = 'Dokumen Nota Kesepakatan';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'berita_acara';
        $admin->title = 'Berita Acara';
        $admin->desc = 'Dokumen Berita Acara';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'settlemet_agreement';
        $admin->title = 'Settlemet Agreement';
        $admin->desc = 'Dokumen Settlemet Agreement';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'engagement_letter';
        $admin->title = 'Engagement Letter';
        $admin->desc = 'Dokumen Engagement Letter';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'perijinan';
        $admin->title = 'Perijinan';
        $admin->desc = 'Dokumen Perijinan';
        $admin->save();
    }
}
