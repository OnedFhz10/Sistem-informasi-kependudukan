@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header', 'Manajemen Pengguna Sistem')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-700">Daftar Pengguna</h2>
        <a href="{{ route('users.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            <i class="fas fa-user-plus mr-2"></i>Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">{{ session('error') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-bold">{{ $user->name }}</td>
                        <td class="py-4 px-6">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @if ($user->role == 'admin')
                                <span
                                    class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs font-bold">Admin</span>
                            @else
                                <span
                                    class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-xs font-bold">Staff</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="text-blue-600 font-bold mr-2 hover:underline">Edit</a>

                            @if (auth()->id() != $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus user ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 font-bold hover:underline">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
