<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order #' . $order->id . ' Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900 border-l-4 border-green-400 p-4 mb-6">
                    <p class="text-sm text-green-700 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-sm text-blue-700 dark:text-blue-200">{{ session('info') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Order from {{ $order->user->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Customer Email: {{ $order->user->email }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Ordered on {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                            @if ($order->status === 'pending_payment') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($order->status === 'preparing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                            @if ($order->status === 'pending_payment')
                                Pending Verification
                            @elseif($order->status === 'preparing')
                                Being Prepared
                            @else
                                Completed
                            @endif
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Order Items</h4>
                    @foreach ($order->orderItems as $item)
                        <div class="flex justify-between items-center py-3 border-b dark:border-gray-700">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $item->menu->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }} × RM
                                    {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">
                                RM{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center py-4 text-xl font-bold">
                        <span class="text-gray-900 dark:text-gray-100">Total</span>
                        <span class="text-indigo-600 dark:text-indigo-400">RM
                            {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($order->payment_proof_path)
                    <div class="mb-6">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Payment Proof</h4>
                        <img src="{{ asset('storage/' . $order->payment_proof_path) }}" alt="Payment Proof"
                            class="max-w-md rounded-lg shadow-md">
                    </div>
                @endif

                <div class="flex justify-between items-center pt-6 border-t dark:border-gray-700">
                    <a href="{{ $order->status === 'pending_payment' ? route('vendor.orders.new') : ($order->status === 'preparing' ? route('vendor.orders.preparing') : route('vendor.orders.completed')) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500">
                        Back to Orders
                    </a>

                    <div class="space-x-2">
                        @if ($order->status === 'pending_payment')
                            <form action="{{ route('vendor.orders.verify', $order) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Verify this payment and start preparing the order?')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Verify Payment
                                </button>
                            </form>
                        @elseif($order->status === 'preparing')
                            <form action="{{ route('vendor.orders.complete', $order) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Mark this order as ready for pickup?')"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Mark as Ready
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
