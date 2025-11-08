@php use App\Models\Product; @endphp
@extends('layouts.app')

@section('title', 'Ürünler')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Ürünler</h1>

        <a href="{{ route('products.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            + Yeni Ürün Ekle
        </a>
    </div>

    <!-- Filtreleme ve Arama -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Arama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ara</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Ürün adı, SKU..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <!-- Kategori Filtresi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Tüm Kategoriler</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Durum Filtresi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Tümü</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pasif</option>
                </select>
            </div>

            <!-- Stok Durumu -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <select name="stock_status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Tümü</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                        Stokta
                    </option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                        Tükendi
                    </option>
                    <option value="on_backorder" {{ request('stock_status') == 'on_backorder' ? 'selected' : '' }}>
                        Ön Sipariş
                    </option>
                </select>
            </div>

            <!-- Butonlar -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    🔍 Filtrele
                </button>
                <a href="{{ route('products.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    ↺ Temizle
                </a>
            </div>
        </form>
    </div>

    <!-- Ürünler Grid View -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition">
                <!-- Ürün Resmi -->
                <div class="relative">
                    <img src="{{ $product->main_image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-48 object-cover">

                    <!-- Badge'ler -->
                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                        @if($product->is_featured)
                            <span class="bg-yellow-400 text-yellow-900 text-xs px-2 py-1 rounded font-semibold">
                            ⭐ Öne Çıkan
                        </span>
                        @endif

                        @if($product->discount_percentage > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded font-semibold">
                            %{{ number_format($product->discount_percentage, 0) }} İndirim
                        </span>
                        @endif
                    </div>

                    <!-- Stok Durumu -->
                    <div class="absolute top-2 right-2">
                        @if($product->stock_status == 'in_stock')
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">
                            Stokta
                        </span>
                        @elseif($product->stock_status == 'out_of_stock')
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                            Tükendi
                        </span>
                        @else
                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">
                            Ön Sipariş
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Ürün Bilgileri -->
                <div class="p-4">
                    <!-- Kategori -->
                    <p class="text-xs text-gray-500 mb-1">
                        {{ $product->category->name }}
                    </p>

                    <!-- Ürün Adı -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                        {{ $product->name }}
                    </h3>

                    <!-- SKU -->
                    <p class="text-xs text-gray-400 mb-2">
                        SKU: {{ $product->sku }}
                    </p>

                    <!-- Fiyat -->
                    <div class="mb-3">
                        @if($product->discount_percentage > 0)
                            <div class="flex items-center gap-2">
                            <span class="text-xl font-bold text-red-600">
                                {{ number_format($product->final_price, 2) }} ₺
                            </span>
                                <span class="text-sm text-gray-400 line-through">
                                {{ number_format($product->price, 2) }} ₺
                            </span>
                            </div>
                        @else
                            <span class="text-xl font-bold text-gray-800">
                            {{ number_format($product->price, 2) }} ₺
                        </span>
                        @endif
                    </div>

                    <!-- Stok Miktarı -->
                    <div class="mb-3 text-sm">
                        <span class="text-gray-600">Stok:</span>
                        <span class="font-semibold {{ $product->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                        {{ $product->stock }} adet
                        @if($product->isLowStock())
                                ⚠️
                            @endif
                    </span>
                    </div>

                    <!-- Durum -->
                    <div class="mb-3">
                        @if($product->is_active)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ● Aktif
                        </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            ● Pasif
                        </span>
                        @endif
                    </div>

                    <!-- Butonlar -->
                    <div class="flex gap-2">
                        <a href="{{ route('products.show', $product) }}"
                           class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 rounded text-sm">
                            👁️ Görüntüle
                        </a>
                        <a href="{{ route('products.edit', $product) }}"
                           class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 rounded text-sm">
                            ✏️ Düzenle
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-4 text-center py-12">
                <p class="text-gray-500 text-lg mb-4">Henüz ürün eklenmemiş.</p>
                <a href="{{ route('products.create') }}"
                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded">
                    İlk Ürünü Ekle
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>

    <!-- İstatistikler -->
    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Hızlı İstatistikler</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $products->total() }}</div>
                <div class="text-sm text-gray-500">Toplam Ürün</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">
                    {{ Product::inStock()->count() }}
                </div>
                <div class="text-sm text-gray-500">Stokta</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">
                    {{ Product::active()->count() }}
                </div>
                <div class="text-sm text-gray-500">Aktif</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">
                    {{ Product::featured()->count() }}
                </div>
                <div class="text-sm text-gray-500">Öne Çıkan</div>
            </div>
        </div>
    </div>
@endsection
