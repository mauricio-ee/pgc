<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        DB::statement('ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(50)');
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'customer'");
    }

    public function down(): void
    {
        // Role values added by the application must remain valid after rollback.
    }
};
