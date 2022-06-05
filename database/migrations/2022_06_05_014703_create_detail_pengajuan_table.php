<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_detail_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan')->references('id')->on('pengajuan')->onUpdate('casacde')->onDelete('cascade');
            $table->string('jenis_file');
            $table->string('name');
            $table->string('type');
            $table->string('size');
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
        Schema::dropIfExists('detail_pengajuan');
    }
}
