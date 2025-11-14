@extends('layouts.app')

@section('title', 'Yeni Marka Ekle - PazarYeri Admin')

@section('content')
    @role('admin')
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-2xl mx-auto">
                <!-- Başlık ve Geri Dön -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('brands.index') }}"
                           class="flex items-center text-indigo-600 hover:text-indigo-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span class="font-medium">Markalara Dön</span>
                        </a>
                        <div class="h-6 w-0.5 bg-gray-300"></div>
                        <h1 class="text-3xl font-bold text-gray-900">Yeni Marka Ekle</h1>
                    </div>
                </div>

                <!-- Form Kartı -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <i class="fas fa-copyright text-white text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-bold text-white">Marka Bilgileri</h2>
                                <p class="text-indigo-100 text-sm">Yeni marka için gerekli bilgileri doldurun</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <form class="p-6 space-y-6" action="{{ route('brands.store') }}" method="POST">
                        @csrf

                        <!-- Marka Adı -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-2 text-gray-400"></i>
                                Marka Adı *
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                   placeholder="Marka adını giriniz">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Açıklama -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-gray-400"></i>
                                Açıklama
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                      placeholder="Marka hakkında kısa bir açıklama">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durum -->
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Markayı aktif olarak yayınla
                            </label>
                        </div>

                        <!-- Form Butonları -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="flex-1 bg-indigo-600 text-white py-4 px-6 rounded-xl font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i>
                                Markayı Kaydet
                            </button>
                            <a href="{{ route('brands.index') }}"
                               class="flex-1 bg-gray-100 text-gray-700 py-4 px-6 rounded-xl font-semibold text-center hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>
                                İptal
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Yardım Kartı -->
                <div class="mt-6 bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        İpuçları
                    </h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-indigo-500 mt-0.5"></i>
                            <p>Marka adı benzersiz olmalıdır ve sistemde kayıtlı başka bir marka ile aynı olamaz.</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-indigo-500 mt-0.5"></i>
                            <p>Marka pasif duruma getirildiğinde, bu markaya ait ürünler listede görünmez.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
