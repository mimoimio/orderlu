<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Menu;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of vendors.
     */
    public function index()
    {
        $vendors = Vendor::with('user')->latest()->get();
        return view('customer.vendors.index', compact('vendors'));
    }

    /**
     * Display the specified vendor and their menus.
     */
    public function show(Vendor $vendor)
    {
        $menus = $vendor->menus()->where('is_available', true)->get();
        return view('customer.vendors.show', compact('vendor', 'menus'));
    }

    /**
     * Display a single menu item.
     */
    public function showMenu(Menu $menu)
    {
        return view('customer.menus.show', compact('menu'));
    }
}
