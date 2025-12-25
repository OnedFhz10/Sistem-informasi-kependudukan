@extends('layouts.app')

@section('title', 'Data Penduduk')
@section('header', 'Data Kependudukan')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-700">
            <i class="fas fa-users mr-2"></i>
            {{ $judul ?? 'Daftar Penduduk' }}
        </h2>

        <form action="{{ route('penduduk.index') }}" method="GET" class="flex-1 w-full md:w-auto md:mx-4 relative">
            <input type="search" name="search" value="{{ request('search') }}"
                class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                placeholder="Cari NIK atau Nama...">
            <button type="submit"
                class="absolute inset-y-0 right-0 px-4 text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 font-bold text-sm">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="flex gap-2">
            <div class="hidden md:flex gap-2">
                <a href="{{ route('penduduk.export-excel') }}" target="_blank"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-3 rounded shadow text-sm">
                    <i class="fas fa-file-excel"></i> XLS
                </a>
                <a href="{{ route('penduduk.export-pdf') }}" target="_blank"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 rounded shadow text-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>

            @if (auth()->user()->role == 'admin')
                <a href="{{ route('penduduk.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-800 text-white uppercase font-bold text-xs tracking-wider">
                <tr>
                    <th class="py-3 px-4 text-center w-12">No</th>
                    <th class="py-3 px-4 text-left">NIK</th>
                    <th class="py-3 px-4 text-left">Nama Lengkap</th>
                    <th class="py-3 px-4 text-center">JK</th>
                    <th class="py-3 px-4 text-left">Tempat, Tgl Lahir</th>
                    <th class="py-3 px-4 text-left">Alamat Lengkap</th>
                    <th class="py-3 px-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-200">
                @forelse($penduduks as $index => $warga)
                    <tr class="hover:bg-blue-50 transition duration-150">
                        <td class="py-3 px-4 text-center">{{ $penduduks->firstItem() + $index }}</td>
                        <td class="py-3 px-4 font-mono font-semibold text-blue-600 whitespace-nowrap">{{ $warga->nik }}
                        </td>
                        <td class="py-3 px-4 font-bold uppercase text-gray-800 whitespace-nowrap">{{ $warga->nama_lengkap }}
                        </td>
                        <td class="py-3 px-4 text-center">{{ $warga->jenis_kelamin }}</td>
                        <td class="py-3 px-4 whitespace-nowrap">{{ $warga->tempat_lahir }},
                            {{ $warga->tanggal_lahir->format('d-m-Y') }}</td>
                        <td class="py-3 px-4 text-xs whitespace-nowrap">
                            @if ($warga->kartuKeluarga)
                                <span
                                    class="font-bold block text-gray-700">{{ $warga->kartuKeluarga->dusun->nama ?? '-' }}</span>
                                <span class="text-gray-500">RT {{ $warga->kartuKeluarga->rt->nomor ?? '-' }} / RW
                                    {{ $warga->kartuKeluarga->rw->nomor ?? '-' }}</span>
                            @else
                                <span class="text-red-500 italic">Data KK Hilang</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('penduduk.show', $warga->id) }}"
                                    class="text-green-600 hover:text-green-800 transform hover:scale-110 transition"
                                    title="Lihat Detail"><i class="fas fa-eye text-lg"></i></a>
                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('penduduk.edit', $warga->id) }}"
                                        class="text-blue-600 hover:text-blue-900 transform hover:scale-110 transition"
                                        title="Edit"><i class="fas fa-edit text-lg"></i></a>
                                    <form action="{{ route('penduduk.destroy', $warga->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Hapus data penduduk ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 transform hover:scale-110 transition"
                                            title="Hapus"><i class="fas fa-trash text-lg"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                            Data tidak ditemukan dalam arsip ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 bg-white p-2 rounded shadow-sm">
        {{ $penduduks->links() }}
    </div>
@endsection
