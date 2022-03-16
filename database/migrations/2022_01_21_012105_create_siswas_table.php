<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiswasTable extends Migration
{
  
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('nisn');
            $table->integer('nis');
            $table->string('nama');
            $table->unsignedBigInteger('id_kelas');
            $table->text('alamat');
            $table->integer('no_telp');
            $table->string('email')->unique();
            $table->string('password');
 
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });

    }

  
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
