<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileApprovalPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_approval_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_approval_pengajuan')->references('id')->on('approval_pengajuan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('file_approval_pengajuan');
    }
}
