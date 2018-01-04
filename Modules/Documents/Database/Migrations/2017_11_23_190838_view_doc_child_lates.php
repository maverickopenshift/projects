<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewDocChildLates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
          "CREATE VIEW doc_child_latest_1 AS 
              SELECT doc_parent_id, MAX(created_at) as created_at 
            FROM documents 
            GROUP BY doc_parent_id"
        );

        DB::statement(
          "CREATE VIEW doc_child_latest AS 
          SELECT * FROM doc_child_latest_1 AS x 
          JOIN documents USING (doc_parent_id, created_at)"
        );
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
