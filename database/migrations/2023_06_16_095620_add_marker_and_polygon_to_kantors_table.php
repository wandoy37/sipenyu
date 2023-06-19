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
        Schema::table('kantors', function (Blueprint $table) {
            $table->text('marker')->after('kecamatan_id')->nullable();
            $table->text('polygon')->after('marker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kantors', function (Blueprint $table) {
            $table->dropColumn('marker');
            $table->dropColumn('polygon');
        });
    }
};
