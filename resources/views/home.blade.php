@extends('layouts.app')

@section('title', 'Ana Sayfa')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">PazarYeri Yönetim Paneli</h1>

        <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700 p-4 mb-8" role="alert">
            <p class="font-bold">Hoş Geldiniz!</p>
            <p>Sisteminiz Docker'da sorunsuz çalışıyor. Kodlamaya başlayabilirsiniz.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Hızlı Erişim Kartı 1: Kategoriler --}}
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-2xl font-semibold text-indigo-600 mb-3">Kategoriler</h2>
                <p class="text-gray-600 mb-4">Mevcut kategorileri görüntüleyin veya yeni bir kategori ekleyin.</p>
                <a href="{{ route('categories.index') }}" class="text-sm font-semibold text-indigo-500 hover:text-indigo-700">
                    Kategorileri Yönet →
                </a>
            </div>

            {{-- Hızlı Erişim Kartı 2: Ürünler --}}
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-2xl font-semibold text-green-600 mb-3">Ürünler</h2>
                <p class="text-gray-600 mb-4">Tüm ürünlerinizi listeler, stok ve fiyatlarını düzenler.</p>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-green-500 hover:text-green-700">
                    Ürünleri Yönet →
                </a>
            </div>

            {{-- Hızlı Erişim Kartı 3: Siparişler (İleride) --}}
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300">
                <h2 class="text-2xl font-semibold text-yellow-600 mb-3">Siparişler</h2>
                <p class="text-gray-600 mb-4">Gelen siparişleri takip edin ve durumlarını güncelleyin.</p>
                <a href="#" class="text-sm font-semibold text-yellow-500 hover:text-yellow-700">
                    Yakında...
                </a>
            </div>
        </div>
    </div>
@endsection
