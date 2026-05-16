<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(15);
        return Inertia::render('Admin/Products/Index', ['products' => $products]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:products',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'short' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'images' => 'nullable|array',
            'price' => 'required|integer|min:0',
            'price_promo' => 'nullable|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'badge' => 'nullable|string|max:50',
            'stars' => 'nullable|integer|min:1|max:5',
            'reviews' => 'nullable|integer|min:0',
            'in_stock' => 'boolean',
            'details' => 'nullable|array',
            'features' => 'nullable|array',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'short' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'images' => 'nullable|array',
            'price' => 'required|integer|min:0',
            'price_promo' => 'nullable|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'badge' => 'nullable|string|max:50',
            'stars' => 'nullable|integer|min:1|max:5',
            'reviews' => 'nullable|integer|min:0',
            'in_stock' => 'boolean',
            'details' => 'nullable|array',
            'features' => 'nullable|array',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès');
    }
}
