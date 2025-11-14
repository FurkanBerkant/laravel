@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Kategorilere Dön
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Sağ Kolon - Kategori Bilgileri -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Kategori Kartı -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <!-- Kategori Resmi -->
                <div class="relative">
                    <img src="{{ $category->image_url }}"
                         alt="{{ $category->name }}"
                         class="w-full h-48 object-cover">

                    <!-- Durum Badge -->
                    <div class="absolute top-4 right-4">
                        @if($category->is_active)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            ✓ Aktif
                        </span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            ✗ Pasif
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Kategori Bilgileri -->
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $category->name }}</h1>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-sm text-gray-600">
                            <span class="font-semibold mr-2">Slug:</span>
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $category->slug }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <span class="font-semibold mr-2">Sıralama:</span>
                            <span>{{ $category->order }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600">
                            <span class="font-semibold mr-2">Ürün Sayısı:</span>
                            <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded font-semibold">
                            {{ $category->products_count }} adet
                        </span>
                        </div>
                    </div>

                    @if($category->description)
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Açıklama</h3>
                            <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                        </div>
                    @endif

                    <!-- İşlem Butonları -->
                    @role('admin')
                        <div class="flex gap-3">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 rounded font-semibold">
                                ✏️ Düzenle
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Bu kategoriyi ve içindeki {{ $category->products_count }} ürünü silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold">
                                    🗑️ Sil
                                </button>
                            </form>
                        </div>
                    @endrole
                </div>
            </div>

            <!-- İstatistikler -->
            @role('admin')
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">İstatistikler</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Toplam Ürün:</span>
                            <span class="text-2xl font-bold text-indigo-600">
                            {{ $category->products()->count() }}
                        </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Aktif Ürünler:</span>
                            <span class="text-2xl font-bold text-green-600">
                            {{ $category->activeProducts()->count() }}
                        </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Stokta Ürünler:</span>
                            <span class="text-2xl font-bold text-blue-600">
                            {{ $category->products()->inStock()->count() }}
                        </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Öne Çıkan:</span>
                            <span class="text-2xl font-bold text-yellow-600">
                            {{ $category->products()->featured()->count() }}
                        </span>
                        </div>
                    </div>
                </div>

                <!-- Tarih Bilgileri -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Tarih Bilgileri</h3>

                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-600 text-sm">Oluşturulma:</span>
                            <p class="font-semibold">{{ $category->created_at->format('d.m.Y H:i') }}</p>
                            <p class="text-xs text-gray-500">{{ $category->created_at->diffForHumans() }}</p>
                        </div>

                        <div>
                            <span class="text-gray-600 text-sm">Son Güncelleme:</span>
                            <p class="font-semibold">{{ $category->updated_at->format('d.m.Y H:i') }}</p>
                            <p class="text-xs text-gray-500">{{ $category->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @else
                {{-- Sadece yetkisiz kullanıcılar için mesaj --}}
                <div class="py-20 text-center">
                    <h2 class="text-4xl font-extrabold text-red-600 mb-4">Erişim Engellendi</h2>
                    <p class="text-lg text-gray-700">Bu yönetim sayfasını görüntüleme yetkiniz bulunmamaktadır.</p>
                </div>
            @endrole
        </div>

        <!-- Sol Kolon - Kategorideki Ürünler -->
        <div class="lg:col-span-2">

            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Başlık ve Filtreler -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Bu Kategorideki Ürünler
                        <span class="text-lg text-gray-500">({{ $category->products_count }})</span>
                    </h2>

                    @role('admin')
                        <a href="{{ route('products.create') }}?category_id={{ $category->id }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                            + Ürün Ekle
                        </a>
                    @endrole
                </div>

                <!-- Ürün Listesi -->
                @if($category->products->count() > 0)
                    <div class="space-y-4">
                        @foreach($category->products as $product)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex gap-4">

                                    <!-- Ürün Resmi -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $product->main_image_url }}"
                                             alt="{{ $product->name }}"
                                             class="w-24 h-24 object-cover rounded-md">
                                    </div>

                                    <!-- Ürün Bilgileri -->
                                    <div class="flex-1 min-w-0">

                                        <!-- Başlık ve Badge'ler -->
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1 pr-4">
                                                <h3 class="text-lg font-semibold text-gray-900 truncate">
                                                    {{ $product->name }}
                                                </h3>
                                                <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                                            </div>

                                            <!-- Durum Badge'leri -->
                                            <div class="flex flex-col gap-1 items-end">
                                                @if($product->is_featured)
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                                                    ⭐ Öne Çıkan
                                                </span>
                                                @endif

                                                @if($product->is_active)
                                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                                    ● Aktif
                                                </span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                                                    ● Pasif
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Açıklama -->
                                        @if($product->description)
                                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                {{ $product->description }}
                                            </p>
                                        @endif

                                        <!-- Fiyat, Stok ve Butonlar -->
                                        <div class="flex items-center justify-between">

                                            <!-- Fiyat -->
                                            <div>
                                                @if($product->discount_percentage > 0)
                                                    <div class="flex items-center gap-2">
                                                    <span class="text-xl font-bold text-red-600">
                                                        {{ number_format($product->final_price, 2) }} ₺
                                                    </span>
                                                        <span class="text-sm text-gray-400 line-through">
                                                        {{ number_format($product->price, 2) }} ₺
                                                    </span>
                                                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">
                                                        -%{{ number_format($product->discount_percentage, 0) }}
                                                    </span>
                                                    </div>
                                                @else
                                                    <span class="text-xl font-bold text-gray-900">
                                                    {{ number_format($product->price, 2) }} ₺
                                                </span>
                                                @endif
                                            </div>

                                            <!-- Stok -->
                                            <div class="text-sm">
                                                <span class="text-gray-600">Stok:</span>
                                                <span class="font-semibold {{ $product->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $product->stock }} adet
                                                @if($product->isLowStock())
                                                        ⚠️
                                                    @endif
                                            </span>
                                            </div>

                                            <!-- Butonlar -->
                                            <div class="flex gap-2">
                                                <a href="{{ route('products.show', $product) }}"
                                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm">
                                                    👁️ Görüntüle
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    ✏️ Düzenle
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Stok Uyarısı -->
                                        @if($product->isLowStock())
                                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded">
                                                <p class="text-xs text-red-700">
                                                    ⚠️ Düşük stok uyarısı! Minimum: {{ $product->min_stock }} adet
                                                </p>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Sayfalama (eğer çok ürün varsa) -->
                    @if($category->products()->count() > 10)
                        <div class="mt-6">
                            <p class="text-center text-sm text-gray-600">
                                Toplam {{ $category->products_count }} ürün gösteriliyor
                            </p>
                        </div>
                    @endif

                @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📦</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                Bu kategoride henüz ürün yok
                            </h3>
                            @role('admin')
                                <p class="text-gray-600 mb-6">
                                    İlk ürünü ekleyerek başlayın!
                                </p>
                                <a href="{{ route('products.create') }}?category_id={{ $category->id }}"
                                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-semibold">
                                    + İlk Ürünü Ekle
                                </a>
                            @endrole
                        </div>
                @endif

            </div>

            <!-- Hızlı Aksiyonlar -->
            @if($category->products->count() > 0)
                <div class="mt-6 bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Hızlı Aksiyonlar</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('products.index', ['category_id' => $category->id, 'stock_status' => 'out_of_stock']) }}"
                           class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                            <div class="text-2xl mb-2">🚫</div>
                            <div class="text-sm font-semibold text-gray-700">Tükenen Ürünler</div>
                            <div class="text-xs text-gray-500">
                                {{ $category->products()->where('stock_status', 'out_of_stock')->count() }} ürün
                            </div>
                        </a>

                        <a href="{{ route('products.index', ['category_id' => $category->id, 'status' => '0']) }}"
                           class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                            <div class="text-2xl mb-2">⏸️</div>
                            <div class="text-sm font-semibold text-gray-700">Pasif Ürünler</div>
                            <div class="text-xs text-gray-500">
                                {{ $category->products()->where('is_active', false)->count() }} ürün
                            </div>
                        </a>

                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}"
                           class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
                            <div class="text-2xl mb-2">📊</div>
                            <div class="text-sm font-semibold text-gray-700">Tüm Ürünler</div>
                            <div class="text-xs text-gray-500">Listede görüntüle</div>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
