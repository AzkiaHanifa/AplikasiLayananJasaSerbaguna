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
    Schema::table('jobs', function (Blueprint $table) {
        // Menambahkan kolom user_id setelah id
        $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('jobs', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
