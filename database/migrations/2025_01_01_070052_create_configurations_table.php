<!-- database/migrations/2025_01_01_070052_create_configurations_table.php -->

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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('pengumuman_on')->default(false);
            $table->boolean('isi_jadwal_on')->default(false);
            $table->boolean('role_on')->default(false);
            $table->unsignedBigInteger('current_stage_id')->nullable();
            $table->foreign('current_stage_id')->references('id')->on('stages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
