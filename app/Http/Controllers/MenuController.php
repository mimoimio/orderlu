<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the vendor's menus.
     */
    public function index()
    {
        if (!Auth::user()->vendor) {
            return redirect()->route('vendor.profile.edit')->with('error', 'Please set up your vendor profile first.');
        }

        $menus = Auth::user()->vendor->menus()->latest()->get();
        return view('vendor.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create()
    {
        if (!Auth::user()->vendor) {
            return redirect()->route('vendor.profile.edit')->with('error', 'Please set up your vendor profile first.');
        }

        return view('vendor.menus.create');
    }

    /**
     * Store a newly created menu in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->vendor) {
            return redirect()->route('vendor.profile.edit')->with('error', 'Please set up your vendor profile first.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB max
            'is_available' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'is_available']);
        $data['vendor_id'] = Auth::user()->vendor->id;
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('vendor.menus.index')->with('success', 'Menu item created successfully!');
    }

    /**
     * Show the form for editing the specified menu.
     */
    public function edit(Menu $menu)
    {
        // Ensure vendor owns this menu
        if ($menu->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        return view('vendor.menus.edit', compact('menu'));
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // Ensure vendor owns this menu
        if ($menu->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB max
            'is_available' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'price']);
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->image_path) {
                Storage::disk('public')->delete($menu->image_path);
            }
            $data['image_path'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('vendor.menus.index')->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy(Menu $menu)
    {
        // Ensure vendor owns this menu
        if ($menu->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }

        // Delete image
        if ($menu->image_path) {
            Storage::disk('public')->delete($menu->image_path);
        }

        $menu->delete();

        return redirect()->route('vendor.menus.index')->with('success', 'Menu item deleted successfully!');
    }
}
