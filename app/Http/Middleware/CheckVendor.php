<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Vendor;

class CheckVendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isVendor()) {
            abort(403, 'Access denied. Vendors only.');
        }

        // Auto-create vendor profile if it doesn't exist
        if (!$request->user()->vendor) {
            Vendor::create([
                'user_id' => $request->user()->id,
                'business_name' => $request->user()->name . "'s Business",
            ]);
        }

        return $next($request);
    }
}
