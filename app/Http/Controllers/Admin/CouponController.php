<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(15);
        return Inertia::render('Admin/Coupons/Index', ['coupons' => $coupons]);
    }

    public function create()
    {
        return Inertia::render('Admin/Coupons/Create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCoupon($request);
        $validated['code'] = Str::upper(trim($validated['code']));

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Code promo créé avec succès');
    }

    public function edit(Coupon $coupon)
    {
        return Inertia::render('Admin/Coupons/Edit', ['coupon' => $coupon]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $this->validateCoupon($request, $coupon->id);
        $validated['code'] = Str::upper(trim($validated['code']));

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Code promo mis à jour avec succès');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Code promo supprimé avec succès');
    }

    private function validateCoupon(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code' => [
                'required', 'string', 'max:50',
                Rule::unique('coupons', 'code')->ignore($ignoreId),
            ],
            'type' => ['required', Rule::in(['percent', 'fixed'])],
            'value' => [
                'required', 'integer', 'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'percent' && $value > 100) {
                        $fail('Le pourcentage ne peut pas dépasser 100.');
                    }
                },
            ],
            'min_order_amount' => ['nullable', 'integer', 'min:0'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'max_uses_per_user' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['boolean'],
        ]);
    }
}
