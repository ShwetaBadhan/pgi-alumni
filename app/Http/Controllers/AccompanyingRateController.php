<?php
namespace App\Http\Controllers;

use App\Models\AccompanyingPersonRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccompanyingRateController extends Controller
{
    public function index()
    {
        $rate = AccompanyingPersonRate::first();
        return view('backend.pages.settings.accompanying-rate', compact('rate'));
    }

    public function store(Request $request)
    {
        // 1. Simple Validation
        $request->validate([
            'base_rate' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // 2. Checkbox values ko safely handle karein
        $isDiscountEnabled = $request->has('is_discount_enabled');
        $status = $request->has('status');
        
        // Agar discount enabled nahi hai, toh percentage null kar do
        $discountPercentage = $isDiscountEnabled ? $request->input('discount_percentage') : null;

        // 3. Database me Save/Update karein
        try {
            AccompanyingPersonRate::updateOrCreate(
                ['id' => 1], // Hamesha ID 1 par hi update/create karega
                [
                    'base_rate' => $request->input('base_rate'),
                    'is_discount_enabled' => $isDiscountEnabled,
                    'discount_percentage' => $discountPercentage,
                    'status' => $status,
                ]
            );
            
            return back()->with('success', 'Accompanying Person Rate & Discount updated successfully!');
            
        } catch (\Exception $e) {
            // Agar koi database error aaye toh log me likha jayega
            Log::error('Accompanying Rate Save Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save settings. Please check logs.');
        }
    }
}