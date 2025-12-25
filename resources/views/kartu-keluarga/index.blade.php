@extends('layouts.app')

@section('title', 'Data Kartu Keluarga')
@section('header', 'Data Kartu Keluarga')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-xl font-bold text-gray-700">Daftar Kartu Keluarga (KK)</h2>

        <div class="flex gap-2 w-full md:w-auto">
            <form action="{{ route('kk.index') }}" method="GET" class="flex w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-l-lg px-4 py-2 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Cari No. KK / Nama / Alamat...">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            @if (auth()->user()->role == 'admin')
                <a href="{{ route('kk.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition duration-200 whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i>Tambah KK
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-800 text-white uppercase font-bold text-xs tracking-wider">
                <tr>
                    <th class="py-3 px-6 text-left">No. KK</th>
                    <th class="py-3 px-6 text-left">Kepala Keluarga</th>
                    <th class="py-3 px-6 text-center">Anggota</th>
                    <th class="py-3 px-6 text-left">Wilayah</th>
                    <th class="py-3 px-6 text-left">Alamat Lengkap</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-200">
                @forelse($kks as $kk)
                    <tr class="hover:bg-gray-50 transition duration-150">

                        <td class="py-4 px-6 font-mono font-bold text-blue-600 whitespace-nowrap">
                            {{ $kk->nomor_kk }}
                        </td>

                        <td class="py-4 px-6 font-bold uppercase text-gray-800">
                            {{ $kk->kepala_keluarga }}
                        </td>

                        <td class="py-4 px-6 text-center">
                            @if ($kk->penduduks_count > 0)
                                <span
                                    class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs font-bold shadow-sm">
                                    {{ $kk->penduduks_count }} Jiwa
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-bold">
                                    Kosong
                                </span>
                            @endif
                        </td>

                        <td class="py-4 px-6">
                            <div class="text-sm font-bold text-gray-700">
                                RT {{ $kk->rt->nomor ?? '?' }} / RW {{ $kk->rw->nomor ?? '?' }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $kk->dusun->nama ?? 'Dusun -' }}
                            </div>
                        </td>

                        <td class="py-4 px-6 text-sm text-gray-600">
                            {{ Str::limit($kk->alamat_lengkap, 30) }}
                        </td>

                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <div class="flex item-center justify-center space-x-2">

                                <a href="{{ route('kk.show', $kk->id) }}"
                                    class="text-green-600 hover:text-green-800 font-bold transform hover:scale-110 transition duration-200"
                                    title="Lihat Anggota">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>

                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('kk.edit', $kk->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-bold transform hover:scale-110 transition duration-200"
                                        title="Edit">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>

                                    <form action="{{ route('kk.destroy', $kk->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus KK ini beserta seluruh anggotanya?');">
                                        @csrf @method('DELETE')
                                        <button
                                            class="text-red-600 hover:text-red-800 font-bold transform hover:scale-110 transition duration-200"
                                            title="Hapus">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                            Belum ada data Kartu Keluarga.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 bg-white p-2 rounded shadow-sm">
        {{ $kks->appends(request()->query())->links() }}
    </div>
@endsection
