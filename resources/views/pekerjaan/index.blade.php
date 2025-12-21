@extends('layouts.app')

@section('title', 'Data Pekerjaan')
@section('header', 'Master Data Pekerjaan')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-700">Daftar Pekerjaan</h2>
        <a href="{{ route('pekerjaan.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            <i class="fas fa-plus mr-2"></i>Tambah Pekerjaan
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-4xl">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Nama Pekerjaan</th>
                    <th class="py-3 px-4 text-center">Jumlah Warga</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($pekerjaans as $p)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="py-3 px-4 font-bold">{{ $p->nama }}</td>
                        <td class="py-3 px-4 text-center">
                            <span
                                class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">{{ $p->penduduks_count }}
                                Orang</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('pekerjaan.edit', $p->id) }}" class="text-blue-600 font-bold mr-2">Edit</a>
                            <form action="{{ route('pekerjaan.destroy', $p->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus pekerjaan ini?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pekerjaans->links() }}</div>
@endsection
