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
            $table->unsignedBigInteger('kantor_id')->nullable()->change();
            $table->enum('jenis_kelamin',['Laki-Laki','Perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('no_telp',15)->nullable();
            $table->string('no_wa',15)->nullable();
            $table->string('email',100)->nullable();
            $table->enum('agama',['Islam','Kristen','Katolik','Hindu','Budha','Konghucu','Lainnya'])->nullable();
            $table->enum('status_perkawinan',['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'])->nullable();
            
            //pekerjaan
            $table->string('nip_nik',30)->nullable();
            $table->string('nama_jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->enum('unit_eselon',['I','II','III','IV','V'])->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->text('alamat_unit_kerja')->nullable();
            $table->unsignedBigInteger('kab_kota_id')->index();
            $table->string('foto_profil')->nullable();
            $table->string('foto_stp')->nullable();

            //login
            $table->string('username')->unique();
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
