@extends('layouts.app')

@section('title', 'Detail Kartu Keluarga')
@section('header', 'Detail Kartu Keluarga')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <div class="bg-green-600 p-4 flex justify-between items-center">
                <h2 class="text-xl text-white font-bold">📄 Detail KK: {{ $kk->nomor_kk }}</h2>
                <a href="{{ route('kk.index') }}" class="text-white hover:text-gray-200 text-sm font-bold underline">
                    &larr; Kembali
                </a>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Kepala Keluarga</p>
                    <p class="font-bold text-lg text-gray-800 uppercase">{{ $kk->kepala_keluarga }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Alamat Lengkap</p>
                    <p class="font-bold text-gray-800">{{ $kk->alamat_lengkap }}</p>
                    <p class="text-sm text-gray-600">
                        RT {{ $kk->rt->nomor }} / RW {{ $kk->rw->nomor }} - {{ $kk->dusun->nama }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-700">Daftar Anggota Keluarga</h3>
                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                    Total: {{ $kk->penduduks->count() }} Jiwa
                </span>
            </div>

            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 text-gray-600 text-sm uppercase leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">NIK</th>
                        <th class="py-3 px-6 text-left">Nama Lengkap</th>
                        <th class="py-3 px-6 text-left">L/P</th>
                        <th class="py-3 px-6 text-left">TTL</th>
                        <th class="py-3 px-6 text-left">Status Hubungan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($kk->penduduks as $p)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 font-mono font-bold">{{ $p->nik }}</td>
                            <td class="py-3 px-6 font-bold uppercase">{{ $p->nama_lengkap }}</td>
                            <td class="py-3 px-6">{{ $p->jenis_kelamin }}</td>
                            <td class="py-3 px-6">
                                {{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }}
                            </td>
                            <td class="py-3 px-6">
                                @if ($p->status_hubungan == 'Kepala Keluarga')
                                    <span class="text-green-600 font-bold">{{ $p->status_hubungan }}</span>
                                @else
                                    {{ $p->status_hubungan }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400 italic">
                                Belum ada anggota keluarga yang terdaftar di KK ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
