<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorProfileController extends Controller
{
    /**
     * Show the vendor profile edit form.
     */
    public function edit()
    {
        $vendor = Auth::user()->vendor;
        return view('vendor.profile.edit', compact('vendor'));
    }

    /**
     * Update the vendor profile.
     */
    public function update(Request $request)
    {
        $vendor = Auth::user()->vendor;

        $request->validate([
            'business_name' => 'required|string|max:255',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB max
        ]);

        $data = ['business_name' => $request->business_name];

        if ($request->hasFile('qr_image')) {
            // Delete old QR code
            if ($vendor->qr_image_path) {
                Storage::disk('public')->delete($vendor->qr_image_path);
            }
            $data['qr_image_path'] = $request->file('qr_image')->store('qr-codes', 'public');
        }

        $vendor->update($data);

        return redirect()->route('vendor.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
