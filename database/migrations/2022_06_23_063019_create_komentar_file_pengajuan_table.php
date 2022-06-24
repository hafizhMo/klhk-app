<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarFilePengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar_file_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_file_pengajuan')->references('id')->on('file_detail_pengajuan')->onUpdate('no action')->onDelete('no action');
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');
            $table->string('komentar');
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
        Schema::dropIfExists('komentar_file_pengajuan');
    }
}
