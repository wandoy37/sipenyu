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
        Schema::create('kantors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('alamat');

            $table->unsignedBigInteger('kabkota_id');
            $table->unsignedBigInteger('kecamatan_id');

            $table->timestamps();

            $table->foreign('kabkota_id')->references('id')->on('kab_kotas')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kantors');
    }
};