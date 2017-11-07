<?php

namespace Modules\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\DocCategory;
use Modules\Documents\Entities\DocTemplate;
use DB;

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
        // $dty = DocType::truncate();
        // $dc = DocCategory::truncate();
        // $dt = DocTemplate::truncate();
        DB::table('doc_type')->delete();
        DB::table('doc_category')->delete();
        DB::table('doc_template')->delete();
        
        // $this->call("OthersTableSeeder");
        $admin = new DocType;
        $admin->name = 'khs';
        $admin->title = 'KHS';
        $admin->desc = 'Kontrak KHS';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'turnkey';
        $admin->title = 'Turnkey';
        $admin->desc = 'Kontrak Turnkey (Onetime)';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'sp';
        $admin->title = 'SP';
        $admin->desc = 'Kontrak SP';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'surat_pengikatan';
        $admin->title = 'Surat Pengikatan';
        $admin->desc = 'Surat Pengikatan';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'amandemen_sp';
        $admin->title = 'Amandemen SP';
        $admin->desc = 'Amandemen SP';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'amandemen_kontrak';
        $admin->title = 'Amandemen Kontrak';
        $admin->desc = 'Amandemen Kontrak';
        $admin->save();
              
        $admin = new DocType;
        $admin->name = 'adendum';
        $admin->title = 'Adendum Kontrak';
        $admin->desc = 'Adendum Kontrak';
        $admin->save();
        
        $admin = new DocType;
        $admin->name = 'side_letter';
        $admin->title = 'Side Letter';
        $admin->desc = 'Side Letter';
        $admin->save();
              
              
        $new = new DocCategory;
        $new->title = 'Pengadaan Barang dan Jasa';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Jasa Konsultasi';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Jasa Konsultasi (Billingual)';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Sewa';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Barang Murni';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Barang Murni Sederhana';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Konstruksi SKKL';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Perangkat (Billingual)';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Aplikasi (Billingual)';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Aplikasi dan Lisensi';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Sitac CME';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Jasa Non Konsultasi';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Pengadaan Jasa Outsourcing';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Surat Pesanan';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Surat Pengikatan';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Amandemen SP';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Amandemen Kontrak';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save(); 
        
        $new = new DocCategory;
        $new->title = 'Adendum Kontrak';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
        
        $new = new DocCategory;
        $new->title = 'Side Letter';
        $new->name = str_slug($new->title);
        $new->desc = $new->title;
        $new->save();
    }
}
