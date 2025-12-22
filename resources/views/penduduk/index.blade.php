@extends('layouts.app')

@section('title', 'Data Penduduk')
@section('header', 'Data Kependudukan')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-700"><i class="fas fa-users mr-2"></i>Daftar Warga</h2>

        <form action="{{ route('penduduk.index') }}" method="GET" class="flex-1 w-full md:w-auto md:mx-4 relative">
            <input type="search" name="search" value="{{ request('search') }}"
                class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                placeholder="Cari NIK atau Nama...">
            <button type="submit"
                class="absolute inset-y-0 right-0 px-4 text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 font-bold text-sm">Cari</button>
        </form>

        <div class="flex gap-2">
            <a href="{{ route('penduduk.export-excel') }}" target="_blank"
                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow transition duration-200">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
            </a>

            @if (auth()->user()->role == 'admin')
                <a href="{{ route('penduduk.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Warga
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">NIK</th>
                    <th class="py-3 px-4 text-left">Nama Lengkap</th>
                    <th class="py-3 px-4 text-left">L/P</th>
                    <th class="py-3 px-4 text-left">Pekerjaan</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-4 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($penduduks as $warga)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="py-3 px-4 font-mono text-sm">{{ $warga->nik }}</td>
                        <td class="py-3 px-4 font-bold">{{ $warga->nama_lengkap }}</td>
                        <td class="py-3 px-4">{{ $warga->jenis_kelamin }}</td>
                        <td class="py-3 px-4">{{ $warga->pekerjaan ?? '-' }}</td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('penduduk.edit', $warga->id) }}"
                                    class="text-blue-600 hover:text-blue-900 font-bold mr-2">Edit</a>
                                <form action="{{ route('penduduk.destroy', $warga->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6">Data Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $penduduks->links() }}</div>
    </div>
@endsection
