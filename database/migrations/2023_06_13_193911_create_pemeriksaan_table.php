<?php

use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Dokter::class)->references('id')->on('dokter')->restrictOnDelete();
            $table->foreignIdFor(Pasien::class)->references('id')->on('pasien')->restrictOnDelete();

            $table->text('keluhan');
            $table->date('hari');
            $table->enum('status',['antrian','proses','selesai','batal']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
