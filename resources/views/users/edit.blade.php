@extends('layouts.app')

@section('title', 'Edit User')
@section('header', 'Edit Pengguna')

@section('content')
    <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-white font-bold text-lg">Edit Data User</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                </div>

                <div class="mb-4 bg-yellow-50 p-3 rounded border border-yellow-200">
                    <label class="block text-gray-700 font-bold mb-2">Ganti Password (Opsional)</label>
                    <input type="password" name="password"
                        class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="Kosongkan jika tidak ingin mengganti">
                    <p class="text-xs text-gray-500 mt-1">*Isi kolom ini HANYA jika ingin mengubah password lama.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Role</label>
                    <div class="w-full border border-gray-300 p-2 rounded bg-gray-200 text-gray-600 font-bold">
                        {{ ucfirst($user->role) }}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Role tidak dapat diubah pada menu edit.
                    </p>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('users.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="bg-yellow-500 text-white px-4 py-2 rounded font-bold hover:bg-yellow-600">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
