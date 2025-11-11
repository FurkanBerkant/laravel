@extends('layouts.app')

@section('title', 'Hesap Oluştur - PazarYeri Admin')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full space-y-8 bg-white rounded-2xl shadow-xl p-8 sm:p-10">
            <!-- Başlık ve Logo -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    PazarYeri Admin
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Yeni hesap oluşturun
                </p>
            </div>

            <!-- Başarı Mesajı -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <div>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hata Mesajları -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-red-700 font-medium mb-2">Kayıt sırasında hata oluştu:</p>
                            <ul class="text-red-600 text-sm list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Kayıt Formu -->
            <form class="mt-8 space-y-6" action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Ad Soyad -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-gray-400"></i>
                                Ad
                            </label>
                            <div class="relative">
                                <input
                                    id="first_name"
                                    name="first_name"
                                    type="text"
                                    value="{{ old('first_name') }}"
                                    required
                                    class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 transition-all duration-200"
                                    placeholder="Adınız"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-gray-400"></i>
                                Soyad
                            </label>
                            <div class="relative">
                                <input
                                    id="last_name"
                                    name="last_name"
                                    type="text"
                                    value="{{ old('last_name') }}"
                                    required
                                    class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 transition-all duration-200"
                                    placeholder="Soyadınız"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
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
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 transition-all duration-200"
                                placeholder="ornek@email.com"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Şifre Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>
                            Şifre
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 transition-all duration-200"
                                placeholder="Şifrenizi girin"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePassword('password')" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Şifre Tekrarı -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-400"></i>
                            Şifre Tekrarı
                        </label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 transition-all duration-200"
                                placeholder="Şifrenizi tekrar girin"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kayıt Butonu -->
                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-lg font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <i class="fas fa-user-plus text-indigo-300 group-hover:text-indigo-200"></i>
                </span>
                        Hesap Oluştur
                    </button>
                </div>

                <!-- Giriş Yapma Linki -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Zaten hesabınız var mı?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors ml-1">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Giriş Yap
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.parentElement.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
@endsection
