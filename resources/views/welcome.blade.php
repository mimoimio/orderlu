<x-guest-layout>

    <body
        class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex items-center justify-center min-h-screen">
        <div class="max-w-4xl mx-auto px-6 py-12">
            <div class="flex items-center justify-center gap-6 mb-12">
                <img src="{{ asset('favicon/android-chrome-192x192.png') }}" alt="Logo" class="w-48 h-48">
                <div class="text-left">
                    <h1 class="text-2xl font-bold mb-2">🍔 Food Ordering System</h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400">Order food from local vendors with ease</p>
                </div>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- For Customers -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 border-2 border-indigo-500">
                <div class="text-center mb-6">
                    <div class="text-5xl mb-4">👤</div>
                    <h2 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">For Customers</h2>
                </div>
                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                    <li class="flex items-start">
                        <span class="text-indigo-500 mr-2">✓</span>
                        <span>Browse available vendors and their menus</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-indigo-500 mr-2">✓</span>
                        <span>Add items to cart with custom quantities</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-indigo-500 mr-2">✓</span>
                        <span>Upload payment proof after ordering</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-indigo-500 mr-2">✓</span>
                        <span>Track your order status in real-time</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-indigo-500 mr-2">✓</span>
                        <span>Get notified when order is ready</span>
                    </li>
                </ul>
                <div class="mt-8">
                    <a href="{{ route('register') }}"
                        class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        Register as Customer
                    </a>
                </div>

                <!-- Login Section -->
                <div class="text-center bg-gray-100 dark:bg-gray-800 rounded-lg p-8">
                    <p class="text-lg mb-4">Already have an account?</p>
                    <a href="{{ route('login') }}"
                        class="inline-block bg-gray-700 hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        Sign In
                    </a>
                </div>

            </div>

            <!-- How It Works -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-3xl font-bold text-center mb-8">📋 How It Works</h2>
                <div class="grid md:grid-rows-3 gap-6">
                    <div class="text-center">
                        <div class="text-4xl mb-3">1️⃣</div>
                        <h3 class="font-bold text-lg mb-2">Register</h3>
                        <p class="text-gray-600 dark:text-gray-400">Choose your account type during registration</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">2️⃣</div>
                        <h3 class="font-bold text-lg mb-2">Browse & Order</h3>
                        <p class="text-gray-600 dark:text-gray-400">Customers browse vendors, vendors manage menus
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">3️⃣</div>
                        <h3 class="font-bold text-lg mb-2">Track & Fulfill</h3>
                        <p class="text-gray-600 dark:text-gray-400">Real-time order tracking from payment to pickup
                        </p>
                    </div>
                </div>
            </div>
        </div>


        {{-- <!-- Footer -->
            <div class="text-center mt-12 text-gray-500 dark:text-gray-400 text-sm">
                <p>Built with Laravel {{ app()->version() }} & Livewire</p>
            </div> --}}
        </div>
    </body>

</x-guest-layout>
