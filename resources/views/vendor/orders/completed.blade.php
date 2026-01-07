<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Completed Orders') }}
            </h2>
            <button onclick="window.location.reload()"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Refresh
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($orders->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No completed orders yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($orders as $order)
                            <div class="border dark:border-gray-700 rounded-lg p-6 hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            Order #{{ $order->id }} from {{ $order->user->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Completed on {{ $order->updated_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                    <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                        RM{{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Items:</p>
                                    @foreach ($order->orderItems as $item)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            • {{ $item->menu->name }} × {{ $item->quantity }}
                                        </p>
                                    @endforeach
                                </div>

                                <a href="{{ route('vendor.orders.show', $order) }}"
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
