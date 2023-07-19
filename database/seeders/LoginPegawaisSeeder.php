<?php

namespace Database\Seeders;

use App\Models\LoginPegawai;
use App\Models\Pegawai;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoginPegawaisSeeder extends Seeder
{   
    function unique_multidim_array($array, $key) {

        $temp_array = array();
    
        $i = 0;
    
        $key_array = array();
    
        
    
        foreach($array as $val) {
    
            if (!in_array($val[$key], $key_array)) {
    
                $key_array[$i] = $val[$key];
    
                $temp_array[$i] = $val;
    
            }
    
            $i++;
    
        }
    
        return $temp_array;
    
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawais = Pegawai::where('nik','!=',null)->orWhere('nik','!=',null)->get();
        $insertData = [];
        foreach ($pegawais as $pegawai) {
            if($pegawai->nip != "" || $pegawai->nik != ""){
                $_data = $pegawai->nip ?? $pegawai->nik;
                //check _data is exist in $insertData['usename']
                if(array_search($_data, array_column($insertData, 'username')) !== TRUE){
                    $insertData[] = [
                        'pegawai_id' => $pegawai->id,
                        'username' => $_data,
                        'password' => bcrypt($_data)
                    ];
                }

                
            }
        }
        $insertQuery = $this->unique_multidim_array($insertData,'username');
        LoginPegawai::insert($insertQuery);
    }
}
