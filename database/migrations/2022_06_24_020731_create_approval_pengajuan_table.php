<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan')->references('id')->on('pengajuan')->onUpdate('no action')->onDelete('no action');
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');
            $table->char('status')->nullable();
            $table->string('komentar')->nullable();
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
        Schema::dropIfExists('approval_pengajuan');
    }
}
