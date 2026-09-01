<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->paginate(15);
        return Inertia::render('Admin/Services/Index', ['services' => $services]);
    }

    public function create()
    {
        return Inertia::render('Admin/Services/Create');
    }

    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $images = collect($validated['images'])
            ->map(fn ($image) => '/storage/' . $image->store('services', 'public'))
            ->values();

        return response()->json(['images' => $images]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services',
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'short' => 'required|string',
            'description' => 'required|string',
            'description2' => 'nullable|string',
            'image' => 'required|string',
            'image2' => 'nullable|string',
            'image3' => 'nullable|string',
            'steps' => 'nullable|array',
            'benefits' => 'nullable|array',
            'facts' => 'nullable|array',
        ]);

        $service = Service::create($validated);

        NewsletterSubscriber::notifyAll(
            type: 'service',
            title: $service->title,
            excerpt: strip_tags($service->short),
            image: url($service->image),
            link: url('/service-details/' . $service->slug),
        );

        return redirect()->route('admin.services.index')->with('success', 'Service créé avec succès');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Admin/Services/Edit', ['service' => $service]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services,slug,' . $service->id,
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'short' => 'required|string',
            'description' => 'required|string',
            'description2' => 'nullable|string',
            'image' => 'required|string',
            'image2' => 'nullable|string',
            'image3' => 'nullable|string',
            'steps' => 'nullable|array',
            'benefits' => 'nullable|array',
            'facts' => 'nullable|array',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service mis à jour avec succès');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès');
    }

    public function toggleVisibility(Service $service)
    {
        $service->update(['is_visible' => !$service->is_visible]);
        return redirect()->route('admin.services.index')->with('success',
            $service->is_visible ? 'Service rendu visible' : 'Service masqué'
        );
    }
}
