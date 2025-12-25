@extends('layouts.app')

@section('title', 'Tambah Data Penduduk')
@section('header', 'Tambah Data Penduduk')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-5xl mx-auto mb-10">
        <div class="bg-blue-600 p-4">
            <h2 class="text-xl text-white font-bold"><i class="fas fa-user-plus mr-2"></i>Input Data Warga Baru</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('penduduk.store') }}" method="POST">
                @csrf

                <div class="bg-gray-50 p-4 rounded mb-6 border-l-4 border-blue-500">
                    <h3 class="text-gray-800 font-bold mb-4">A. Identitas Diri & Agama</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">NIK (16 Digit)</label>
                            <input type="text" name="nik" value="{{ old('nik') }}"
                                class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 font-mono" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Contoh: 3201xxxxxxxxxxxx" required>
                            @error('nik')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="L"
                                        {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} class="form-radio text-blue-600"
                                        required>
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="P"
                                        {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} class="form-radio text-pink-600"
                                        required>
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Agama</label>
                            <select name="agama" class="w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Agama --</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agm)
                                    <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>
                                        {{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Golongan Darah</label>
                            <select name="golongan_darah" class="w-full border p-2 rounded bg-white">
                                <option value="-">- Tidak Tahu -</option>
                                @foreach (['A', 'B', 'AB', 'O'] as $goldar)
                                    <option value="{{ $goldar }}"
                                        {{ old('golongan_darah') == $goldar ? 'selected' : '' }}>{{ $goldar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="w-full border p-2 rounded" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="w-full border p-2 rounded" required>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded mb-6 border-l-4 border-yellow-500">
                    <h3 class="text-gray-800 font-bold mb-4">B. Data Sosial & Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Kategori Warga</label>
                            <select name="status_dasar" class="w-full border p-2 rounded bg-white" required>
                                <option value="Warga Asli" {{ old('status_dasar') == 'Warga Asli' ? 'selected' : '' }}>
                                    Warga Asli (Lahir Disini)</option>
                                <option value="Pendatang" {{ old('status_dasar') == 'Pendatang' ? 'selected' : '' }}>
                                    Pendatang (Pindah Masuk)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Status Perkawinan</label>
                            <select name="status_perkawinan" class="w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $kawin)
                                    <option value="{{ $kawin }}"
                                        {{ old('status_perkawinan') == $kawin ? 'selected' : '' }}>{{ $kawin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Status Hubungan Keluarga</label>
                            <select name="status_hubungan" class="w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach (['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Orang Tua', 'Mertua', 'Famili Lain'] as $sh)
                                    <option value="{{ $sh }}"
                                        {{ old('status_hubungan') == $sh ? 'selected' : '' }}>{{ $sh }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Pendidikan Terakhir</label>
                            <select name="pendidikan" class="w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach (['Tidak/Belum Sekolah', 'SD/Sederajat', 'SLTP/Sederajat', 'SLTA/Sederajat', 'Diploma I/II', 'Akademi/Diploma III/S.Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'] as $edu)
                                    <option value="{{ $edu }}" {{ old('pendidikan') == $edu ? 'selected' : '' }}>
                                        {{ $edu }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Pekerjaan</label>
                            <select name="pekerjaan" class="select2 w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach ($pekerjaans as $p)
                                    <option value="{{ $p }}" {{ old('pekerjaan') == $p ? 'selected' : '' }}>
                                        {{ $p }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">No. Telepon / WA</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                class="w-full border p-2 rounded" placeholder="Contoh: 0812xxxx">
                        </div>

                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded mb-8 border-l-4 border-purple-500">
                    <h3 class="text-gray-800 font-bold mb-4">C. Keluarga & Orang Tua</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Ayah</label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                class="w-full border p-2 rounded" placeholder="Nama Lengkap Ayah" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Ibu</label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                class="w-full border p-2 rounded" placeholder="Nama Lengkap Ibu" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-bold mb-2">Nomor KK (Cari No / Nama Kepala)</label>
                            <select name="kartu_keluarga_id" required class="select2 w-full border p-2 rounded bg-white">
                                <option value="">-- Ketik untuk mencari KK --</option>
                                @foreach ($kks as $kk)
                                    <option value="{{ $kk->id }}"
                                        {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                        {{ $kk->nomor_kk }} - {{ $kk->kepala_keluarga }}
                                        ({{ $kk->dusun->nama ?? 'Dusun -' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-2 text-right">
                                <a href="{{ route('kk.create') }}" target="_blank"
                                    class="text-sm text-blue-600 font-bold hover:underline">
                                    + Buat KK Baru (Jika belum ada)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 border-t pt-4">
                    <a href="{{ route('penduduk.index') }}"
                        class="bg-gray-500 text-white font-bold py-2 px-6 rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
