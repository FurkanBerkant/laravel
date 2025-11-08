<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'description' => 'Yüksek teknolojili elektronik markası', 'is_active' => true],
            ['name' => 'Samsung', 'description' => 'Küresel elektronik devi', 'is_active' => true],
            ['name' => 'Xiaomi (Mi)', 'description' => 'Fiyat/Performans odaklı teknoloji', 'is_active' => true],
            ['name' => 'Nike', 'description' => 'Spor giyim ve ayakkabı markası', 'is_active' => true],
            ['name' => 'Adidas', 'description' => 'Performans ve moda giyim', 'is_active' => true],
            ['name' => 'Dyson', 'description' => 'Yenilikçi ev aletleri', 'is_active' => true],
            ['name' => 'Logitech', 'description' => 'Bilgisayar çevre birimleri', 'is_active' => false], // Pasif örnek
        ];

        foreach ($brands as $brandName) {
            Brand::create($brandName);
        }
        $this->command->info('✓ ' . count($brands) . ' markalar oluşturuldu!');

    }
}
