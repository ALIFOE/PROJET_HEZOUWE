<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE services MODIFY COLUMN icon VARCHAR(100) NULL DEFAULT NULL');
    }

    public function down()
    {
        DB::statement("UPDATE services SET icon = '' WHERE icon IS NULL");
        DB::statement("ALTER TABLE services MODIFY COLUMN icon VARCHAR(100) NOT NULL DEFAULT ''");
    }
};
