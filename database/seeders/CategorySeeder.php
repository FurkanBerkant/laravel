<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Test için kategoriler oluşturur
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Telefon, bilgisayar, tablet ve diğer elektronik cihazlar',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Giyim',
                'description' => 'Erkek, kadın ve çocuk giyim ürünleri',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Ev & Yaşam',
                'description' => 'Ev dekorasyonu, mobilya ve yaşam ürünleri',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Spor & Outdoor',
                'description' => 'Spor ekipmanları, kamp ve outdoor ürünleri',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Kitap & Hobi',
                'description' => 'Kitaplar, müzik aletleri ve hobi ürünleri',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Kozmetik & Kişisel Bakım',
                'description' => 'Makyaj, cilt bakımı ve kişisel bakım ürünleri',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Oyuncak & Bebek',
                'description' => 'Çocuk oyuncakları ve bebek ürünleri',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Otomotiv',
                'description' => 'Araç yedek parça ve aksesuarları',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'name' => 'Süpermarket',
                'description' => 'Gıda, içecek ve temel ihtiyaç ürünleri',
                'is_active' => true,
                'order' => 9,
            ],
            [
                'name' => 'Eski Kategori',
                'description' => 'Artık kullanılmayan test kategorisi',
                'is_active' => false,
                'order' => 99,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✓ ' . count($categories) . ' kategori oluşturuldu!');
    }
}
