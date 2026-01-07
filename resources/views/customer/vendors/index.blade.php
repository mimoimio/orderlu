<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Food Vendors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($vendors->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No vendors available yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($vendors as $vendor)
                            <div class="border dark:border-gray-700 rounded-lg p-6 hover:shadow-lg transition">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $vendor->business_name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">
                                    by {{ $vendor->user->name }}
                                </p>
                                <a href="{{ route('customer.vendors.show', $vendor) }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                                    View Menu
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
