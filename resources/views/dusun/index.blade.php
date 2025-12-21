@extends('layouts.app')

@section('title', 'Data Dusun')
@section('header', 'Master Data Dusun')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-700">Daftar Dusun</h2>

        @if (auth()->user()->role == 'admin')
            <a href="{{ route('dusun.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-plus mr-2"></i>Tambah Dusun
            </a>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">Nama Dusun</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($dusuns as $index => $d)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-bold">{{ $d->nama }}</td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('dusun.edit', $d->id) }}" class="text-blue-600 font-bold mr-2">Edit</a>
                                <form action="{{ route('dusun.destroy', $d->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 font-bold">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6">Data Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
