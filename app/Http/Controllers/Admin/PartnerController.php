<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('order')->orderBy('id')->get();
        return Inertia::render('Admin/Partners/Index', ['partners' => $partners]);
    }

    public function create()
    {
        return Inertia::render('Admin/Partners/Create');
    }

    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:4096',
        ]);

        $images = collect($validated['images'])
            ->map(fn ($image) => '/storage/' . $image->store('partners', 'public'))
            ->values();

        return response()->json(['images' => $images]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partenaire créé avec succès');
    }

    public function edit(Partner $partner)
    {
        return Inertia::render('Admin/Partners/Edit', ['partner' => $partner]);
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $partner->update($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partenaire mis à jour avec succès');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partenaire supprimé avec succès');
    }
}
