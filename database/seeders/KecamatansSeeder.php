<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kecamatan::insert([
            [
                
                "name" => "BATU SOPANG",
                "code" => "6401010",
                "kabkota_id" => 1,
            ],
            [ "name" => "MUARA SAMU", "code" => "6401011", "kabkota_id" => 1],
            [ "name" => "BATU ENGAU", "code" => "6401021", "kabkota_id" => 1],
            [
                
                "name" => "TANJUNG HARAPAN",
                "code" => "6401022",
                "kabkota_id" => 1,
            ],
            [
                
                "name" => "PASIR BELENGKONG",
                "code" => "6401030",
                "kabkota_id" => 1,
            ],
            [
                
                "name" => "TANAH GROGOT",
                "code" => "6401040",
                "kabkota_id" => 1,
            ],
            [ "name" => "KUARO", "code" => "6401050", "kabkota_id" => 1],
            [ "name" => "LONG IKIS", "code" => "6401060", "kabkota_id" => 1],
            [
                
                "name" => "MUARA KOMAM",
                "code" => "6401070",
                "kabkota_id" => 1,
            ],
            [ "name" => "LONG KALI", "code" => "6401080", "kabkota_id" => 1],
            [ "name" => "BONGAN", "code" => "6402010", "kabkota_id" => 2],
            [ "name" => "JEMPANG", "code" => "6402020", "kabkota_id" => 2],
            [
                
                "name" => "PENYINGGAHAN",
                "code" => "6402030",
                "kabkota_id" => 2,
            ],
            [ "name" => "MUARA PAHU", "code" => "6402040", "kabkota_id" => 2],
            [
                
                "name" => "SILUQ NGURAI",
                "code" => "6402041",
                "kabkota_id" => 2,
            ],
            [ "name" => "MUARA LAWA", "code" => "6402050", "kabkota_id" => 2],
            [
                
                "name" => "BENTIAN BESAR",
                "code" => "6402051",
                "kabkota_id" => 2,
            ],
            [ "name" => "DAMAI", "code" => "6402060", "kabkota_id" => 2],
            [ "name" => "NYUATAN", "code" => "6402061", "kabkota_id" => 2],
            [
                
                "name" => "BARONG TONGKOK",
                "code" => "6402070",
                "kabkota_id" => 2,
            ],
            [
                
                "name" => "LINGGANG BIGUNG",
                "code" => "6402071",
                "kabkota_id" => 2,
            ],
            [ "name" => "MELAK", "code" => "6402080", "kabkota_id" => 2],
            [
                
                "name" => "SEKOLAQ DARAT",
                "code" => "6402081",
                "kabkota_id" => 2,
            ],
            [
                
                "name" => "MANOR BULATN",
                "code" => "6402082",
                "kabkota_id" => 2,
            ],
            [ "name" => "LONG IRAM", "code" => "6402090", "kabkota_id" => 2],
            [ "name" => "TERING", "code" => "6402091", "kabkota_id" => 2],
            [ "name" => "SEMBOJA", "code" => "6403010", "kabkota_id" => 3],
            [ "name" => "MUARA JAWA", "code" => "6403020", "kabkota_id" => 3],
            [
                
                "name" => "SANGA-SANGA",
                "code" => "6403030",
                "kabkota_id" => 3,
            ],
            [ "name" => "LOA JANAN", "code" => "6403040", "kabkota_id" => 3],
            [ "name" => "LOA KULU", "code" => "6403050", "kabkota_id" => 3],
            [
                
                "name" => "MUARA MUNTAI",
                "code" => "6403060",
                "kabkota_id" => 3,
            ],
            [ "name" => "MUARA WIS", "code" => "6403070", "kabkota_id" => 3],
            [ "name" => "KOTABANGUN", "code" => "6403080", "kabkota_id" => 3],
            [ "name" => "TENGGARONG", "code" => "6403090", "kabkota_id" => 3],
            [ "name" => "SEBULU", "code" => "6403100", "kabkota_id" => 3],
            [
                
                "name" => "TENGGARONG SEBERANG",
                "code" => "6403110",
                "kabkota_id" => 3,
            ],
            [ "name" => "ANGGANA", "code" => "6403120", "kabkota_id" => 3],
            [
                
                "name" => "MUARA BADAK",
                "code" => "6403130",
                "kabkota_id" => 3,
            ],
            [
                
                "name" => "MARANG KAYU",
                "code" => "6403140",
                "kabkota_id" => 3,
            ],
            [
                
                "name" => "MUARA KAMAN",
                "code" => "6403150",
                "kabkota_id" => 3,
            ],
            [ "name" => "KENOHAN", "code" => "6403160", "kabkota_id" => 3],
            [
                
                "name" => "KEMBANG JANGGUT",
                "code" => "6403170",
                "kabkota_id" => 3,
            ],
            [ "name" => "TABANG", "code" => "6403180", "kabkota_id" => 3],
            [
                
                "name" => "MUARA ANCALONG",
                "code" => "6404010",
                "kabkota_id" => 4,
            ],
            [ "name" => "BUSANG", "code" => "6404011", "kabkota_id" => 4],
            [
                
                "name" => "LONG MESANGAT",
                "code" => "6404012",
                "kabkota_id" => 4,
            ],
            [
                
                "name" => "MUARA WAHAU",
                "code" => "6404020",
                "kabkota_id" => 4,
            ],
            [ "name" => "TELEN", "code" => "6404021", "kabkota_id" => 4],
            [ "name" => "KONGBENG", "code" => "6404022", "kabkota_id" => 4],
            [
                
                "name" => "MUARA BENGKAL",
                "code" => "6404030",
                "kabkota_id" => 4,
            ],
            [ "name" => "BATU AMPAR", "code" => "6404031", "kabkota_id" => 4],
            [
                
                "name" => "SANGATTA UTARA",
                "code" => "6404040",
                "kabkota_id" => 4,
            ],
            [ "name" => "BENGALON", "code" => "6404041", "kabkota_id" => 4],
            [
                
                "name" => "TELUK PANDAN",
                "code" => "6404042",
                "kabkota_id" => 4,
            ],
            [
                
                "name" => "SANGATTA SELATAN",
                "code" => "6404043",
                "kabkota_id" => 4,
            ],
            [
                
                "name" => "RANTAU PULUNG",
                "code" => "6404044",
                "kabkota_id" => 4,
            ],
            [
                
                "name" => "SANGKULIRANG",
                "code" => "6404050",
                "kabkota_id" => 4,
            ],
            [ "name" => "KALIORANG", "code" => "6404051", "kabkota_id" => 4],
            [ "name" => "SANDARAN", "code" => "6404052", "kabkota_id" => 4],
            [ "name" => "KAUBUN", "code" => "6404053", "kabkota_id" => 4],
            [ "name" => "KARANGAN", "code" => "6404054", "kabkota_id" => 4],
            [ "name" => "KELAY", "code" => "6405010", "kabkota_id" => 5],
            [ "name" => "TALISAYAN", "code" => "6405020", "kabkota_id" => 5],
            [ "name" => "TABALAR", "code" => "6405021", "kabkota_id" => 5],
            [
                
                "name" => "BIDUK BIDUK",
                "code" => "6405030",
                "kabkota_id" => 5,
            ],
            [
                
                "name" => "PULAU DERAWAN",
                "code" => "6405040",
                "kabkota_id" => 5,
            ],
            [ "name" => "MARATUA", "code" => "6405041", "kabkota_id" => 5],
            [ "name" => "SAMBALIUNG", "code" => "6405050", "kabkota_id" => 5],
            [
                
                "name" => "TANJUNG REDEB",
                "code" => "6405060",
                "kabkota_id" => 5,
            ],
            [
                
                "name" => "GUNUNG TABUR",
                "code" => "6405070",
                "kabkota_id" => 5,
            ],
            [ "name" => "SEGAH", "code" => "6405080", "kabkota_id" => 5],
            [
                
                "name" => "TELUK BAYUR",
                "code" => "6405090",
                "kabkota_id" => 5,
            ],
            [ "name" => "BATU PUTIH", "code" => "6405100", "kabkota_id" => 5],
            [ "name" => "BIATAN", "code" => "6405110", "kabkota_id" => 5],
            [ "name" => "BABULU", "code" => "6409010", "kabkota_id" => 6],
            [ "name" => "WARU", "code" => "6409020", "kabkota_id" => 6],
            [ "name" => "PENAJAM", "code" => "6409030", "kabkota_id" => 6],
            [ "name" => "SEPAKU", "code" => "6409040", "kabkota_id" => 6],
            [ "name" => "LAHAM", "code" => "6411010", "kabkota_id" => 7],
            [
                
                "name" => "LONG HUBUNG",
                "code" => "6411020",
                "kabkota_id" => 7,
            ],
            [ "name" => "LONG BAGUN", "code" => "6411030", "kabkota_id" => 7],
            [
                
                "name" => "LONG PAHANGAI",
                "code" => "6411040",
                "kabkota_id" => 7,
            ],
            [ "name" => "LONG APARI", "code" => "6411050", "kabkota_id" => 7],
            [
                
                "name" => "BALIKPAPAN SELATAN",
                "code" => "6471010",
                "kabkota_id" => 8,
            ],
            [
                
                "name" => "BALIKPAPAN KOTA",
                "code" => "6471011",
                "kabkota_id" => 8,
            ],
            [
                
                "name" => "BALIKPAPAN TIMUR",
                "code" => "6471020",
                "kabkota_id" => 8,
            ],
            [
                
                "name" => "BALIKPAPAN UTARA",
                "code" => "6471030",
                "kabkota_id" => 8,
            ],
            [
                
                "name" => "BALIKPAPAN TENGAH",
                "code" => "6471040",
                "kabkota_id" => 8,
            ],
            [
                
                "name" => "BALIKPAPAN BARAT",
                "code" => "6471050",
                "kabkota_id" => 8,
            ],
            [ "name" => "PALARAN", "code" => "6472010", "kabkota_id" => 9],
            [
                
                "name" => "SAMARINDA ILIR",
                "code" => "6472020",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "SAMARINDA KOTA",
                "code" => "6472021",
                "kabkota_id" => 9,
            ],
            [ "name" => "SAMBUTAN", "code" => "6472022", "kabkota_id" => 9],
            [
                
                "name" => "SAMARINDA SEBERANG",
                "code" => "6472030",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "LOA JANAN ILIR",
                "code" => "6472031",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "SUNGAI KUNJANG",
                "code" => "6472040",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "SAMARINDA ULU",
                "code" => "6472050",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "SAMARINDA UTARA",
                "code" => "6472060",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "SUNGAI PINANG",
                "code" => "6472061",
                "kabkota_id" => 9,
            ],
            [
                
                "name" => "BONTANG SELATAN",
                "code" => "6474010",
                "kabkota_id" => 10,
            ],
            [
                
                "name" => "BONTANG UTARA",
                "code" => "6474020",
                "kabkota_id" => 10,
            ],
            [
                
                "name" => "BONTANG BARAT",
                "code" => "6474030",
                "kabkota_id" => 10,
            ],
        ]);
    }
}