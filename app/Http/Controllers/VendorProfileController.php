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

        // Create vendor profile if it doesn't exist
        if (!$vendor) {
            $vendor = Auth::user()->vendor()->create([
                'business_name' => Auth::user()->name . "'s Business",
            ]);
        }

        return view('vendor.profile.edit', compact('vendor'));
    }

    /**
     * Update the vendor profile.
     */
    public function update(Request $request)
    {
        $vendor = Auth::user()->vendor;

        // Create vendor profile if it doesn't exist
        if (!$vendor) {
            $vendor = Auth::user()->vendor()->create([
                'business_name' => $request->business_name,
            ]);
        }

        try {
            $request->validate([
                'business_name' => 'required|string|max:255',
                'qr_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB max
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Check if it's a file size error
            if ($request->hasFile('qr_image') && $request->file('qr_image')->getSize() > 2048 * 1024) {
                return back()->with('error', 'The uploaded image is too large. Please upload an image smaller than 2MB.')->withInput();
            }
            throw $e;
        }

        $data = ['business_name' => $request->business_name];

        if ($request->hasFile('qr_image')) {
            try {
                // Delete old QR code
                if ($vendor->qr_image_path) {
                    Storage::disk('public')->delete($vendor->qr_image_path);
                }
                $data['qr_image_path'] = $request->file('qr_image')->store('qr-codes', 'public');
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to upload image. The file may be too large or corrupted.')->withInput();
            }
        }

        $vendor->update($data);

        return redirect()->route('vendor.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
