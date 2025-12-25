@extends('layouts.app')

@section('title', 'Data RT')
@section('header', 'Master Data RT')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-700">Daftar Rukun Tetangga (RT)</h2>
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
                    <th class="py-3 px-6 text-left">No RT</th>
                    <th class="py-3 px-6 text-left">Induk RW / Dusun</th>
                    <th class="py-3 px-6 text-left">Kepala RT</th>

                    <th class="py-3 px-6 text-center">Jml KK</th>
                    <th class="py-3 px-6 text-center">Penduduk</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($rts as $rt)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-bold">RT {{ $rt->nomor }}</td>
                        <td class="py-4 px-6">
                            RW {{ $rt->rw->nomor }}
                            <span class="text-xs text-gray-500 block">({{ $rt->rw->dusun->nama }})</span>
                        </td>
                        <td class="py-4 px-6">{{ $rt->kepala_rt ?? '-' }}</td>

                        <td class="py-4 px-6 text-center font-bold text-gray-600">{{ $rt->kartu_keluargas_count }}</td>
                        <td class="py-4 px-6 text-center font-bold text-purple-600">{{ $rt->penduduks_count }} Jiwa</td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('rt.edit', $rt->id) }}" class="text-blue-600 font-bold mr-2">Edit</a>
                                <form action="{{ route('rt.destroy', $rt->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus RT ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 font-bold">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6">Data Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $rts->links() }}</div>
    </div>
@endsection
