<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama kalau ada
        DB::table('vehicles')->truncate();

        $vehicles = [
            // ==========================================
            // 1. BUS PARIWISATA (Dari PDF + Best Deal)
            // ==========================================
            [
                'car_type' => 'oh', 'brand' => 'Mercedes-Benz', 'model' => 'Big Bus 45 Seat', 
                'license_plate' => 'BG 7001 UL', 'price_per_day' => 3000000, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 1800000, 'harga_city_tour' => 2500000, 'harga_full_day' => 2750000, 'harga_luar_kota' => 3200000
            ],
            [
                'car_type' => 'medium', 'brand' => 'Hino', 'model' => 'Medium Bus 29 Seat', 
                'license_plate' => 'BA 7034 RM', 'price_per_day' => 2000000, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 1100000, 'harga_city_tour' => 1600000, 'harga_full_day' => 1700000, 'harga_luar_kota' => 2300000
            ],
            [
                'car_type' => 'medium', 'brand' => 'Hino', 'model' => 'Medium Bus 29 Seat', 
                'license_plate' => 'D 7743 AI', 'price_per_day' => 2000000, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 1100000, 'harga_city_tour' => 1600000, 'harga_full_day' => 1700000, 'harga_luar_kota' => 2300000
            ],
            [
                'car_type' => 'of', 'brand' => 'Mitsubishi', 'model' => 'Canter Bus 31 Seat', 
                'license_plate' => 'H 7141 OB', 'price_per_day' => 2500000, 'status' => 'active',
                'is_best_deal' => false, 'harga_drop_bandara' => null, 'harga_city_tour' => null, 'harga_full_day' => null, 'harga_luar_kota' => null
            ],

            // ==========================================
            // 2. INNOVA REBORN (PDF + Best Deal)
            // ==========================================
            ...$this->generateInnovaReborn(),

            // ==========================================
            // 3. AVANZA (PDF + Best Deal)
            // ==========================================
            ...$this->generateAvanza(),

            // ==========================================
            // 4. MOBIL REGULER LAINNYA (Hanya di PDF)
            // ==========================================
            ['car_type' => 'reguler', 'brand' => 'Daihatsu', 'model' => 'Terios', 'license_plate' => 'BA 1109 AAI', 'price_per_day' => 400000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Mitsubishi', 'model' => 'Xpander', 'license_plate' => 'BA 1343 DQ', 'price_per_day' => 400000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Mitsubishi', 'model' => 'Xpander', 'license_plate' => 'BA 1579 TAA', 'price_per_day' => 400000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Daihatsu', 'model' => 'Xenia', 'license_plate' => 'BA 1260 MB', 'price_per_day' => 275000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Daihatsu', 'model' => 'Xenia', 'license_plate' => 'BA 1632 FQ', 'price_per_day' => 275000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Daihatsu', 'model' => 'Xenia', 'license_plate' => 'BA 1720 AAF', 'price_per_day' => 375000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Daihatsu', 'model' => 'Xenia', 'license_plate' => 'BM 1507 RQ', 'price_per_day' => 250000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Honda', 'model' => 'New Brio', 'license_plate' => 'BA 1573 AAA', 'price_per_day' => 275000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Honda', 'model' => 'New Brio', 'license_plate' => 'BA 1386 AAF', 'price_per_day' => 300000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Honda', 'model' => 'New Brio', 'license_plate' => 'BB 1384 EI', 'price_per_day' => 275000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Toyota', 'model' => 'Raize', 'license_plate' => 'BA 1157 DM', 'price_per_day' => 275000, 'status' => 'active', 'is_best_deal' => false],
            ['car_type' => 'reguler', 'brand' => 'Mitsubishi', 'model' => 'Triton', 'license_plate' => '8087 TAAA', 'price_per_day' => 650000, 'status' => 'active', 'is_best_deal' => false],

            // ==========================================
            // 5. KENDARAAN KHUSUS BEST DEAL (Tidak ada di PDF)
            // ==========================================
            [
                'car_type' => 'reguler', 'brand' => 'Toyota', 'model' => 'Innova Zenix', 
                'license_plate' => null, 'price_per_day' => 0, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 700000, 'harga_city_tour' => 1000000, 'harga_full_day' => 1100000, 'harga_luar_kota' => 1200000
            ],
            [
                'car_type' => 'hiace_elf', 'brand' => 'Isuzu', 'model' => 'Elf', 
                'license_plate' => null, 'price_per_day' => 0, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 1000000, 'harga_city_tour' => 1400000, 'harga_full_day' => 1500000, 'harga_luar_kota' => 1850000
            ],
            [
                'car_type' => 'hiace_elf', 'brand' => 'Toyota', 'model' => 'Hiace Commuter', 
                'license_plate' => null, 'price_per_day' => 0, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 950000, 'harga_city_tour' => 1500000, 'harga_full_day' => 1600000, 'harga_luar_kota' => 1800000
            ],
            [
                'car_type' => 'hiace_elf', 'brand' => 'Toyota', 'model' => 'Hiace Premio', 
                'license_plate' => null, 'price_per_day' => 0, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 1200000, 'harga_city_tour' => 1700000, 'harga_full_day' => 1800000, 'harga_luar_kota' => 2000000
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }

    // --- Helper Functions buat men-generate data massal ---

    private function generateInnovaReborn(): array
    {
        // Semua Innova Reborn di PDF dapet status Best Deal
        $plates = [
            'B 1296 HOC', 'BA 1342 TB', 'BA 1421 IN', 'BA 1833 SY', 
            'BM 1905 TT', 'BP 1689 IJ', 'D 1788 SAG', 'BA 1380 TAA'
        ]; // Data plat dari PDF

        $data = [];
        foreach ($plates as $plate) {
            $data[] = [
                'car_type' => 'reguler', 'brand' => 'Toyota', 'model' => 'Innova Reborn', 
                'license_plate' => $plate, 'price_per_day' => 550000, 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 600000, 'harga_city_tour' => 800000, 'harga_full_day' => 950000, 'harga_luar_kota' => 1100000
            ];
        }
        return $data;
    }

    private function generateAvanza(): array
    {
        // Semua Avanza di PDF dapet status Best Deal (All New Avanza)
        $avanzas = [
            ['plate' => 'BA 1127 IE', 'price' => 275000],
            ['plate' => 'BA 1521 OS', 'price' => 350000],
            ['plate' => 'BA 1531 HF', 'price' => 350000],
            ['plate' => 'BA 1536 GAA', 'price' => 375000],
            ['plate' => 'BA 1907 IC', 'price' => 275000],
        ]; // Data plat & harga harian reguler berbeda-beda dari PDF

        $data = [];
        foreach ($avanzas as $avz) {
            $data[] = [
                'car_type' => 'reguler', 'brand' => 'Toyota', 'model' => 'All New Avanza', 
                'license_plate' => $avz['plate'], 'price_per_day' => $avz['price'], 'status' => 'active',
                'is_best_deal' => true, 'harga_drop_bandara' => 350000, 'harga_city_tour' => 650000, 'harga_full_day' => 700000, 'harga_luar_kota' => 800000
            ];
        }
        return $data;
    }
}
