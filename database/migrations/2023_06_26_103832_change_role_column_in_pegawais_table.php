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
        Schema::table('pegawais', function (Blueprint $table) {
            //change enum role to enum type
            $table->dropColumn('role');
            $table->enum('type', ['penyuluh pns', 'penyuluh pppk','thl-tbpp apbn','thl-tbpp apbd', 'penyuluh swadaya', 'penyuluh swasta', 'petugas popt', 'petugas pbt'])->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pegawais', function (Blueprint $table) {
            //
        });
    }
};