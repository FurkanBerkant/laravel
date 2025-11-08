<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Tüm seeder'ları çalıştırır
     */
    public function run(): void
    {
        $this->command->info('🌱 Veritabanı dolduruluyor...');

        // Sırayla çalıştır (önemli: önce kategoriler, sonra ürünler)
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        $this->command->info('✅ Veritabanı başarıyla dolduruldu!');
        $this->command->info('');
        $this->command->info('📊 Test verileri:');
        $this->command->info('   - Kategoriler: ' . \App\Models\Category::count());
        $this->command->info('   - Ürünler: ' . \App\Models\Product::count());
        $this->command->info('');
        $this->command->info('🚀 Şimdi tarayıcıda test edebilirsiniz:');
        $this->command->info('   http://localhost/categories');
        $this->command->info('   http://localhost/products');
    }
}
