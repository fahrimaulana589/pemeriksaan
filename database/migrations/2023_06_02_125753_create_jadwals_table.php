<?php

use App\Models\Dokter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Dokter::class)->references('id')->on('dokter')->restrictOnDelete();

            $table->enum('senin',['off','on']);
            $table->time("start_senin")->nullable();
            $table->time("end_senin")->nullable();

            $table->enum('selasa',['off','on']);
            $table->time("start_selasa")->nullable();
            $table->time("end_selasa")->nullable();

            $table->enum('rabu',['off','on']);
            $table->time("start_rabu")->nullable();
            $table->time("end_rabu")->nullable();

            $table->enum('kamis',['off','on']);
            $table->time("start_kamis")->nullable();
            $table->time("end_kamis")->nullable();

            $table->enum('jumat',['off','on']);
            $table->time("start_jumat")->nullable();
            $table->time("end_jumat")->nullable();

            $table->enum('sabtu',['off','on']);
            $table->time("start_sabtu")->nullable();
            $table->time("end_sabtu")->nullable();

            $table->enum('minggu',['off','on']);
            $table->time("start_minggu")->nullable();
            $table->time("end_minggu")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
};
