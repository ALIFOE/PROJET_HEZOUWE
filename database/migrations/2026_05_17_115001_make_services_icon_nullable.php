<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Compatible MySQL et PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE services ALTER COLUMN icon DROP NOT NULL');
            DB::statement('ALTER TABLE services ALTER COLUMN icon SET DEFAULT NULL');
        } else {
            DB::statement('ALTER TABLE services MODIFY COLUMN icon VARCHAR(100) NULL DEFAULT NULL');
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE services ALTER COLUMN icon SET NOT NULL");
            DB::statement("ALTER TABLE services ALTER COLUMN icon SET DEFAULT ''");
        } else {
            DB::statement("ALTER TABLE services MODIFY COLUMN icon VARCHAR(100) NOT NULL DEFAULT ''");
        }
    }
};
