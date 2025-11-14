@extends('layouts.app')

@section('title', 'Markalar - PazarYeri Admin')

@section('content')
    @role('admin')
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Başlık ve Buton -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Markalar</h1>
                    <p class="mt-2 text-sm text-gray-600">Sistemde kayıtlı tüm markaları yönetin</p>
                </div>
                <a href="{{ route('brands.create') }}"
                   class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i>
                    Yeni Marka Ekle
                </a>
            </div>

            <!-- Markalar Grid -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Tablo Başlığı -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="grid grid-cols-12 gap-4 text-sm font-semibold text-gray-700">
                        <div class="col-span-5">Marka Adı</div>
                        <div class="col-span-5">Açıklama</div>
                        <div class="col-span-1 text-center">Durum</div>
                        <div class="col-span-1 text-center">İşlemler</div>
                    </div>
                </div>

                <!-- Marka Listesi -->
                <div class="divide-y divide-gray-200" id="brandsList">
                    @foreach($brands as $brand)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150 brand-item" data-brand-id="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <!-- Marka Adı -->
                                <div class="col-span-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-copyright text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 brand-name">{{ $brand->name }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <!-- Açıklama -->
                                <div class="col-span-5">
                                    <p class="text-sm text-gray-600 line-clamp-2 brand-description">
                                        {{ $brand->description ?? 'Açıklama bulunmuyor' }}
                                    </p>
                                </div>

                                <!-- Durum -->
                                <div class="col-span-1">
                                    <div class="flex justify-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium brand-status {{ $brand->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $brand->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                                    </div>
                                </div>

                                <!-- İşlemler -->
                                <div class="col-span-1">
                                    <div class="flex justify-center space-x-2">
                                        <!-- Düzenle Butonu -->
                                        <button onclick="editBrand({{ $brand->id }})"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 edit-btn"
                                                title="Markayı Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Sil Butonu -->
                                        <button onclick="deleteBrand({{ $brand->id }})"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200 delete-btn"
                                                title="Markayı Sil">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Düzenleme Modal -->
        <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-2xl bg-white">
                <div class="mt-3">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-3 border-b">
                        <h3 class="text-xl font-bold text-gray-900">Markayı Düzenle</h3>
                        <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Modal Form -->
                    <form id="editBrandForm" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="edit_brand_id" name="brand_id">

                        <div>
                            <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Marka Adı *
                            </label>
                            <input type="text" id="edit_name" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        </div>

                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Açıklama
                            </label>
                            <textarea id="edit_description" name="description" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="edit_is_active" class="ml-2 block text-sm text-gray-900">
                                Marka aktif
                            </label>
                        </div>

                        <!-- Form Butonları -->
                        <div class="flex space-x-3 pt-4">
                            <button type="submit" id="submitBtn"
                                    class="flex-1 bg-indigo-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-indigo-700 transition-all duration-200 flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                <span class="submit-text">Güncelle</span>
                                <div class="loading hidden ml-2">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                </div>
                            </button>
                            <button type="button" onclick="closeEditModal()"
                                    class="flex-1 bg-gray-100 text-gray-700 py-3 px-4 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200">
                                İptal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // CSRF Token'ı al
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Marka Düzenleme Fonksiyonu
            function editBrand(brandId) {
                // Marka bilgilerini getir
                fetch(`/brands/${brandId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const brand = data.brand;

                            // Formu doldur
                            document.getElementById('edit_name').value = brand.name;
                            document.getElementById('edit_description').value = brand.description || '';
                            document.getElementById('edit_is_active').checked = brand.is_active;
                            document.getElementById('edit_brand_id').value = brand.id;

                            // Form action'ını güncelle
                            document.getElementById('editBrandForm').action = `/brands/${brandId}`;

                            // Modal'ı göster
                            document.getElementById('editModal').classList.remove('hidden');

                            // Input'a focus
                            document.getElementById('edit_name').focus();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showFlashMessage('Marka bilgileri yüklenirken hata oluştu.', 'error');
                    });
            }

            // Marka Silme Fonksiyonu
            function deleteBrand(brandId) {
                if (confirm('Bu markayı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')) {
                    fetch(`/brands/${brandId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Marka satırını kaldır
                                document.querySelector(`.brand-item[data-brand-id="${brandId}"]`).remove();

                                // Başarı mesajı göster
                                showFlashMessage('Marka başarıyla silindi.', 'success');

                                // Eğer hiç marka kalmadıysa boş durumu göster
                                if (document.querySelectorAll('.brand-item').length === 0) {
                                    location.reload();
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showFlashMessage('Marka silinirken hata oluştu.', 'error');
                        });
                }
            }

            // Modal Kapatma
            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
            }

            // Form Submit İşlemi
            document.getElementById('editBrandForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const brandId = document.getElementById('edit_brand_id').value;
                const submitBtn = document.getElementById('submitBtn');
                const submitText = submitBtn.querySelector('.submit-text');
                const loading = submitBtn.querySelector('.loading');

                // Butonu loading durumuna getir
                submitBtn.disabled = true;
                submitText.textContent = 'Güncelleniyor...';
                loading.classList.remove('hidden');

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // UI'ı anında güncelle
                            updateBrandUI(brandId, data.data);

                            // Modal'ı kapat
                            closeEditModal();

                            // Başarı mesajı göster
                            showFlashMessage('Marka başarıyla güncellendi!', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showFlashMessage('Marka güncellenirken hata oluştu.', 'error');
                    })
                    .finally(() => {
                        // Butonu eski haline getir
                        submitBtn.disabled = false;
                        submitText.textContent = 'Güncelle';
                        loading.classList.add('hidden');
                    });
            });

            // UI'ı anında güncelle
            function updateBrandUI(brandId, brandData) {
                const brandElement = document.getElementById(`brand-${brandId}`);

                if (brandElement) {
                    // Marka adını güncelle
                    const nameElement = brandElement.querySelector('.brand-name');
                    nameElement.textContent = brandData.name;

                    // Açıklamayı güncelle
                    const descElement = brandElement.querySelector('.brand-description');
                    descElement.textContent = brandData.description || 'Açıklama bulunmuyor';

                    // Durumu güncelle
                    const statusElement = brandElement.querySelector('.brand-status');
                    statusElement.textContent = brandData.is_active ? 'Aktif' : 'Pasif';
                    statusElement.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium brand-status ${
                        brandData.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                    }`;

                    // Hafif animasyon efekti
                    brandElement.style.transform = 'scale(1.02)';
                    brandElement.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        brandElement.style.transform = 'scale(1)';
                    }, 300);
                }
            }

            // Flash Mesajı Gösterme
            function showFlashMessage(message, type = 'success') {
                // Önceki mesajları temizle
                const existingMessages = document.querySelectorAll('.flash-message');
                existingMessages.forEach(msg => msg.remove());

                const flashDiv = document.createElement('div');
                flashDiv.className = `flash-message fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transform transition-all duration-300 ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                flashDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-2"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

                document.body.appendChild(flashDiv);

                // Giriş animasyonu
                setTimeout(() => {
                    flashDiv.style.transform = 'translateX(0)';
                }, 10);

                // 3 saniye sonra kaldır
                setTimeout(() => {
                    if (flashDiv.parentElement) {
                        flashDiv.style.transform = 'translateX(100%)';
                        setTimeout(() => flashDiv.remove(), 300);
                    }
                }, 3000);
            }

            // ESC tuşu ile modal kapatma
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeEditModal();
                }
            });

            // Modal dışına tıklayarak kapatma
            document.getElementById('editModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });
        </script>

        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .brand-item:hover {
                transform: translateY(-1px);
                transition: all 0.2s ease-in-out;
            }

            .flash-message {
                transform: translateX(100%);
            }

            .loading {
                display: inline-block;
            }
        </style>
    @else
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h2 class="text-4xl font-extrabold text-red-600 mb-4">Erişim Engellendi</h2>
            <p class="text-lg text-gray-700">Bu sayfayı görüntülemek için yeterli yetkiye sahip değilsiniz.</p>
            <a href="{{ route('home') }}" class="mt-6 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Ana Sayfaya Dön
            </a>
        </div>
    @endrole
@endsection
