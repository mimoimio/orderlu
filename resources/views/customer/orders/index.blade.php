<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900 border-l-4 border-green-400 p-4 mb-6">
                    <p class="text-sm text-green-700 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($orders->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">You haven't placed any orders yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($orders as $order)
                            <div class="border dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            Order #{{ $order->id }} - {{ $order->vendor->business_name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                            RM{{ number_format($order->total_price, 0, ',', '.') }}
                                        </p>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if ($order->status === 'pending_payment') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($order->status === 'preparing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                            @if ($order->status === 'pending_payment')
                                                Payment Verification Pending
                                            @elseif($order->status === 'preparing')
                                                Being Prepared
                                            @else
                                                Ready for Pickup
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Items:</p>
                                    @foreach ($order->orderItems as $item)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            • {{ $item->menu->name }} × {{ $item->quantity }}
                                        </p>
                                    @endforeach
                                </div>

                                <a href="{{ route('customer.orders.show', $order) }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
