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
        Schema::create('login_pegawai_api_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('login_pegawai_id')->index();
            $table->string('api_token',80)->unique()->nullable()->default(null);
            $table->string('client_name')->nullable()->default(null);
            $table->string('ip_address',45)->nullable()->default(null);
            $table->timestamps();

            $table->foreign('login_pegawai_id')->references('id')->on('login_pegawais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_pegawai_api_tokens');
    }
};
