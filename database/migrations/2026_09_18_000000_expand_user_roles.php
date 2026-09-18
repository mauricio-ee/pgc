<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');
        Schema::create('users_new', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('customer');
            $table->rememberToken();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone', 20)->nullable();
            $table->timestamps();
        });

        DB::statement('INSERT INTO users_new (id, name, email, email_verified_at, password, role, remember_token, avatar, bio, phone, created_at, updated_at) SELECT id, name, email, email_verified_at, password, role, remember_token, avatar, bio, phone, created_at, updated_at FROM users');
        Schema::drop('users');
        Schema::rename('users_new', 'users');
        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        // Los roles adicionales no se eliminan para evitar pérdida de cuentas.
    }
};
