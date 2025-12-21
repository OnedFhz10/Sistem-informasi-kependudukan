@extends('layouts.app')

@section('title', 'Tambah User')
@section('header', 'Tambah Pengguna Baru')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-blue-600 p-4">
            <h2 class="text-white font-bold text-lg">Form User Baru</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email (Untuk Login)</label>
                    <input type="email" name="email" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required
                        placeholder="Minimal 6 karakter">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Role (Hak Akses)</label>
                    <select name="role" class="w-full border p-2 rounded bg-white">
                        <option value="staff">Staff (Hanya Lihat)</option>
                        <option value="admin">Admin (Full Akses)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
