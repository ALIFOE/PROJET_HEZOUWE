<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user' AFTER email");
        DB::statement("UPDATE users SET role = 'admin' WHERE email = 'admin@hezouwe.com'");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE users DROP COLUMN role');
    }
};
