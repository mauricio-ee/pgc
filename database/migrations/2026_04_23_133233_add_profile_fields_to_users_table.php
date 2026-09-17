<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone', 20)->nullable();
        });
        
        // Convertir el ENUM a STRING para poder admitir 'certifier' 
        // Verificamos si estamos usando SQLite o MySQL antes de mandar la instruccion raw
        if (config('database.default') !== 'sqlite' && config('database.default') !== 'testing') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'customer'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'bio', 'phone']);
        });
    }
};
