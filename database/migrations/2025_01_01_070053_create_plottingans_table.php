<!-- database/migrations/2025_01_01_070053_create_plottingans_table.php -->

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
        Schema::create('plottingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caas_id')->constrained('caas')->onDelete('cascade');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');

            // Misal kita tambahkan kolom 'stage_id' kalau mau menandakan plottingan ini
            // untuk stage interview/test dsb.
            // $table->foreignId('stage_id')->nullable()->constrained()->onDelete('cascade');

            // Info tambahan lain kalau perlu
            // $table->timestamp('picked_at')->nullable();

            $table->timestamps();

            // Kalau mau mencegah duplikat data user & shift (1 user tak boleh 2x daftar shift sama)
            $table->unique(['caas_id', 'shift_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plottingans');
    }
};
