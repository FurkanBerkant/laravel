@extends('layouts.app')

@section('title', 'Kategori Düzenle: ' . $category->name)

@section('content')
    @role('admin')
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kategori Düzenle</h1>
                <p class="text-gray-600 mt-1">{{ $category->name }}</p>
            </div>
            <a href="{{ route('categories.show', $category) }}"
               class="text-indigo-600 hover:text-indigo-800">
                ← Kategoriye Dön
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('categories.update', $category) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Kategori Adı -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Adı *
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $category->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                           placeholder="Örn: Elektronik"
                           required>

                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug (Bilgi Amaçlı Göster) -->
                <div class="mb-4">
                    <label for="current_slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Mevcut Slug (URL)
                    </label>
                    <input type="text"
                           id="current_slug"
                           value="{{ $category->slug }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50"
                           disabled>
                    <p class="mt-1 text-xs text-gray-500">
                        Kategori adını değiştirirseniz slug otomatik güncellenecek
                    </p>
                </div>

                <!-- Açıklama -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Açıklama
                    </label>
                    <textarea name="description"
                              id="description"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Kategori hakkında kısa açıklama...">{{ old('description', $category->description) }}</textarea>

                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mevcut Resim ve Yeni Resim Yükleme -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Resmi
                    </label>

                    <!-- Mevcut Resim -->
                    @if($category->image)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Mevcut Resim:</p>
                            <div class="relative inline-block">
                                <img src="{{ $category->image_url }}"
                                     alt="{{ $category->name }}"
                                     class="h-32 w-32 object-cover rounded-md border border-gray-300"
                                     id="currentImage">
                                <button type="button"
                                        onclick="document.getElementById('currentImage').classList.toggle('opacity-50')"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 text-xs">
                                    ✗
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Yeni resim yüklerseniz bu resim değiştirilecek</p>
                        </div>
                    @endif

                    <!-- Yeni Resim Yükle -->
                    <input type="file"
                           name="image"
                           id="image"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           onchange="previewImage(event)">

                    <!-- Yeni Resim Önizleme -->
                    <div id="imagePreview" class="mt-2 hidden">
                        <p class="text-sm text-gray-600 mb-2">Yeni Resim Önizleme:</p>
                        <img src="" alt="Önizleme" class="h-32 w-32 object-cover rounded-md border border-gray-300">
                    </div>

                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Maksimum 2MB, JPEG, PNG, JPG veya GIF formatında
                    </p>
                </div>

                <!-- Sıralama -->
                <div class="mb-4">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Sıralama
                    </label>
                    <input type="number"
                           name="order"
                           id="order"
                           value="{{ old('order', $category->order) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Küçük sayılar önce görüntülenir
                    </p>
                </div>

                <!-- Aktif/Pasif -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Kategori aktif</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500 ml-6">
                        Pasif kategoriler ve içindeki ürünler sitede görünmez
                    </p>
                </div>

                <!-- İstatistik Bilgisi -->
                @if($category->products_count > 0)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-800">
                            ℹ️ Bu kategoride <strong>{{ $category->products_count }} adet ürün</strong> bulunmaktadır.
                        </p>
                    </div>
                @endif

                <!-- Butonlar -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                            💾 Değişiklikleri Kaydet
                        </button>
                        <a href="{{ route('categories.show', $category) }}"
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            İptal
                        </a>
                    </div>

                    <!-- Tehlikeli Alan - Sil Butonu -->
                    <button type="button"
                            onclick="if(confirm('Bu kategoriyi ve içindeki {{ $category->products_count }} ürünü silmek istediğinize emin misiniz?')) { document.getElementById('deleteForm').submit(); }"
                            class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-semibold">
                        🗑️ Kategoriyi Sil
                    </button>
                </div>
            </form>

            <!-- Gizli Silme Formu -->
            <form id="deleteForm"
                  action="{{ route('categories.destroy', $category) }}"
                  method="POST"
                  class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>

        <!-- Son Güncelleme Bilgisi -->
        <div class="mt-4 text-sm text-gray-500 text-center">
            Son güncelleme: {{ $category->updated_at->format('d.m.Y H:i') }}
            ({{ $category->updated_at->diffForHumans() }})
        </div>
    @endsection
    @endrole

    @push('scripts')
        <script>
            // Resim önizleme fonksiyonu
            function previewImage(event) {
                const preview = document.getElementById('imagePreview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.querySelector('img').src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('hidden');
                }
            }
        </script>
@endpush
