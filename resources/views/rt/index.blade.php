@extends('layouts.app')

@section('title', 'Data RT')
@section('header', 'Master Data RT')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-700">Daftar RT</h2>

        @if (auth()->user()->role == 'admin')
            <a href="{{ route('rt.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-plus mr-2"></i>Tambah RT
            </a>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">RW Induk</th>
                    <th class="py-3 px-6 text-left">Nomor RT</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($rts as $index => $rt)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $index + 1 }}</td>
                        <td class="py-4 px-6">RW {{ $rt->rw->nomor ?? '-' }}</td>
                        <td class="py-4 px-6 font-bold">RT {{ $rt->nomor }}</td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('rt.edit', $rt->id) }}" class="text-blue-600 font-bold mr-2">Edit</a>
                                <form action="{{ route('rt.destroy', $rt->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 font-bold">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6">Data Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
