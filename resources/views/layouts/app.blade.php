<!DOCTYPE html>
<html lang="tr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PazarYeri Admin Paneli - E-ticaret yönetim sistemi">
    <title>@yield('title', 'PazarYeri Admin')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-full flex flex-col" x-data="{ mobileMenuOpen: false }">

<!-- Navigation Bar -->
<nav class="bg-white shadow-md sticky top-0 z-10">
    @auth
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                            <i class="fas fa-store mr-2"></i>
                            PazarYeri
                            <span class="ml-2 text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">Admin</span>
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:ml-8 md:flex md:space-x-6">
                        <a href="{{ route('categories.index') }}"
                           class="{{ request()->routeIs('categories.*') ? 'text-indigo-600 border-indigo-500' : 'text-gray-600 hover:text-gray-900 border-transparent' }} inline-flex items-center px-3 py-2 border-b-2 font-medium transition-colors">
                            <i class="fas fa-tags mr-2"></i>
                            Kategoriler
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="{{ request()->routeIs('products.*') ? 'text-indigo-600 border-indigo-500' : 'text-gray-600 hover:text-gray-900 border-transparent' }} inline-flex items-center px-3 py-2 border-b-2 font-medium transition-colors">
                            <i class="fas fa-box mr-2"></i>
                            Ürünler
                        </a>
                        <a href="{{ route('brands.index') }}"
                           class="{{ request()->routeIs('brands.*') ? 'text-indigo-600 border-indigo-500' : 'text-gray-600 hover:text-gray-900 border-transparent' }} inline-flex items-center px-3 py-2 border-b-2 font-medium transition-colors">
                            <i class="fas fa-copyright mr-2"></i>
                            Markalar
                        </a>
                        <a href="#"
                           class="text-gray-600 hover:text-gray-900 border-transparent inline-flex items-center px-3 py-2 border-b-2 font-medium transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Siparişler
                        </a>
                    </div>
                </div>

                <!-- User Menu & Logout -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700 hidden sm:inline">Hoş geldiniz, {{ Auth::user()->name ?? 'Admin' }}</span>

                    <!-- Genişletilmiş Çıkış Butonu -->
                    <form action="{{ route('logout') }}" method="POST" class="flex">
                        @csrf
                        <button type="submit" class="flex items-center bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 px-4 py-2 rounded-lg border border-red-200 transition-all duration-200 font-medium shadow-sm hover:shadow">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span class="whitespace-nowrap">Çıkış Yap</span>
                        </button>
                    </form>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-gray-200 pt-4 pb-3">
                <div class="flex items-center px-4 mb-4">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors">
                        <i class="fas fa-tags mr-3 w-5 text-center"></i>
                        Kategoriler
                    </a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors">
                        <i class="fas fa-box mr-3 w-5 text-center"></i>
                        Ürünler
                    </a>
                    <a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.*') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors">
                        <i class="fas fa-copyright mr-3 w-5 text-center"></i>
                        Markalar
                    </a>
                    <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900 block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors">
                        <i class="fas fa-shopping-cart mr-3 w-5 text-center"></i>
                        Siparişler
                    </a>

                    <!-- Mobil Çıkış Butonu -->
                    <div class="pt-2 mt-2 border-t border-gray-200">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 px-4 py-3 rounded-lg border border-red-200 transition-all duration-200 font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Çıkış Yap
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</nav>

<!-- Flash Messages -->
<div class="flash-messages">
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600 flash-close transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 flash-close transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Formda {{ $errors->count() }} hata bulundu</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 flash-close transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Main Content -->
<main class="flex-grow">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex justify-center md:justify-start">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600 flex items-center hover:text-indigo-700 transition-colors">
                    <i class="fas fa-store mr-2"></i>
                    PazarYeri
                </a>
            </div>
            <div class="mt-4 md:mt-0 md:order-1">
                <p class="text-center text-sm text-gray-500">
                    © {{ date('Y') }} PazarYeri. Laravel E-Ticaret Projesi
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Custom JavaScript -->
<script>
    // Flash mesajlarını kapatma
    document.addEventListener('DOMContentLoaded', function() {
        const closeButtons = document.querySelectorAll('.flash-close');

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const messageContainer = this.closest('.max-w-7xl');
                messageContainer.style.opacity = '0';
                messageContainer.style.transition = 'opacity 0.3s ease';
                setTimeout(() => messageContainer.remove(), 300);
            });
        });

        // 5 saniye sonra flash mesajlarını otomatik kapat
        setTimeout(() => {
            document.querySelectorAll('.flash-messages .max-w-7xl').forEach(el => {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s ease';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    });
</script>

@stack('scripts')
</body>
</html>
