<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('mitra', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users (kunci asing)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('nik')->unique();
        $table->text('alamat');
        $table->string('foto_ktp'); // Menyimpan path gambar
        
        // Status pendaftaran (opsional tapi penting)
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        
        $table->timestamps();
    });
}
};
