<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout - ' . $vendor->business_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (!$hasQrCode)
                    <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                    Warning: This vendor hasn't uploaded a payment QR code yet. You can still place an
                                    order, but payment instructions may be unclear.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>

                <div class="mb-6">
                    @foreach ($items as $item)
                        <div class="flex justify-between items-center py-3 border-b dark:border-gray-700">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $item['menu']->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item['quantity'] }} × RM
                                    {{ number_format($item['menu']->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">
                                RM{{ number_format($item['subtotal'], 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center py-4 text-xl font-bold">
                        <span class="text-gray-900 dark:text-gray-100">Total</span>
                        <span class="text-indigo-600 dark:text-indigo-400">RM
                            {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($hasQrCode)
                    <div class="mb-6 text-center">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Payment QR Code</h3>
                        <img src="{{ asset('storage/' . $vendor->qr_image_path) }}" alt="Payment QR Code"
                            class="mx-auto max-w-xs rounded-lg shadow-md">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Scan this QR code to make payment</p>
                    </div>
                @endif

                <form action="{{ route('customer.orders.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <input type="hidden" name="cart" value="{{ $cartData }}">

                    <div>
                        <x-label for="payment_proof" value="Upload Payment Proof" />
                        <input type="file" id="payment_proof" name="payment_proof"
                            accept="image/jpeg,image/png,image/jpg,image/webp" required
                            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Max 5MB. Accepted formats: JPG, PNG,
                            WEBP</p>
                        <x-input-error for="payment_proof" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <button type="button" onclick="window.history.back()"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500">
                            Back
                        </button>
                        <x-button>
                            Place Order
                        </x-button>
                    </div>
                </form>

                <script>
                    // Clear cart after placing order (handled on successful submit)
                    document.querySelector('form').addEventListener('submit', function() {
                        localStorage.removeItem('cart');
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
