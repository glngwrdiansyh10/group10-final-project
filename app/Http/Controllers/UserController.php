<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('cabang')->where('role', '!=', 'owner');

        if ($request->filled('cabang_id')) {
            $query->where('cabang_id', $request->cabang_id);
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users  = $query->latest()->paginate(15)->withQueryString();
        $cabang = Cabang::where('is_active', true)->get();

        return view('users.index', compact('users', 'cabang'));
    }

    public function create()
    {
        $cabang = Cabang::where('is_active', true)->get();
        return view('users.create', compact('cabang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', Rule::in(['manajer', 'supervisor', 'kasir', 'gudang'])],
            'cabang_id' => ['required', 'exists:cabang,id'],
            'telepon'   => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('owner.users.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $cabang = Cabang::where('is_active', true)->get();
        return view('users.edit', compact('user', 'cabang'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', Rule::in(['manajer', 'supervisor', 'kasir', 'gudang'])],
            'cabang_id' => ['required', 'exists:cabang,id'],
            'telepon'   => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('owner.users.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('owner.users.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun pegawai berhasil {$status}.");
    }
}
