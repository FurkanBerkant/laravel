@extends('layouts.app')

@section('title', 'Ürün Düzenle: ' . $product->name)

@section('content')
    @role('admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ürün Düzenle</h1>
                <p class="text-gray-600 mt-1">{{ $product->name }}</p>
            </div>
            <a href="{{ route('products.show', $product) }}"
               class="text-indigo-600 hover:text-indigo-800">
                ← Ürüne Dön
            </a>
        </div>

        <form action="{{ route('products.update', $product) }}"
              method="POST"
              enctype="multipart/form-data"
              x-data="productForm({{ $product->price }}, {{ $product->cost_price ?? 0 }}, {{ $product->discount_percentage }})">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Sol Kolon - Ana Bilgiler -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Temel Bilgiler -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Temel Bilgiler</h2>

                        <!-- Ürün Adı -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Ürün Adı *
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $product->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori *
                            </label>
                            <select name="category_id"
                                    id="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Kategori Seçin</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div class="mb-4">
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                SKU (Stok Kodu)
                            </label>
                            <input type="text"
                                   name="sku"
                                   id="sku"
                                   value="{{ old('sku', $product->sku) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                            @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">SKU değiştirmek önerilmez</p>
                        </div>

                        <!-- Kısa Açıklama -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Kısa Açıklama
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Detaylı Açıklama -->
                        <div class="mb-4">
                            <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Detaylı Açıklama
                            </label>
                            <textarea name="long_description"
                                      id="long_description"
                                      rows="6"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('long_description', $product->long_description) }}</textarea>
                            @error('long_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Fiyatlandırma -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Fiyatlandırma</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Satış Fiyatı -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Satış Fiyatı (₺) *
                                </label>
                                <input type="number"
                                       name="price"
                                       id="price"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       min="0"
                                       x-model="price"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md @error('price') border-red-500 @enderror"
                                       required>
                                @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Maliyet Fiyatı -->
                            <div>
                                <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Maliyet Fiyatı (₺)
                                </label>
                                <input type="number"
                                       name="cost_price"
                                       id="cost_price"
                                       value="{{ old('cost_price', $product->cost_price) }}"
                                       step="0.01"
                                       min="0"
                                       x-model="costPrice"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                @error('cost_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Karşılaştırma Fiyatı -->
                            <div>
                                <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Karşılaştırma Fiyatı (₺)
                                </label>
                                <input type="number"
                                       name="compare_price"
                                       id="compare_price"
                                       value="{{ old('compare_price', $product->compare_price) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                @error('compare_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- İndirim Yüzdesi -->
                            <div>
                                <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                    İndirim Yüzdesi (%)
                                </label>
                                <input type="number"
                                       name="discount_percentage"
                                       id="discount_percentage"
                                       value="{{ old('discount_percentage', $product->discount_percentage) }}"
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       x-model="discount"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                @error('discount_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kar Marjı Hesaplama -->
                        <div x-show="costPrice > 0" class="mt-4 p-4 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-700">
                                <strong>İndirimli Fiyat:</strong>
                                <span x-text="finalPrice.toFixed(2)"></span> ₺
                            </p>
                            <p class="text-sm text-gray-700">
                                <strong>Kar Marjı:</strong>
                                <span x-text="profitMargin.toFixed(2)"></span>%
                            </p>
                            <p class="text-sm text-gray-700">
                                <strong>Birim Kar:</strong>
                                <span x-text="(price - costPrice).toFixed(2)"></span> ₺
                            </p>
                        </div>
                    </div>

                    <!-- Stok Yönetimi -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Stok Yönetimi</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Stok Miktarı -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stok Miktarı *
                                </label>
                                <input type="number"
                                       name="stock"
                                       id="stock"
                                       value="{{ old('stock', $product->stock) }}"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md @error('stock') border-red-500 @enderror"
                                       required>
                                @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($product->isLowStock())
                                    <p class="mt-1 text-xs text-red-600">⚠️ Düşük stok seviyesi!</p>
                                @endif
                            </div>

                            <!-- Minimum Stok -->
                            <div>
                                <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Minimum Stok Uyarısı
                                </label>
                                <input type="number"
                                       name="min_stock"
                                       id="min_stock"
                                       value="{{ old('min_stock', $product->min_stock) }}"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                @error('min_stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok Durumu -->
                            <div>
                                <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stok Durumu *
                                </label>
                                <select name="stock_status"
                                        id="stock_status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                        required>
                                    <option value="in_stock" {{ old('stock_status', $product->stock_status) == 'in_stock' ? 'selected' : '' }}>
                                        Stokta
                                    </option>
                                    <option value="out_of_stock" {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>
                                        Tükendi
                                    </option>
                                    <option value="on_backorder" {{ old('stock_status', $product->stock_status) == 'on_backorder' ? 'selected' : '' }}>
                                        Ön Sipariş
                                    </option>
                                </select>
                                @error('stock_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok Takibi -->
                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox"
                                           name="track_stock"
                                           value="1"
                                           {{ old('track_stock', $product->track_stock) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600">
                                    <span class="ml-2 text-sm text-gray-700">Stok takibi yap</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Ölçüler -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Ölçüler ve Ağırlık</h2>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ağırlık (kg)
                                </label>
                                <input type="number"
                                       name="weight"
                                       id="weight"
                                       value="{{ old('weight', $product->weight) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="length" class="block text-sm font-medium text-gray-700 mb-2">
                                    Uzunluk (cm)
                                </label>
                                <input type="number"
                                       name="length"
                                       id="length"
                                       value="{{ old('length', $product->length) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="width" class="block text-sm font-medium text-gray-700 mb-2">
                                    Genişlik (cm)
                                </label>
                                <input type="number"
                                       name="width"
                                       id="width"
                                       value="{{ old('width', $product->width) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                                    Yükseklik (cm)
                                </label>
                                <input type="number"
                                       name="height"
                                       id="height"
                                       value="{{ old('height', $product->height) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sağ Kolon - Görseller ve Ayarlar -->
                <div class="space-y-6">

                    <!-- Ana Resim -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Ana Ürün Resmi</h2>

                        <!-- Mevcut Resim -->
                        @if($product->main_image)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Mevcut Resim:</p>
                                <img src="{{ $product->main_image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover rounded-md">
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">
                                Yeni Resim Yükle
                            </label>
                            <input type="file"
                                   name="main_image"
                                   id="main_image"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                   onchange="previewMainImage(event)">
                            @error('main_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Yeni resim yüklerseniz mevcut resim değiştirilecek
                            </p>
                        </div>

                        <!-- Yeni Resim Önizleme -->
                        <div id="mainImagePreview" class="hidden">
                            <p class="text-sm text-gray-600 mb-2">Yeni Resim:</p>
                            <img src="" alt="Önizleme" class="w-full h-48 object-cover rounded-md">
                        </div>
                    </div>

                    <!-- Ek Resimler -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Ek Resimler (Galeri)</h2>

                        <!-- Mevcut Galeri -->
                        @if($product->images && count($product->images) > 0)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Mevcut Resimler:</p>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($product->images as $image)
                                        <img src="{{ asset('storage/' . $image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-20 object-cover rounded-md">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                                Yeni Resimler Ekle
                            </label>
                            <input type="file"
                                   name="images[]"
                                   id="images"
                                   accept="image/*"
                                   multiple
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                   onchange="previewGalleryImages(event)">
                            @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Yeni resimler eklerseniz mevcut galeri değiştirilecek
                            </p>
                        </div>

                        <!-- Galeri Önizleme -->
                        <div id="galleryPreview" class="grid grid-cols-2 gap-2 hidden"></div>
                    </div>

                    <!-- SEO -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">SEO Ayarları</h2>

                        <div class="mb-4">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Başlık
                            </label>
                            <input type="text"
                                   name="meta_title"
                                   id="meta_title"
                                   value="{{ old('meta_title', $product->meta_title) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Açıklama
                            </label>
                            <textarea name="meta_description"
                                      id="meta_description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                    </div>

                    <!-- Durum ve Ayarlar -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Durum ve Ayarlar</h2>

                        <div class="space-y-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600">
                                <span class="ml-2 text-sm text-gray-700">Ürün Aktif</span>
                            </label>

                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox"
                                       name="is_featured"
                                       value="1"
                                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600">
                                <span class="ml-2 text-sm text-gray-700">Öne Çıkan Ürün</span>
                            </label>
                        </div>

                        <div class="mt-4">
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Sıralama
                            </label>
                            <input type="number"
                                   name="order"
                                   id="order"
                                   value="{{ old('order', $product->order) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>

                    <!-- İstatistikler -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">İstatistikler</h2>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Görüntülenme:</span>
                                <span class="font-semibold">{{ number_format($product->view_count) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Oluşturma:</span>
                                <span class="font-semibold">{{ $product->created_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Son Güncelleme:</span>
                                <span class="font-semibold">{{ $product->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kaydet Butonu -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-md mb-3">
                            💾 Değişiklikleri Kaydet
                        </button>
                        <a href="{{ route('products.show', $product) }}"
                           class="block w-full text-center px-4 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            ← Geri Dön
                        </a>
                    </div>

                </div>
            </div>
        </form>
    @endsection

    @push('scripts')
        <script>
            // Alpine.js - Fiyat hesaplamaları
            function productForm(initialPrice, initialCost, initialDiscount) {
                return {
                    price: initialPrice,
                    costPrice: initialCost,
                    discount: initialDiscount,
                    get finalPrice() {
                        if (this.discount > 0) {
                            return this.price - (this.price * this.discount / 100);
                        }
                        return this.price;
                    },
                    get profitMargin() {
                        if (this.costPrice > 0) {
                            return ((this.price - this.costPrice) / this.costPrice) * 100;
                        }
                        return 0;
                    }
                }
            }

            // Ana resim önizleme
            function previewMainImage(event) {
                const preview = document.getElementById('mainImagePreview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.querySelector('img').src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }

            // Galeri resimleri önizleme
            function previewGalleryImages(event) {
                const preview = document.getElementById('galleryPreview');
                const files = event.target.files;

                preview.innerHTML = '';

                if (files.length > 0) {
                    preview.classList.remove('hidden');

                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.innerHTML = `<img src="${e.target.result}" class="w-full h-20 object-cover rounded-md">`;
                            preview.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            }
        </script>
    @endrole
@endpush
