<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $stringVillage = "49027";
        // $charVillage = str_pad($stringVillage, 10, " ", STR_PAD_RIGHT);
        for($i = 1; $i <=11; $i++){
            $data[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49027',
                'alamat' => "Jl. Jend. Sudirman No. 1",
            ];
        }

        for ($i = 1; $i <= 27; $i++) {
            $data2[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49028',
                'alamat' => "Jl. Jend. Sudirman No. 2",
            ];
        }

        for($i = 1; $i <= 23; $i++) {
            $data3[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49029',
                'alamat' => "Jl. Jend. Sudirman No. 3",
            ];
        }

        for ($i = 1; $i <= 5; $i++) {
            $data4[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49030',
                'alamat' => "Jl. Jend. Sudirman No. 4",
            ];
        }

        for ($i = 1; $i <= 25; $i++) {
            $data5[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49031',
                'alamat' => "Jl. Jend. Sudirman No. 5",
            ];
        }

        for($i = 1; $i <= 7; $i++) {
            $data6[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49032',
                'alamat' => "Jl. Jend. Sudirman No. 6",
            ];
        }

        for($i = 1; $i <= 22; $i++) {
            $data7[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49033',
                'alamat' => "Jl. Jend. Sudirman No. 7",
            ];
        }

        for($i = 1; $i <= 10; $i++) {
            $data8[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49034',
                'alamat' => "Jl. Jend. Sudirman No. 8",
            ];
        }

        for($i = 1; $i <= 7; $i++) {
            $data9[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49035',
                'alamat' => "Jl. Jend. Sudirman No. 9",
            ];
        }

        for($i = 1; $i <= 23; $i++) {
            $data10[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49036',
                'alamat' => "Jl. Jend. Sudirman No. 10",
            ];
        }

        for($i = 1; $i <= 5; $i++) {
            $data11[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49037',
                'alamat' => "Jl. Jend. Sudirman No. 11",
            ];
        }

        for($i = 1; $i <= 9; $i++) {
            $data12[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49038',
                'alamat' => "Jl. Jend. Sudirman No. 12",
            ];
        }

        for($i = 1; $i <= 14; $i++) {
            $data13[] = [
                'name' => 'TPS_'.$i,
                'village_id' => '49039',
                'alamat' => "Jl. Jend. Sudirman No. 13",
            ];
        }

        \App\Models\TPS::insert($data);
        \App\Models\TPS::insert($data2);
        \App\Models\TPS::insert($data3);
        \App\Models\TPS::insert($data4);
        \App\Models\TPS::insert($data5);
        \App\Models\TPS::insert($data6);
        \App\Models\TPS::insert($data7);
        \App\Models\TPS::insert($data8);
        \App\Models\TPS::insert($data9);
        \App\Models\TPS::insert($data10);
        \App\Models\TPS::insert($data11);
        \App\Models\TPS::insert($data12);
        \App\Models\TPS::insert($data13);


    }
}
