@extends('layouts.app')

@section('title', 'Yeni Kategori Ekle')

@section('content')
    @role('admin')
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Yeni Kategori Ekle</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('categories.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <!-- Kategori Adı -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Adı *
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                           placeholder="Örn: Elektronik"
                           required>

                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                              placeholder="Kategori hakkında kısa açıklama...">{{ old('description') }}</textarea>

                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resim Yükleme -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Resmi
                    </label>
                    <input type="file"
                           name="image"
                           id="image"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           onchange="previewImage(event)">

                    <!-- Resim Önizleme -->
                    <div id="imagePreview" class="mt-2 hidden">
                        <img src="" alt="Önizleme" class="h-32 w-32 object-cover rounded-md">
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
                           value="{{ old('order', 0) }}"
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
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Kategori aktif</span>
                    </label>
                </div>

                <!-- Butonlar -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('categories.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        İptal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Kategori Oluştur
                    </button>
                </div>
            </form>
        </div>
    @endrole
@endsection

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
            }
        }
    </script>
@endpush
