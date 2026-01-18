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
       Schema::table('categories', function (Blueprint $table) {
        // Menambahkan kolom icon setelah kolom slug
        $table->string('icon')->nullable()->after('slug');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('categories', function (Blueprint $table) {
        // Menghapus kolom jika di-rollback
        $table->dropColumn('icon');
    });
    }
};
