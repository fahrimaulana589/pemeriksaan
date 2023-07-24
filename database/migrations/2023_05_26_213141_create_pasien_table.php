<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->unique();

            $table->string("nama",50);
            $table->string("icon",255)->unique();
            $table->enum("gender",["pria","wanita"]);
            $table->date("harlah");
            $table->string("desa",50);
            $table->string("kecamatan",50);
            $table->string("kabupaten_kota",50);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasien');
    }
};
