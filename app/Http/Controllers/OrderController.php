<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with(['vendor', 'orderItems.menu'])->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order (checkout page).
     */
    public function create(Request $request)
    {
        $cartData = $request->input('cart');
        if (empty($cartData)) {
            return redirect()->route('customer.vendors.index')->with('error', 'Cart is empty');
        }

        $cart = json_decode($cartData, true);
        $vendorId = $cart[0]['vendor_id'] ?? null;

        if (!$vendorId) {
            return redirect()->route('customer.vendors.index')->with('error', 'Invalid cart data');
        }

        $vendor = Vendor::findOrFail($vendorId);
        $items = [];
        $totalPrice = 0;

        foreach ($cart as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $itemTotal = $menu->price * $item['quantity'];
            $totalPrice += $itemTotal;
            $items[] = [
                'menu' => $menu,
                'quantity' => $item['quantity'],
                'subtotal' => $itemTotal
            ];
        }

        $hasQrCode = !empty($vendor->qr_image_path);

        return view('customer.orders.create', compact('vendor', 'items', 'totalPrice', 'cartData', 'hasQrCode'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|json',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
        ]);

        $cart = json_decode($request->cart, true);

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty');
        }

        $vendorId = $cart[0]['vendor_id'] ?? null;
        $totalPrice = 0;

        // Calculate total price
        foreach ($cart as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $totalPrice += $menu->price * $item['quantity'];
        }

        // Upload payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'vendor_id' => $vendorId,
            'total_price' => $totalPrice,
            'payment_proof_path' => $paymentProofPath,
            'status' => 'pending_payment',
        ]);

        // Create order items
        foreach ($cart as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
            ]);
        }

        return redirect()->route('customer.orders.show', $order)->with('success', 'Order placed successfully! Waiting for vendor verification.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['vendor', 'orderItems.menu']);
        return view('customer.orders.show', compact('order'));
    }
}
