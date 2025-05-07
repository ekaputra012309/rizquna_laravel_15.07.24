<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJamaahPaketIdForeignKey extends Migration
{
    public function up()
    {
        Schema::table('jamaah', function (Blueprint $table) {
            // Drop the old foreign key constraint
            $table->dropForeign(['paket_id']);

            // Re-add with ON DELETE SET NULL
            $table->foreign('paket_id')
                  ->references('id')
                  ->on('paket')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('jamaah', function (Blueprint $table) {
            $table->dropForeign(['paket_id']);
            $table->foreign('paket_id')->references('id')->on('paket');
        });
    }
}
