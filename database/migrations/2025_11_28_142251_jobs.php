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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            
            // --- Kolom yang dibutuhkan untuk Job ---
            $table->string('title');
            $table->string('company');
            $table->text('description')->nullable();
            $table->string('type')->default('Full Time');
            $table->string('location');
            $table->boolean('is_active')->default(true);
            
            // --- Foreign Key ke Categories ---
            // Karena tabel 'categories' dibuat di migrasi sebelumnya, 
            // kita bisa langsung menggunakan foreignId di sini.
            $table->foreignId('category_id') 
                  ->constrained('categories') // Menghubungkan ke tabel 'categories'
                  ->onDelete('cascade');     // Jika kategori dihapus, job juga ikut terhapus
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};