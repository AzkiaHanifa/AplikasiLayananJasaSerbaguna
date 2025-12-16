<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke users (user_id) dengan Cascade Delete
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->string('title');
            $table->string('company');
            $table->string('job_image')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->default('Full Time');
            $table->string('location');
            $table->boolean('is_active')->default(true); // tinyint(1) di MySQL = boolean
            
            // Relasi ke categories (category_id) dengan Cascade Delete
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
