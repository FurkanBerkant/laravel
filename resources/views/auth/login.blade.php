@extends('layouts.app')

@section('title', 'Giriş Yap - PazarYeri Admin')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
        <div class="max-w-lg w-full space-y-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 sm:p-10 transition-colors duration-300">
            <!-- Başlık ve Logo -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    PazarYeri Admin
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Hesabınıza giriş yapın
                </p>
            </div>

            <!-- Başarı Mesajı -->
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <div>
                            <p class="text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hata Mesajları -->
            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-red-700 dark:text-red-300 font-medium mb-2">Giriş sırasında hata oluştu:</p>
                            <ul class="text-red-600 dark:text-red-300 text-sm list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Giriş Formu -->
            <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            E-posta Adresi
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                class="appearance-none relative block w-full px-4 py-4 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white dark:bg-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-lg transition-all duration-200"
                                placeholder="ornek@email.com"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Şifre Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>
                            Şifre
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="appearance-none relative block w-full px-4 py-4 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white dark:bg-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-lg transition-all duration-200"
                                placeholder="Şifrenizi girin"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ekstra Seçenekler -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Beni hatırla
                        </label>
                    </div>

                </div>

                <!-- Giriş Butonu -->
                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-lg font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-indigo-300 group-hover:text-indigo-200"></i>
                    </span>
                        Giriş Yap
                    </button>
                </div>

                <!-- Hesap Oluşturma Linki -->
                <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-600">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Hesabınız yok mu?
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors ml-1">
                            <i class="fas fa-user-plus mr-1"></i>
                            Hesap Oluştur
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
