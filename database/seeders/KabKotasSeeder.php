<?php

namespace Database\Seeders;

use App\Models\KabKota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KabKotasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KabKota::insert([
            [
                'id'=>1,
                'name'=>'PASER',
                'code'=>'6401',
            ],[
                'id'=>2,
                'name'=>'KUTAI BARAT',
                'code'=>'6402',
            ],[
                'id'=>3,
                'name'=>'KUTAI KARTANEGARA',
                'code'=>'6403',
            ],[
                'id'=>4,
                'name'=>'KUTAI TIMUR',
                'code'=>'6404',
            ],[
                'id'=>5,
                'name'=>'BERAU',
                'code'=>'6405',
            ],[
                'id'=>6,
                'name'=>'PENAJAM PASER UTARA',
                'code'=>'6409',
            ],[
                'id'=>7,
                'name'=>'MAHAKAM HULU',
                'code'=>'6411',
            ],[
                'id'=>8,
                'name'=>'BALIKPAPAN',
                'code'=>'6471',
            ],[
                'id'=>9,
                'name'=>'SAMARINDA',
                'code'=>'6472',
            ],[
                'id'=>10,
                'name'=>'BONTANG',
                'code'=>'6474',
            ]
        ]);
    }
}
