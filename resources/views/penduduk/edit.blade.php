@extends('layouts.app')

@section('title', 'Edit Data Penduduk')
@section('header', 'Edit Data Penduduk')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-5xl mx-auto mb-10">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-xl text-white font-bold"><i class="fas fa-edit mr-2"></i>Edit Data Warga</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-gray-50 p-4 rounded mb-6 border-l-4 border-yellow-500">
                    <h3 class="text-gray-800 font-bold mb-4">A. Identitas & Data Sosial</h3>
                    @include('penduduk.partials.form_edit_atas')
                </div>

                <div x-data="{ statusMutasi: '{{ old('status', $penduduk->status) }}' }" class="bg-red-50 p-4 rounded border border-red-200 mt-6">

                    <h3 class="text-red-800 font-bold mb-4"><i class="fas fa-exclamation-triangle mr-2"></i>Status
                        Kependudukan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-red-700 font-bold mb-2">Status Saat Ini</label>
                            <select name="status" x-model="statusMutasi" required
                                class="w-full px-3 py-2 border border-red-300 rounded-lg bg-white text-red-900 font-semibold focus:ring-2 focus:ring-red-500">
                                <option value="aktif">Aktif (Tampil di Utama)</option>
                                <option value="meninggal">Meninggal (Arsip Kematian)</option>
                                <option value="pindah">Pindah Keluar (Arsip Pindah)</option>
                            </select>
                            <p class="text-xs text-red-500 mt-2">
                                *Jika diubah ke Meninggal/Pindah, data akan hilang dari tabel utama.
                            </p>
                        </div>

                        <div x-show="statusMutasi == 'meninggal'" x-transition
                            class="bg-white p-3 rounded border border-red-200">
                            <label class="block text-red-700 font-bold mb-2">Tanggal Meninggal Dunia</label>
                            <input type="date" name="tanggal_meninggal"
                                value="{{ old('tanggal_meninggal', $penduduk->tanggal_meninggal ? $penduduk->tanggal_meninggal->format('Y-m-d') : '') }}"
                                class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-red-500">
                        </div>

                        <div x-show="statusMutasi == 'pindah'" x-transition
                            class="bg-white p-3 rounded border border-red-200">
                            <label class="block text-red-700 font-bold mb-2">Tanggal Pindah Keluar</label>
                            <input type="date" name="tanggal_pindah"
                                value="{{ old('tanggal_pindah', $penduduk->tanggal_pindah ? $penduduk->tanggal_pindah->format('Y-m-d') : '') }}"
                                class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-red-500">
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-6">
                    <a href="{{ route('penduduk.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Update
                        Data</button>
                </div>
            </form>
        </div>
    </div>

@endsection
