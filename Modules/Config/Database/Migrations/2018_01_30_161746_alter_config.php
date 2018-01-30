<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('config', function (Blueprint $table) {
        $table->string('object_text')->nullable()->after('id');
        $table->text('object_desc')->nullable()->after('object_value');
        $table->string('object_type')->nullable()->after('object_status');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
