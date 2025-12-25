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
                    <th class="py-3 px-6 text-left">Nama Dusun & Kadus</th>

                    <th class="py-3 px-6 text-center">Jml RW</th>
                    <th class="py-3 px-6 text-center">Jml RT</th>
                    <th class="py-3 px-6 text-center">Jml KK</th>
                    <th class="py-3 px-6 text-center">Penduduk</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($dusuns as $index => $d)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $index + 1 }}</td>

                        <td class="py-4 px-6">
                            <div class="font-bold text-gray-800">{{ $d->nama }}</div>
                            <div class="text-xs text-gray-500">
                                Kadus: {{ $d->kepala_dusun ?? '(Belum ada)' }}
                            </div>
                        </td>

                        <td class="py-4 px-6 text-center">
                            <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $d->rws_count }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">
                                {{ $d->rts_count }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center font-bold text-gray-600">
                            {{ $d->kartu_keluargas_count }}
                        </td>
                        <td class="py-4 px-6 text-center font-bold text-purple-600">
                            {{ $d->penduduks_count }} Jiwa
                        </td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('dusun.edit', $d->id) }}"
                                    class="text-blue-600 font-bold mr-2 hover:underline">Edit</a>
                                <form action="{{ route('dusun.destroy', $d->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus Dusun {{ $d->nama }}? Data RW/RT di dalamnya bisa ikut terhapus/error.');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 font-bold hover:underline">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6">Data Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $dusuns->links() }}
        </div>
    </div>
@endsection
