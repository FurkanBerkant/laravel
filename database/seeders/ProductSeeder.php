<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Test için ürünler oluşturur
     */
    public function run(): void
    {
        // Kategorileri al
        $elektronik = Category::where('name', 'Elektronik')->first();
        $giyim = Category::where('name', 'Giyim')->first();
        $evYasam = Category::where('name', 'Ev & Yaşam')->first();
        $spor = Category::where('name', 'Spor & Outdoor')->first();
        $brandIds = Brand::pluck('id')->toArray();
        if (empty($brandIds)) {
            $this->command->error("HATA: Hiç marka (Brand) bulunamadı. Lütfen önce BrandSeeder'ı çalıştırın!");
            return;
        }
        $products = [
            // Elektronik Ürünleri
            [
                'category_id' => $elektronik->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Apple iPhone 15 Pro Max 256GB - Titanyum Mavi',
                'long_description' => 'Yeni iPhone 15 Pro Max ile gücün ve zarafetin mükemmel birleşimini deneyimleyin. A17 Pro çip, ProMotion ekran ve gelişmiş kamera sistemi.',
                'price' => 65999.00,
                'cost_price' => 52000.00,
                'compare_price' => 69999.00,
                'discount_percentage' => 5.71,
                'stock' => 15,
                'min_stock' => 5,
                'stock_status' => 'in_stock',
                'weight' => 0.221,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Samsung Galaxy S24 Ultra 512GB - Titanyum Gri',
                'long_description' => 'Galaxy AI ile tanışın. S24 Ultra, yapay zeka destekli özellikler ve güçlü performansıyla mobil deneyimi yeniden tanımlıyor.',
                'price' => 59999.00,
                'cost_price' => 48000.00,
                'stock' => 12,
                'min_stock' => 5,
                'stock_status' => 'in_stock',
                'weight' => 0.232,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'MacBook Air M3',
                'description' => 'Apple MacBook Air 13" M3 Çip 8GB 256GB SSD',
                'long_description' => 'Efsanevi MacBook Air, M3 çip ile daha güçlü. İnanılmaz performans, tüm gün pil ömrü ve şık tasarım.',
                'price' => 47999.00,
                'cost_price' => 38000.00,
                'compare_price' => 51999.00,
                'discount_percentage' => 7.69,
                'stock' => 8,
                'min_stock' => 3,
                'stock_status' => 'in_stock',
                'weight' => 1.24,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Sony WH-1000XM5 Kulaklık',
                'description' => 'Sony WH-1000XM5 Kablosuz Gürültü Önleyici Kulaklık',
                'long_description' => 'Endüstrinin en iyi gürültü engelleme teknolojisi. 30 saat pil ömrü, premium ses kalitesi.',
                'price' => 12999.00,
                'cost_price' => 9500.00,
                'stock' => 25,
                'min_stock' => 10,
                'stock_status' => 'in_stock',
                'weight' => 0.25,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $elektronik->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'iPad Pro 11"',
                'description' => 'Apple iPad Pro 11" M2 Çip 128GB Wi-Fi',
                'long_description' => 'iPad Pro, M2 çip ile masaüstü sınıfı performans sunuyor. Liquid Retina ekran ve Apple Pencil desteği.',
                'price' => 34999.00,
                'cost_price' => 28000.00,
                'stock' => 0,
                'min_stock' => 5,
                'stock_status' => 'out_of_stock',
                'weight' => 0.466,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $elektronik->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Samsung 65" QLED TV',
                'description' => 'Samsung 65" 4K QLED Smart TV',
                'long_description' => 'Quantum Dot teknolojisi ile canlı renkler. 4K çözünürlük, HDR10+ desteği ve akıllı TV özellikleri.',
                'price' => 32999.00,
                'cost_price' => 25000.00,
                'compare_price' => 36999.00,
                'discount_percentage' => 10.81,
                'stock' => 6,
                'min_stock' => 3,
                'stock_status' => 'in_stock',
                'weight' => 21.5,
                'length' => 145.3,
                'width' => 83.1,
                'height' => 5.9,
                'is_active' => true,
                'is_featured' => true,
            ],

            // Giyim Ürünleri
            [
                'category_id' => $giyim->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Nike Air Max 270',
                'description' => 'Nike Air Max 270 Erkek Spor Ayakkabı - Siyah',
                'long_description' => 'Efsanevi Air yastıklama ve modern tasarım. Tüm gün konfor ve stil.',
                'price' => 4499.00,
                'cost_price' => 3200.00,
                'compare_price' => 5499.00,
                'discount_percentage' => 18.18,
                'stock' => 45,
                'min_stock' => 20,
                'stock_status' => 'in_stock',
                'weight' => 0.65,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $giyim->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Levi\'s 501 Original Jean',
                'description' => 'Levi\'s 501 Original Fit Erkek Jean - Koyu Mavi',
                'long_description' => 'İkonik 501 jean, zamansız tasarımı ve dayanıklı yapısıyla stil sahibi erkeklerin tercihi.',
                'price' => 2799.00,
                'cost_price' => 1900.00,
                'stock' => 60,
                'min_stock' => 30,
                'stock_status' => 'in_stock',
                'weight' => 0.55,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $giyim->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Adidas Originals Hoodie',
                'description' => 'Adidas Originals Trefoil Erkek Kapüşonlu Sweatshirt',
                'long_description' => 'Klasik Trefoil logosu ile ikonik sweatshirt. %100 pamuk, yumuşak ve rahat.',
                'price' => 1899.00,
                'cost_price' => 1300.00,
                'stock' => 35,
                'min_stock' => 15,
                'stock_status' => 'in_stock',
                'weight' => 0.45,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $giyim->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'The North Face Mont',
                'description' => 'The North Face Nuptse 1996 Erkek Mont - Siyah',
                'long_description' => 'İkonik Nuptse mont, 700 fill down izolasuyon ile soğuk havalarda maksimum sıcaklık.',
                'price' => 8999.00,
                'cost_price' => 6500.00,
                'stock' => 18,
                'min_stock' => 10,
                'stock_status' => 'in_stock',
                'weight' => 0.85,
                'is_active' => true,
                'is_featured' => true,
            ],

            // Ev & Yaşam Ürünleri
            [
                'category_id' => $evYasam->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Dyson V15 Detect Süpürge',
                'description' => 'Dyson V15 Detect Kablosuz Dikey Süpürge',
                'long_description' => 'Lazer teknolojisi ile görünmez tozları bile algılar. Güçlü emiş, 60 dakika çalışma süresi.',
                'price' => 24999.00,
                'cost_price' => 19000.00,
                'compare_price' => 27999.00,
                'discount_percentage' => 10.71,
                'stock' => 7,
                'min_stock' => 5,
                'stock_status' => 'in_stock',
                'weight' => 3.1,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $evYasam->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Nespresso Kahve Makinesi',
                'description' => 'Nespresso Essenza Mini Kapsüllü Kahve Makinesi',
                'long_description' => 'Kompakt tasarım, mükemmel espresso. 19 bar basınç ile profesyonel kahve deneyimi.',
                'price' => 3299.00,
                'cost_price' => 2400.00,
                'stock' => 18,
                'min_stock' => 10,
                'stock_status' => 'in_stock',
                'weight' => 2.3,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $evYasam->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Philips Hava Fritözü',
                'description' => 'Philips Airfryer XXL Dijital Hava Fritözü - 7.3L',
                'long_description' => 'Yağsız pişirme teknolojisi ile sağlıklı yemekler. Geniş kapasite, kolay temizlik.',
                'price' => 6499.00,
                'cost_price' => 4800.00,
                'stock' => 14,
                'min_stock' => 8,
                'stock_status' => 'in_stock',
                'weight' => 5.6,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $evYasam->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'iRobot Roomba Robot Süpürge',
                'description' => 'iRobot Roomba j7+ Robot Süpürge - Otomatik Boşaltma',
                'long_description' => 'Yapay zeka destekli navigasyon, engel tanıma ve otomatik boşaltma istasyonu.',
                'price' => 18999.00,
                'cost_price' => 14000.00,
                'stock' => 5,
                'min_stock' => 5,
                'stock_status' => 'in_stock',
                'weight' => 3.4,
                'is_active' => true,
                'is_featured' => true,
            ],

            // Spor & Outdoor
            [
                'category_id' => $spor->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Decathlon Kamp Çadırı',
                'description' => 'Quechua 2 Seconds Easy Kamp Çadırı - 2 Kişilik',
                'long_description' => '2 saniyede kurulum! Su geçirmez, UV koruma, pratik taşıma çantası. Yazlık kamp için ideal.',
                'price' => 1799.00,
                'cost_price' => 1200.00,
                'stock' => 22,
                'min_stock' => 10,
                'stock_status' => 'in_stock',
                'weight' => 3.4,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $spor->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Yoga Mat Premium',
                'description' => 'TPE Yoga Matı - 6mm Kalınlık - Çift Taraflı',
                'long_description' => 'Kaymaz yüzey, çevre dostu malzeme. Yoga, pilates ve fitness için mükemmel.',
                'price' => 399.00,
                'cost_price' => 250.00,
                'stock' => 3,
                'min_stock' => 20,
                'stock_status' => 'in_stock',
                'weight' => 1.1,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $spor->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Kettlebell Set',
                'description' => 'Döküm Kettlebell Set - 8kg, 12kg, 16kg',
                'long_description' => 'Profesyonel döküm kettlebell seti. Kaymaz tutamak, dayanıklı kaplama.',
                'price' => 2499.00,
                'cost_price' => 1700.00,
                'stock' => 12,
                'min_stock' => 6,
                'stock_status' => 'in_stock',
                'weight' => 36.0,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $spor->id,
                'brand_id' => $brandIds[array_rand($brandIds)], // <-- MARKA ID'si EKLENDİ
                'name' => 'Bisiklet - Mountain Bike',
                'description' => 'Bianchi Duel 29" 21 Vites Dağ Bisikleti',
                'long_description' => 'Profesyonel dağ bisikleti. Alüminyum şase, hidrolik disk fren, Shimano vites.',
                'price' => 12999.00,
                'cost_price' => 9500.00,
                'compare_price' => 14999.00,
                'discount_percentage' => 13.34,
                'stock' => 8,
                'min_stock' => 5,
                'stock_status' => 'in_stock',
                'weight' => 13.5,
                'length' => 180,
                'width' => 65,
                'height' => 110,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✓ ' . count($products) . ' ürün oluşturuldu!');
    }
}
