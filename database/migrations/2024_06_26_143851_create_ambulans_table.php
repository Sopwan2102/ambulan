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
        Schema::create('ambulan', function (Blueprint $table) {
            $table->Increments('ambulan_id');
            $table->string('no_plat');
            $table->integer('biaya');
            $table->string('lokasi');
            $table->string('milik');
            $table->text('fasilitas');
            $table->string('surat_izin');
            $table->string('gambar');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ambulan');
    }
};
