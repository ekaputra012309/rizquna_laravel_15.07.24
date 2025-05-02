<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamaahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jamaah', function (Blueprint $table) {
            $table->id();
            $table->integer('nik');
            $table->string('nama');
            $table->string('alamat');
            $table->text('phone');
            $table->integer('passpor');
            $table->integer('dp')->nullable();
            $table->date('tgl_berangkat');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('paket_id')->nullable();
            $table->integer('updateby')->nullable();
            $table->dateTime('updatetime')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cabang_id')->references('id')->on('cabang');
            // $table->foreign('agent_id')->references('id_agent')->on('agents');
            $table->foreign('paket_id')->references('id')->on('paket');
        });

        Schema::create('cicilan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_jamaah');
            $table->dateTime('tgl_cicil');
            $table->decimal('deposit', 15, 2);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jamaah');
        Schema::dropIfExists('cicilan');
    }
}
