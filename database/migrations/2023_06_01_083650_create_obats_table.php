<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();

            $table->string('nama',50);
            $table->string('images',255)->unique();
            $table->text('deskripsi');
            $table->integer('stok');
            $table->integer('harga');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obats');
    }
};
