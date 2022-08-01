<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengunjungs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengunjung');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->string('no_telp');
            $table->string('no_ktp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengunjungs');
    }
};
