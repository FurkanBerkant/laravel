@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Ürünlere Dön
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Sol - Görseller -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Ana Resim -->
                <div class="mb-4">
                    <img src="{{ $product->main_image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-96 object-contain rounded-lg">
                </div>

                <!-- Galeri -->
                @if($product->images && count($product->images) > 0)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-24 object-cover rounded-md cursor-pointer hover:opacity-75"
                                 onclick="document.querySelector('.lg\\:col-span-2 img').src = this.src">
                        @endforeach
                    </div>
                @endif

                <!-- Detaylı Açıklama -->
                <div class="mt-6">
                    <h2 class="text-2xl font-bold mb-4">Ürün Detayları</h2>
                    <div class="prose max-w-none">
                        {!! nl2br(e($product->long_description ?? $product->description)) !!}
                    </div>
                </div>

                <!-- Teknik Özellikler -->
                @if($product->weight || $product->length || $product->width || $product->height)
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-3">Teknik Özellikler</h3>
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-md">
                            @if($product->weight)
                                <div>
                                    <span class="text-gray-600">Ağırlık:</span>
                                    <span class="font-semibold">{{ $product->weight }} kg</span>
                                </div>
                            @endif
                            @if($product->length)
                                <div>
                                    <span class="text-gray-600">Uzunluk:</span>
                                    <span class="font-semibold">{{ $product->length }} cm</span>
                                </div>
                            @endif
                            @if($product->width)
                                <div>
                                    <span class="text-gray-600">Genişlik:</span>
                                    <span class="font-semibold">{{ $product->width }} cm</span>
                                </div>
                            @endif
                            @if($product->height)
                                <div>
                                    <span class="text-gray-600">Yükseklik:</span>
                                    <span class="font-semibold">{{ $product->height }} cm</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sağ - Ürün Bilgileri ve İşlemler -->
        <div class="space-y-6">

            <!-- Temel Bilgiler -->
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Badge'ler -->
                <div class="flex gap-2 mb-4">
                    @if($product->is_featured)
                        <span class="bg-yellow-400 text-yellow-900 text-xs px-2 py-1 rounded font-semibold">
                        ⭐ Öne Çıkan
                    </span>
                    @endif

                    @if($product->stock_status == 'in_stock')
                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">
                        ✓ Stokta
                    </span>
                    @elseif($product->stock_status == 'out_of_stock')
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                        ✗ Tükendi
                    </span>
                    @else
                        <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">
                        ⏱ Ön Sipariş
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

                <!-- Başlık -->
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                <!-- Kategori -->
                <p class="text-gray-600 mb-4">
                    <a href="{{ route('products.index', ['category_id' => $product->category_id]) }}"
                       class="text-indigo-600 hover:underline">
                        {{ $product->category->name }}
                    </a>
                </p>

                <!-- SKU -->
                <p class="text-sm text-gray-500 mb-4">
                    SKU: <span class="font-mono">{{ $product->sku }}</span>
                </p>

                <!-- Fiyat -->
                <div class="mb-6">
                    @if($product->discount_percentage > 0)
                        <div class="flex items-center gap-3 mb-2">
                        <span class="text-4xl font-bold text-red-600">
                            {{ number_format($product->final_price, 2) }} ₺
                        </span>
                            <span class="text-xl text-gray-400 line-through">
                            {{ number_format($product->price, 2) }} ₺
                        </span>
                        </div>
                        <p class="text-green-600 font-semibold">
                            %{{ number_format($product->discount_percentage, 0) }} İndirim
                        </p>
                    @else
                        <span class="text-4xl font-bold text-gray-900">
                        {{ number_format($product->price, 2) }} ₺
                    </span>
                    @endif
                </div>

                <!-- Kısa Açıklama -->
                @if($product->description)
                    <p class="text-gray-700 mb-6">
                        {{ $product->description }}
                    </p>
                @endif

                <!-- İşlem Butonları -->
                <div class="flex gap-3 mb-4">
                    <a href="{{ route('products.edit', $product) }}"
                       class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 rounded-md font-semibold">
                        ✏️ Düzenle
                    </a>
                    <form action="{{ route('products.destroy', $product) }}"
                          method="POST"
                          class="flex-1"
                          onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-md font-semibold">
                            🗑️ Sil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stok Bilgileri -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Stok Bilgileri</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Mevcut Stok:</span>
                        <span class="font-semibold {{ $product->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                        {{ $product->stock }} adet
                        @if($product->isLowStock())
                                ⚠️
                            @endif
                    </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Minimum Stok:</span>
                        <span class="font-semibold">{{ $product->min_stock }} adet</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Stok Takibi:</span>
                        <span class="font-semibold">
                        {{ $product->track_stock ? '✓ Aktif' : '✗ Kapalı' }}
                    </span>
                    </div>

                    @if($product->isLowStock())
                        <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-md">
                            <p class="text-red-700 text-sm">
                                ⚠️ Stok seviyesi düşük! Yeni stok siparişi gerekebilir.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Finansal Bilgiler -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Finansal Bilgiler</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Satış Fiyatı:</span>
                        <span class="font-semibold">{{ number_format($product->price, 2) }} ₺</span>
                    </div>

                    @if($product->cost_price)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Maliyet Fiyatı:</span>
                            <span class="font-semibold">{{ number_format($product->cost_price, 2) }} ₺</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Kar Marjı:</span>
                            <span class="font-semibold text-green-600">
                            %{{ number_format($product->profit_margin, 2) }}
                        </span>
                        </div>
                    @endif

                    @if($product->compare_price)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Liste Fiyatı:</span>
                            <span class="font-semibold">{{ number_format($product->compare_price, 2) }} ₺</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">İstatistikler</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Görüntülenme:</span>
                        <span class="font-semibold">{{ number_format($product->view_count) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Eklenme Tarihi:</span>
                        <span class="font-semibold">{{ $product->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Son Güncelleme:</span>
                        <span class="font-semibold">{{ $product->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
