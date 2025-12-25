@extends('layouts.app')

@section('title', 'Tambah Kartu Keluarga')
@section('header', 'Tambah Kartu Keluarga')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-600 p-4">
                <h2 class="text-xl text-white font-bold"><i class="fas fa-plus-circle mr-2"></i>Tambah KK Baru</h2>
            </div>

            <div class="p-6">
                <form action="{{ route('kk.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nomor Kartu Keluarga (16 Digit)</label>
                        <input type="text" name="nomor_kk" value="{{ old('nomor_kk') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 font-mono"
                            maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="Contoh: 3201xxxxxxxxxxxx" required>
                        @error('nomor_kk')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nama Kepala Keluarga</label>
                        <input type="text" name="kepala_keluarga" value="{{ old('kepala_keluarga') }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Nama Lengkap Kepala Keluarga" required>
                        @error('kepala_keluarga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Wilayah (RT / RW / Dusun)</label>
                        <select name="rt_id" required
                            class="select2 w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="">-- Pilih Wilayah Domisili --</option>
                            @foreach ($rts as $rt)
                                <option value="{{ $rt->id }}" {{ old('rt_id') == $rt->id ? 'selected' : '' }}>
                                    RT {{ $rt->nomor }} / RW {{ $rt->rw->nomor }} ({{ $rt->rw->dusun->nama }})
                                </option>
                            @endforeach
                        </select>
                        @error('rt_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Alamat Lengkap (Jalan/Gang/No. Rumah)</label>
                        <textarea name="alamat_lengkap" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Jl. Mawar No. 12, Samping Masjid Al-Hidayah" required>{{ old('alamat_lengkap') }}</textarea>
                        @error('alamat_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('kk.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg transition">
                            <i class="fas fa-save mr-2"></i>Simpan KK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
