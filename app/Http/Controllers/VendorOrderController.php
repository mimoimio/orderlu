<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    /**
     * Display a listing of new orders (pending payment verification).
     */
    public function newOrders()
    {
        if (!Auth::user()->vendor) {
            return redirect()->route('vendor.profile.edit')->with('error', 'Please set up your vendor profile first.');
        }

        $orders = Auth::user()->vendor->orders()
            ->where('status', 'pending_payment')
            ->with(['user', 'orderItems.menu'])
            ->latest()
            ->get();

        return view('vendor.orders.new', compact('orders'));
    }

    /**
     * Display a listing of orders being prepared.
     */
    public function preparingOrders()
    {
        if (!Auth::user()->vendor) {
            return redirect()->route('vendor.profile.edit')->with('error', 'Please set up your vendor profile first.');
        }

        $orders = Auth::user()->vendor->orders()
            ->where('status', 'preparing')
            ->with(['user', 'orderItems.menu'])
            ->latest()
            ->get();

        return view('vendor.orders.preparing', compact('orders'));
    }

    /**
     * Display a listing of completed orders.
     */
    public function completedOrders()
    {
        if (!Auth::user()->vendor) {
            return redirect()->route('vendor.profile.edit')->with('error', 'Please set up your vendor profile first.');
        }

        $orders = Auth::user()->vendor->orders()
            ->where('status', 'done')
            ->with(['user', 'orderItems.menu'])
            ->latest()
            ->get();

        return view('vendor.orders.completed', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure vendor owns this order
        if ($order->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        $order->load(['user', 'orderItems.menu']);
        return view('vendor.orders.show', compact('order'));
    }

    /**
     * Verify payment and update order status to preparing.
     */
    public function verifyPayment(Order $order)
    {
        // Ensure vendor owns this order
        if ($order->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        $order->update(['status' => 'preparing']);

        return redirect()->route('vendor.orders.show', $order)->with('success', 'Payment verified! Order is now being prepared.');
    }

    /**
     * Reject payment and keep order in pending status.
     */
    public function rejectPayment(Order $order)
    {
        // Ensure vendor owns this order
        if ($order->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        return redirect()->route('vendor.orders.show', $order)->with('info', 'Order remains pending. Contact customer if needed.');
    }

    /**
     * Mark order as completed/done.
     */
    public function complete(Order $order)
    {
        // Ensure vendor owns this order
        if ($order->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        $order->update(['status' => 'done']);

        return redirect()->route('vendor.orders.show', $order)->with('success', 'Order marked as ready for pickup!');
    }
}
