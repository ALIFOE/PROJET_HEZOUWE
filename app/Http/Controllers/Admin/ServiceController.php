<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services',
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
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

        Service::create($validated);

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
            'icon' => 'required|string|max:100',
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
}
