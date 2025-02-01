<!-- database/migrations/2025_01_01_070052_create_shifts_table.php -->

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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // Jika perlu mengindikasikan shift ini untuk "Interview" atau "Test" dsb.
            // $table->foreignId('stage_id')->nullable()->constrained()->onDelete('cascade');
            // Tambahan
            $table->string('shift_no');    // Nomor shift (misal: 1,2,3,...)
            $table->date('date');       // Tanggal shift
            $table->time('time_start');    // Jam mulai
            $table->time('time_end');      // Jam selesai
            $table->integer('kuota');      // Kuota pendaftar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
