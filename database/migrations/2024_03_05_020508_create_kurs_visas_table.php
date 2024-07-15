<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKursVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kurs_visas', function (Blueprint $table) {
            $table->id('id_kurs');
            $table->integer('id_visa');
            $table->decimal('kurs_bsi', 10, 2);
            $table->decimal('kurs_riyal', 10, 2);
            $table->string('pilih_konversi');
            $table->decimal('hasil_konversi', 15, 2);
            $table->enum('status', ['0', '1'])->default('0');
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
        Schema::dropIfExists('kurs_visas');
    }
}
