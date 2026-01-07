<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $vendor->business_name }}
            </h2>
            <div class="flex items-center space-x-4">
                <button onclick="clearCart()"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    Clear Cart
                </button>
                <button onclick="viewCart()"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    View Cart (<span id="cart-count">0</span>)
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($menus->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No menu items available.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($menus as $menu)
                            <div class="border dark:border-gray-700 rounded-lg p-6">
                                @if ($menu->image_path)
                                    <img src="{{ asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}"
                                        class="w-full h-48 object-cover rounded-md mb-4">
                                @endif
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $menu->name }}
                                </h3>
                                @if ($menu->description)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                                        {{ $menu->description }}
                                    </p>
                                @endif
                                <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-4">
                                    RM{{ number_format($menu->price, 0, ',', '.') }}
                                </p>
                                <div class="flex items-center space-x-2">
                                    <input type="number" id="qty-{{ $menu->id }}" min="1" value="1"
                                        class="w-20 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                    <button
                                        onclick="addToCart({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, {{ $vendor->id }})"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const currentVendorId = {{ $vendor->id }};
        let cartModified = false;

        // Cart management using localStorage
        function getCart() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        }

        function saveCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            cartModified = true;
        }

        function updateCartCount() {
            const cart = getCart();
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = totalItems;
        }

        function clearCart() {
            if (confirm('Clear all items from cart?')) {
                localStorage.removeItem('cart');
                updateCartCount();
                cartModified = false;
                alert('Cart cleared!');
            }
        }

        function checkExistingCart() {
            const cart = getCart();
            if (cart.length > 0 && cart[0].vendor_id !== currentVendorId) {
                if (confirm(
                        'You have items from another vendor in your cart. Do you want to clear them and start a new order here?'
                        )) {
                    localStorage.removeItem('cart');
                    updateCartCount();
                    cartModified = false;
                } else {
                    // Redirect back to vendors list
                    window.location.href = '{{ route('customer.vendors.index') }}';
                }
            }
        }

        function addToCart(menuId, menuName, price, vendorId) {
            const quantity = parseInt(document.getElementById(`qty-${menuId}`).value);
            let cart = getCart();

            // Check if cart has items from different vendor
            if (cart.length > 0 && cart[0].vendor_id !== vendorId) {
                if (!confirm('Your cart has items from another vendor. Clear cart and add this item?')) {
                    return;
                }
                cart = [];
            }

            // Check if item already in cart
            const existingItem = cart.find(item => item.menu_id === menuId);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({
                    menu_id: menuId,
                    name: menuName,
                    price: price,
                    quantity: quantity,
                    vendor_id: vendorId
                });
            }

            saveCart(cart);
            alert(`${menuName} added to cart!`);
        }

        function viewCart() {
            const cart = getCart();
            if (cart.length === 0) {
                alert('Cart is empty!');
                return;
            }
            cartModified = false; // Don't warn when going to checkout
            window.location.href = '{{ route('customer.orders.create') }}?cart=' + encodeURIComponent(JSON.stringify(
                cart));
        }

        // Warn before leaving page with items in cart
        window.addEventListener('beforeunload', function(e) {
            const cart = getCart();
            if (cart.length > 0 && cartModified) {
                e.preventDefault();
                e.returnValue = 'You have items in your cart. Are you sure you want to leave?';
                return e.returnValue;
            }
        });

        // Check for existing cart from different vendor on page load
        checkExistingCart();

        // Update cart count on page load
        updateCartCount();
    </script>
</x-app-layout>
