<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __((Auth::user()->isCustomer() ? 'Customer' : 'Vendor') . ' Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <svg>
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#ff0000;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#3f007e;stop-opacity:1" />
                    </linearGradient>
                </defs>
            </svg>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (Auth::user()->isCustomer())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('customer.vendors.index') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg hover:shadow-xl transition items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" class="bi bi-shop"
                                viewBox="0 0 16 16">
                                <path fill="url(#gradient)"
                                    d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">Browse Vendors</h3>
                            <p class="text-indigo-100">Find food vendors and place orders</p>
                        </a>

                        <a href="{{ route('customer.orders.index') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg shadow-lg hover:shadow-xl transition items-center">

                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="url(#gradient)"
                                class="bi bi-list-task" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z" />
                                <path
                                    d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z" />
                                <path fill-rule="evenodd"
                                    d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">My Orders</h3>
                            <p class="text-blue-100">Track your order status</p>
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="{{ route('vendor.menus.index') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg shadow-lg hover:shadow-xl transition items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="url(#gradient)" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-burger">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 15h16a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4" />
                                <path d="M12 4c3.783 0 6.953 2.133 7.786 5h-15.572c.833 -2.867 4.003 -5 7.786 -5" />
                                <path d="M5 12h14" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">Manage Menus</h3>
                            <p class="text-green-100">Add, edit, or remove menu items</p>
                        </a>

                        <a href="{{ route('vendor.orders.new') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-lg shadow-lg hover:shadow-xl transition items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-script">
                                <path
                                    d="M17 20h-11a3 3 0 0 1 0 -6h11a3 3 0 0 0 0 6h1a3 3 0 0 0 3 -3v-11a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v8" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">New Orders</h3>
                            <p class="text-yellow-100">Verify payment and accept orders</p>
                        </a>

                        <a href="{{ route('vendor.orders.preparing') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg hover:shadow-xl transition items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-stopwatch">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 13a7 7 0 1 0 14 0a7 7 0 0 0 -14 0" />
                                <path d="M14.5 10.5l-2.5 2.5" />
                                <path d="M17 8l1 -1" />
                                <path d="M14 3h-4" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">Preparing Orders</h3>
                            <p class="text-blue-100">Mark orders as ready</p>
                        </a>
                        <a href="{{ route('vendor.orders.completed') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg shadow-lg hover:shadow-xl transition items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">Completed Orders</h3>
                            <p class="text-purple-100">View order history</p>
                        </a>

                        <a href="{{ route('vendor.profile.edit') }}"
                            class="flex flex-col p-6 bg-gradient-to-r from-gray-600 to-gray-800 rounded-lg shadow-lg hover:shadow-xl transition items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 10a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                            </svg>
                            <h3 class="text-2xl font-bold text-white mb-2">Vendor Profile</h3>
                            <p class="text-gray-300">Update business name & QR code</p>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
