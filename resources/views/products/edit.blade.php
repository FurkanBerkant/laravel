@extends('layouts.app')

@section('title', 'Ürün Düzenle: ' . $product->name)

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Ürün Düzenle</h1>
            <p class="text-gray-600 mt-1">SKU: {{ $product->sku }}</p>
        </div>
        <a href="{{ route('products.show', $product) }}"
           class="text-indigo-600 hover:text-indigo-800">
            ← Ürüne Dön
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('products.update', $product) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Temel Bilgiler</h2>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori *
                            </label>
                            <select name="category_id" id="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Kategori Seçiniz</option>
                                {{-- Varsayım: Controller $categories'i gönderiyor --}}
                                @foreach($categories as $categoryOption)
                                    <option value="{{ $categoryOption->id }}"
                                        {{ old('category_id', $product->category_id) == $categoryOption->id ? 'selected' : '' }}>
                                        {{ $categoryOption->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Ürün Adı *
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $product->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                                   placeholder="Örn: Akıllı Telefon 15 Pro"
                                   required>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Kısa Açıklama (SEO)
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                                      placeholder="Arama motorları için kısa özet...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Detaylı Açıklama
                            </label>
                            <textarea name="long_description"
                                      id="long_description"
                                      rows="6"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500"
                                      placeholder="Ürünün tüm özellikleri ve detayları...">{{ old('long_description', $product->long_description) }}</textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Fiyat ve Stok</h2>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Satış Fiyatı (₺) *
                                </label>
                                <input type="number" step="0.01" min="0"
                                       name="price"
                                       id="price"
                                       value="{{ old('price', $product->price) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                    İndirim (%)
                                </label>
                                <input type="number" step="1" min="0" max="100"
                                       name="discount_percentage"
                                       id="discount_percentage"
                                       value="{{ old('discount_percentage', $product->discount_percentage) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stok Miktarı *
                            </label>
                            <input type="number" min="0"
                                   name="stock"
                                   id="stock"
                                   value="{{ old('stock', $product->stock) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500" required>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-6">

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Görseller</h2>

                        <div class="mb-4">
                            <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">
                                Ana Ürün Resmi
                            </label>
                            @if($product->main_image)
                                <div class="mb-3">
                                    <img src="{{ $product->main_image_url }}" alt="Mevcut Resim"
                                         class="h-32 w-32 object-cover rounded-md border border-gray-300">
                                    <p class="text-xs text-gray-500 mt-1">Mevcut resim. Yeni yükleyerek değiştirin.</p>
                                </div>
                            @endif
                            <input type="file" name="main_image" id="main_image" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                                Ek Galeri Görselleri (Çoklu Seçim)
                            </label>
                            {{-- Mevcut galeri görselleri burada yönetilebilir (silme/gösterme) --}}
                            <input type="file" name="images[]" id="images" multiple accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500">
                            <p class="mt-1 text-xs text-gray-500">Mevcut görsellere ek olarak yüklenecektir.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Durum</h2>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700">Ürün Sitede Aktif</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_featured" value="1"
                                       {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-yellow-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700">Ana Sayfada Öne Çıkan</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="track_stock" value="1"
                                       {{ old('track_stock', $product->track_stock) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm">
                                <span class="ml-2 text-sm text-gray-700">Stok Miktarını Takip Et</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Sıralama Değeri
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $product->order) }}"
                                   min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6">
                <div class="flex gap-3">
                    <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-bold">
                        💾 Ürünü Güncelle
                    </button>
                    <a href="{{ route('products.show', $product) }}"
                       class="px-8 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-semibold">
                        İptal
                    </a>
                </div>

                <button type="button"
                        onclick="if(confirm('Bu ürünü silmek istediğinize emin misiniz?')) { document.getElementById('deleteProductForm').submit(); }"
                        class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-semibold">
                    🗑️ Ürünü Sil
                </button>
            </div>
        </form>

        <form id="deleteProductForm" action="{{ route('products.destroy', $product) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
