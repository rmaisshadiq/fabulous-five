<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusRoute;

class BusRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // ==========================================
            // KATEGORI: TRANSFER
            // ==========================================
            [
                'rute' => 'Transfer dari Pdg ke BIM',
                'kategori' => 'transfer',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 800000, 'medium' => 900000, 'of' => 1100000, 'oh' => 1800000]
            ],
            [
                'rute' => 'Pdg - Bungus - Pdg',
                'kategori' => 'transfer',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1100000, 'medium' => 1200000, 'of' => 1500000, 'oh' => 2300000]
            ],

            // ==========================================
            // KATEGORI: DALAM PROPINSI
            // ==========================================
            [
                'rute' => 'Paket Tour dalam Propinsi',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1300000, 'medium' => 1400000, 'of' => 1700000, 'oh' => 2200000]
            ],
            [
                'rute' => 'Pdg - Mifan - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1400000, 'medium' => 1700000, 'of' => 2000000, 'oh' => 3100000]
            ],
            [
                'rute' => 'Pdg - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1500000, 'medium' => 1800000, 'of' => 2300000, 'oh' => 3200000]
            ],
            [
                'rute' => 'Pdg - P.Lawang - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1600000, 'medium' => 2100000, 'of' => 2400000, 'oh' => 3300000]
            ],
            [
                'rute' => 'Pdg - Payakumbuh - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1800000, 'medium' => 2100000, 'of' => 2400000, 'oh' => 3500000]
            ],
            [
                'rute' => 'Pdg - Payakumbuh (Kelok 9) - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                // Hiace kosong di pamflet untuk rute ini, kita set null
                'prices' => ['hiace_elf' => null, 'medium' => 2300000, 'of' => 2600000, 'oh' => 3700000]
            ],
            [
                'rute' => 'Pdg - Btsk - Pyk - Bkt - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2300000, 'of' => 2700000, 'oh' => 3800000]
            ],
            [
                'rute' => 'Pdg - Alahan panjang - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1500000, 'medium' => 1900000, 'of' => 2100000, 'oh' => 3200000]
            ],
            [
                'rute' => 'Pdg - Alahan Panjang - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1800000, 'medium' => 2400000, 'of' => 2700000, 'oh' => 3700000]
            ],
            [
                'rute' => 'Pdg - Solok - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1500000, 'medium' => 1900000, 'of' => 2100000, 'oh' => 3200000]
            ],
            [
                'rute' => 'Pdg - Solok - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2300000, 'of' => 2500000, 'oh' => 3600000]
            ],
            [
                'rute' => 'Pdg - Batusangkar - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1600000, 'medium' => 1900000, 'of' => 2200000, 'oh' => 3200000]
            ],
            [
                'rute' => 'Pdg - Batusangkar - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1700000, 'medium' => 2200000, 'of' => 2500000, 'oh' => 3600000]
            ],
            [
                'rute' => 'Pdg - Solok - Batusangkar - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2500000, 'of' => 2800000, 'oh' => 3900000]
            ],
            [
                'rute' => 'Pdg - Painan - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1600000, 'medium' => 1900000, 'of' => 2100000, 'oh' => 3200000]
            ],
            [
                'rute' => 'Pdg - Pariaman - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1400000, 'medium' => 1800000, 'of' => 2100000, 'oh' => 3000000]
            ],
            [
                'rute' => 'Pdg - Pariaman - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1600000, 'medium' => 2000000, 'of' => 2300000, 'oh' => 3500000]
            ],
            [
                'rute' => 'Pdg - Sawahlunto - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1700000, 'medium' => 2000000, 'of' => 2200000, 'oh' => 3500000]
            ],
            [
                'rute' => 'Pdg - Sawahlunto - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 2400000, 'of' => 2700000, 'oh' => 4000000]
            ],
            [
                'rute' => 'Pdg - Lubuk Basung - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1600000, 'medium' => 2000000, 'of' => 2300000, 'oh' => 3800000]
            ],
            [
                'rute' => 'Pdg - Lubuk Basung - Bukittinggi - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2400000, 'of' => 2800000, 'oh' => 4100000]
            ],
            [
                'rute' => 'Pdg - Pasaman - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1900000, 'medium' => 2600000, 'of' => 2800000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Sijunjung - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 1800000, 'medium' => 2100000, 'of' => 2300000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Dharmasraya - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2600000, 'of' => 3000000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Muaro Labuh - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2800000, 'of' => 3200000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Sangir - Pdg',
                'kategori' => 'dalam_propinsi',
                'min_hari' => 1,
                'prices' => ['hiace_elf' => 2200000, 'medium' => 2900000, 'of' => 3200000, 'oh' => 4500000]
            ],

            // ==========================================
            // KATEGORI: OVERLAND (LUAR PROPINSI)
            // ==========================================
            [
                'rute' => 'Pdg - Siak - Pekanbaru',
                'kategori' => 'overland',
                'min_hari' => 3,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2700000, 'of' => 2950000, 'oh' => 3800000]
            ],
            [
                'rute' => 'Pdg - Jambi',
                'kategori' => 'overland',
                'min_hari' => 4,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2800000, 'of' => 3150000, 'oh' => 4200000]
            ],
            [
                'rute' => 'Pdg - Medan',
                'kategori' => 'overland',
                'min_hari' => 5,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2800000, 'of' => 3150000, 'oh' => 4200000]
            ],
            [
                'rute' => 'Pdg - Aceh',
                'kategori' => 'overland',
                'min_hari' => 7,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2800000, 'of' => 3150000, 'oh' => 4200000]
            ],
            [
                'rute' => 'Pdg - Palembang',
                'kategori' => 'overland',
                'min_hari' => 5,
                'prices' => ['hiace_elf' => 2000000, 'medium' => 2800000, 'of' => 3150000, 'oh' => 4200000]
            ],
            [
                'rute' => 'Pdg - Lampung',
                'kategori' => 'overland',
                'min_hari' => 7,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 3000000, 'of' => 3450000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Jakarta - Bandung',
                'kategori' => 'overland',
                'min_hari' => 10,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 3000000, 'of' => 3450000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Yogyakarta',
                'kategori' => 'overland',
                'min_hari' => 12,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 3000000, 'of' => 3450000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Surabaya',
                'kategori' => 'overland',
                'min_hari' => 13,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 3000000, 'of' => 3450000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Bali',
                'kategori' => 'overland',
                'min_hari' => 14,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 3000000, 'of' => 3450000, 'oh' => 4300000]
            ],
            [
                'rute' => 'Pdg - Lombok',
                'kategori' => 'overland',
                'min_hari' => 15,
                'prices' => ['hiace_elf' => 2100000, 'medium' => 3000000, 'of' => 3450000, 'oh' => 4300000]
            ],
        ];

        foreach ($routes as $data) {
            $route = BusRoute::create([
                'rute' => $data['rute'],
                'kategori' => $data['kategori'],
                'min_hari' => $data['min_hari'],
            ]);

            foreach ($data['prices'] as $tipe_bus => $harga) {
                // Hanya simpan ke database kalau harganya nggak kosong (null)
                if ($harga !== null) {
                    $route->prices()->create([
                        'tipe_bus' => $tipe_bus,
                        'harga' => $harga,
                    ]);
                }
            }
        }
    }
}
