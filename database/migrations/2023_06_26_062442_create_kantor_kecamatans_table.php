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
        Schema::create('kantor_kecamatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kantor_id')->index();
            $table->unsignedBigInteger('kecamatan_id')->index();
            $table->foreign('kantor_id')->references('id')->on('kantors')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade');
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
        Schema::dropIfExists('kantor_kecamatans');
    }
};
