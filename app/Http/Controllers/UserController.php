<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        return view('users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,staff', // Pastikan hanya admin/staff
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // Form edit user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update data user
    // Update data user
    public function update(Request $request, User $user)
    {
        // 1. Validasi (Hapus validasi 'role')
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        // 2. Siapkan Data (Hanya Nama & Email)
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            // KITA HAPUS DATA ROLE DARI SINI AGAR TIDAK TER-UPDATE
        ];

        // 3. Cek Password (Jika diisi, ganti password)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 4. Update Database
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui');
    }

    // Hapus user
    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}