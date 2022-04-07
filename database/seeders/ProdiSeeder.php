<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'D3 Keperawatan',
            'D3 Kebidanan',
            'D3 Akupunktur',
            'D3 Farmasi',
            'D3 RMIK',
            'Sarjana Terapana Kebidanan',
            'Profesi Bidan',
            'S1 Farmasi Klinis',
            'S1 Fisioterapi',
            'S1 Informatika',
            'S1 Ilmu Keperawatan',
            'Profesi Ners',
            'Sarjana Terapan Anestesiologi'
        ];

        for ($i=0; $i < count($data); $i++) {
            Prodi::create([
                "name" => $data[$i]
            ]);
        }
    }
}
