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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('role', ['penyuluh pns', 'thl-tbpp pppk','thl-tbpp apbn', 'penyuluh swadaya', 'penyuluh swasta','petugas popt','petugas pbt']);
            $table->unsignedBigInteger('kantor_id')->index();
            $table->timestamps();

            $table->foreign('kantor_id')->references('id')->on('kantors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
