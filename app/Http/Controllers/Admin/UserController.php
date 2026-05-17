<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('role') && in_array($request->role, ['admin', 'user'])) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20)->withQueryString();

        $stats = [
            'total'       => User::count(),
            'admins'      => User::where('role', 'admin')->count(),
            'verified'    => User::whereNotNull('email_verified_at')->count(),
            'with_orders' => User::has('orders')->count(),
        ];

        return Inertia::render('Admin/Users/Index', [
            'users'   => $users,
            'stats'   => $stats,
            'filters' => $request->only(['search', 'role']),
        ]);
    }

    public function show(User $user)
    {
        $user->load(['orders' => fn ($q) => $q->latest()->limit(10)]);
        $user->loadCount('orders');

        return Inertia::render('Admin/Users/Show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        $user->loadCount('orders');
        return Inertia::render('Admin/Users/Edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,user',
        ];

        if ($request->filled('password')) {
            $rules['password']              = 'min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $validated = $request->validate($rules);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}
