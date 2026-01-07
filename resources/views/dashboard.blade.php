<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __((Auth::user()->isCustomer() ? 'Customer' : 'Vendor') . ' Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (Auth::user()->isCustomer())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('customer.vendors.index') }}"
                            class="block p-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">Browse Vendors</h3>
                            <p class="text-indigo-100">Find food vendors and place orders</p>
                        </a>

                        <a href="{{ route('customer.orders.index') }}"
                            class="block p-6 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">My Orders</h3>
                            <p class="text-blue-100">Track your order status</p>
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="{{ route('vendor.menus.index') }}"
                            class="block p-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">Manage Menus</h3>
                            <p class="text-green-100">Add, edit, or remove menu items</p>
                        </a>

                        <a href="{{ route('vendor.orders.new') }}"
                            class="block p-6 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">New Orders</h3>
                            <p class="text-yellow-100">Verify payment and accept orders</p>
                        </a>

                        <a href="{{ route('vendor.orders.preparing') }}"
                            class="block p-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">Preparing Orders</h3>
                            <p class="text-blue-100">Mark orders as ready</p>
                        </a>

                        <a href="{{ route('vendor.orders.completed') }}"
                            class="block p-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">Completed Orders</h3>
                            <p class="text-purple-100">View order history</p>
                        </a>

                        <a href="{{ route('vendor.profile.edit') }}"
                            class="block p-6 bg-gradient-to-r from-gray-600 to-gray-800 rounded-lg shadow-lg hover:shadow-xl transition">
                            <h3 class="text-2xl font-bold text-white mb-2">Vendor Profile</h3>
                            <p class="text-gray-300">Update business name & QR code</p>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
