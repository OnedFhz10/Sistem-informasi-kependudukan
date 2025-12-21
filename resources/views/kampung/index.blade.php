@extends('layouts.app')

@section('title', 'Data Kampung')
@section('header', 'Master Data Kampung')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-700">Daftar Kampung</h2>

        @if (auth()->user()->role == 'admin')
            <a href="{{ route('kampung.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-plus mr-2"></i>Tambah Kampung
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-bold uppercase tracking-wider">No</th>
                    <th class="py-3 px-6 text-left text-xs font-bold uppercase tracking-wider">Nama Kampung</th>
                    <th class="py-3 px-6 text-left text-xs font-bold uppercase tracking-wider">Ketua/Kepala Kampung</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-6 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($kampungs as $index => $k)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-bold">{{ $k->nama_kampung }}</td>
                        <td class="py-4 px-6">{{ $k->kepala_kampung ?? '-' }}</td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-4 px-6 text-center flex justify-center space-x-2">
                                <a href="{{ route('kampung.edit', $k->id) }}"
                                    class="text-yellow-500 hover:text-yellow-600 font-bold">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('kampung.destroy', $k->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kampung ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-bold ml-2">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">Belum ada data kampung.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
