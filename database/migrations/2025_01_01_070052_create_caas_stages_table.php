<!-- database/migrations/2025_01_01_070052_create_caas_stages_table.php -->

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
        Schema::create('caas_stages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status', 10)->default('GAGAL'); // Status ('LOLOS' or 'GAGAL')
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stage_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caas_stages');
    }
};
