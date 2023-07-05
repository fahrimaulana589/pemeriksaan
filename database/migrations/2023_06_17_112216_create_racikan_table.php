<?php

use App\Models\Obat;
use App\Models\Pemeriksaan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('racikan', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Obat::class)->references('id')->on('obats')->restrictOnDelete();
            $table->foreignIdFor(Pemeriksaan::class)->references('id')->on('pemeriksaan')->restrictOnDelete();

            $table->integer('jumlah');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('racikan');
    }
};
