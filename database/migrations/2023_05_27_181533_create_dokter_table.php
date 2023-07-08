<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchid\Platform\Models\User;

return new class extends Migration {
    public function up()
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->unique();

            $table->string("nama",50);
            $table->string("icon",255)->unique();
            $table->enum("gender",["pria","wanita"]);
            $table->date("harlah");
            $table->string("pendidikan",50);
            $table->string("keahlian",50);
            $table->string("desa",50);
            $table->string("kecamatan",50);
            $table->string("kabupaten_kota",50);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokter');
    }
};
