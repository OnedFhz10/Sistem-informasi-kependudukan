@extends('layouts.app')

@section('title', 'Detail Data Penduduk')
@section('header', 'Detail Data Penduduk')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('penduduk.index') }}" class="text-gray-600 hover:text-blue-600 font-bold transition">
                &larr; Kembali ke Daftar
            </a>
            @if (auth()->user()->role == 'admin')
                <div class="flex gap-2">
                    <a href="{{ route('penduduk.edit', $penduduk->id) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>Edit Data
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">

            <div class="bg-blue-600 p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h2 class="text-3xl font-bold uppercase">{{ $penduduk->nama_lengkap }}</h2>
                        <p class="text-blue-100 font-mono text-lg mt-1">NIK: {{ $penduduk->nik }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @if ($penduduk->status == 'aktif')
                            <span class="bg-green-500 text-white px-4 py-1 rounded-full font-bold shadow">Warga Aktif</span>
                        @elseif($penduduk->status == 'meninggal')
                            <span class="bg-black text-white px-4 py-1 rounded-full font-bold shadow">Meninggal Dunia</span>
                        @else
                            <span class="bg-yellow-500 text-white px-4 py-1 rounded-full font-bold shadow">Pindah
                                Domisili</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    <div class="col-span-1 md:col-span-2 border-b pb-2 mb-2">
                        <h3 class="text-blue-600 font-bold text-lg"><i class="fas fa-id-card mr-2"></i>Identitas Diri</h3>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-gray-800 text-lg">
                            {{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Usia Saat Ini</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $penduduk->usia }} Tahun</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Jenis Kelamin</p>
                        <p class="font-bold text-gray-800 text-lg">
                            {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Pekerjaan</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $penduduk->pekerjaan }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Pendidikan Terakhir</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $penduduk->pendidikan }}</p>
                    </div>

                    <div class="col-span-1 md:col-span-2 border-b pb-2 mb-2 mt-4">
                        <h3 class="text-blue-600 font-bold text-lg"><i class="fas fa-home mr-2"></i>Keluarga & Lokasi</h3>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Nomor Kartu Keluarga (KK)</p>
                        <a href="{{ route('kk.show', $penduduk->kartu_keluarga_id) }}"
                            class="font-bold text-blue-600 hover:underline text-lg">
                            {{ $penduduk->kartuKeluarga->nomor_kk ?? '-' }}
                        </a>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Status Dalam Keluarga</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $penduduk->status_hubungan }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Nama Ayah</p>
                        <p class="font-bold text-gray-800 text-lg uppercase">{{ $penduduk->nama_ayah }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Nama Ibu</p>
                        <p class="font-bold text-gray-800 text-lg uppercase">{{ $penduduk->nama_ibu }}</p>
                    </div>

                    <div class="col-span-1 md:col-span-2 bg-gray-50 p-4 rounded-lg border">
                        <p class="text-gray-500 text-sm mb-1">Alamat Lengkap (Sesuai KK)</p>
                        <p class="font-bold text-gray-800">
                            {{ $penduduk->kartuKeluarga->alamat_lengkap ?? '-' }}
                        </p>
                        <p class="text-gray-600 mt-1">
                            RT {{ $penduduk->kartuKeluarga->rt->nomor ?? '-' }} /
                            RW {{ $penduduk->kartuKeluarga->rw->nomor ?? '-' }} -
                            {{ $penduduk->kartuKeluarga->dusun->nama ?? 'Dusun Belum Terdata' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
