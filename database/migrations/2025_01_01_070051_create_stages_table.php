<!-- database/migrations/2025_01_01_070051_create_stages_table.php -->

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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 100); // isinya sih 'Administrasi', 'Tes Tulis dan koding', 'Wawancara', 'tucil'. 'teaching' 'levelling'.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
