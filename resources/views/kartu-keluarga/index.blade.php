@extends('layouts.app')

@section('title', 'Data Kartu Keluarga')
@section('header', 'Data Kartu Keluarga')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-700">Daftar KK</h2>

        @if (auth()->user()->role == 'admin')
            <a href="{{ route('kk.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-plus mr-2"></i>Tambah KK
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">No KK</th>
                    <th class="py-3 px-6 text-left">Kepala Keluarga</th>
                    <th class="py-3 px-6 text-left">Alamat</th>
                    <th class="py-3 px-6 text-left">Wilayah (RT/RW)</th>

                    @if (auth()->user()->role == 'admin')
                        <th class="py-3 px-6 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($kks as $kk)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6 font-mono font-bold">{{ $kk->nomor_kk }}</td>
                        <td class="py-4 px-6 font-bold uppercase">{{ $kk->kepala_keluarga }}</td>
                        <td class="py-4 px-6">{{ Str::limit($kk->alamat_lengkap, 30) }}</td>
                        <td class="py-4 px-6">
                            RT {{ $kk->rt->nomor ?? '-' }} / RW {{ $kk->rw->nomor ?? '-' }}
                        </td>

                        @if (auth()->user()->role == 'admin')
                            <td class="py-4 px-6 text-center flex justify-center space-x-2">
                                <a href="{{ route('kk.edit', $kk->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-bold mr-2">Edit</a>
                                <form action="{{ route('kk.destroy', $kk->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus Data KK Ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Hapus</button>
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
        <div class="p-4">
            {{ $kks instanceof \Illuminate\Pagination\LengthAwarePaginator ? $kks->links() : '' }}
        </div>
    </div>
@endsection
