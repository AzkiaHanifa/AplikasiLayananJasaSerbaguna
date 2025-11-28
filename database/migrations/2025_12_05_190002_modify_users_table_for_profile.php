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
        // Ubah 'name' jadi nullable karena saat daftar belum diisi
        $table->string('nama')->nullable()->change(); 
        
        // Tambahkan kolom baru
        $table->string('no_hp', 20)->nullable()->after('email');
        $table->text('alamat')->nullable()->after('no_hp');
        $table->string('foto_profil')->nullable()->after('alamat');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Kembalikan ke settingan awal (opsional)
        $table->string('name')->nullable(false)->change();
        $table->dropColumn(['no_hp', 'alamat', 'foto_profil']);
    });
}
};
