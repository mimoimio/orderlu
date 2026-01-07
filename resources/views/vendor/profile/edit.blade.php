<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vendor Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900 border-l-4 border-green-400 p-4 mb-6">
                    <p class="text-sm text-green-700 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900 border-l-4 border-red-400 p-4 mb-6">
                    <p class="text-sm text-red-700 dark:text-red-200">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div>
                        <x-label for="business_name" value="Business Name" />
                        <x-input id="business_name" type="text" name="business_name" :value="old('business_name', $vendor->business_name)" required
                            autofocus class="mt-1 block w-full" />
                        <x-input-error for="business_name" class="mt-2" />
                    </div>

                    @if ($vendor->qr_image_path)
                        <div>
                            <x-label value="Current Payment QR Code" />
                            <img src="{{ asset('storage/' . $vendor->qr_image_path) }}" alt="Payment QR Code"
                                class="mt-2 w-64 rounded-md shadow-md">
                        </div>
                    @endif

                    <div>
                        <x-label for="qr_image" value="Payment QR Code" />
                        <input type="file" id="qr_image" name="qr_image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Max 4MB. Accepted formats: JPG, PNG,
                            WEBP. {{ $vendor->qr_image_path ? 'Leave empty to keep current image.' : '' }}</p>
                        <x-input-error for="qr_image" class="mt-2" />

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <x-label value="Preview" />
                            <img id="previewImg" src="" alt="QR Code Preview"
                                class="mt-2 w-64 rounded-md shadow-md">
                            <button type="button" onclick="clearPreview()"
                                class="mt-2 text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                                Remove
                            </button>
                        </div>

                        <!-- File Size Error -->
                        <p id="fileSizeError" class="text-sm text-red-600 dark:text-red-400 mt-2 hidden">
                            File size exceeds 4MB. Please choose a smaller image.
                        </p>
                    </div>

                    <div class="flex items-center justify-end">
                        <x-button>
                            Update Profile
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const qrImageInput = document.getElementById('qr_image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const fileSizeError = document.getElementById('fileSizeError');
        const maxSize = 4 * 1024 * 1024; // 4MB in bytes

        qrImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            // Hide error initially
            fileSizeError.classList.add('hidden');

            if (file) {
                // Check file size
                if (file.size > maxSize) {
                    fileSizeError.classList.remove('hidden');
                    imagePreview.classList.add('hidden');
                    e.target.value = ''; // Clear the input
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
            }
        });

        function clearPreview() {
            qrImageInput.value = '';
            imagePreview.classList.add('hidden');
            previewImg.src = '';
            fileSizeError.classList.add('hidden');
        }
    </script>
</x-app-layout>
