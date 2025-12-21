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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $penduduk->nik) }}" required
                            class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}"
                            required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}"
                            required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 bg-white">
                            <option value="L" {{ $penduduk->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ $penduduk->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Status Hubungan</label>
                        <select name="status_hubungan" class="w-full px-3 py-2 border rounded-lg bg-white">
                            @foreach (['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Orang Tua', 'Mertua', 'Famili Lain'] as $sh)
                                <option value="{{ $sh }}"
                                    {{ $penduduk->status_hubungan == $sh ? 'selected' : '' }}>{{ $sh }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Pendidikan</label>
                        <select name="pendidikan" class="w-full px-3 py-2 border rounded-lg bg-white">
                            @foreach (['Tidak/Belum Sekolah', 'SD/Sederajat', 'SLTP/Sederajat', 'SLTA/Sederajat', 'Diploma I/II', 'Akademi/Diploma III/S.Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'] as $edu)
                                <option value="{{ $edu }}" {{ $penduduk->pendidikan == $edu ? 'selected' : '' }}>
                                    {{ $edu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ $penduduk->nama_ayah }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ $penduduk->nama_ibu }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Pekerjaan</label>
                        <select name="pekerjaan"
                            class="select2 w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 bg-white">
                            <option value="">- Pilih Pekerjaan -</option>
                            @foreach ($pekerjaans as $p)
                                <option value="{{ $p }}" {{ $penduduk->pekerjaan == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Status Data</label>
                        <select name="status" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 bg-white">
                            <option value="aktif" {{ $penduduk->status == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="meninggal" {{ $penduduk->status == 'meninggal' ? 'selected' : '' }}>
                                Meninggal</option>
                            <option value="pindah" {{ $penduduk->status == 'pindah' ? 'selected' : '' }}>Pindah
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nomor KK (Cari No / Nama Kepala)</label>
                        <select name="kartu_keluarga_id" required class="select2 w-full border p-2 rounded bg-white">
                            <option value="">-- Ketik untuk mencari KK --</option>
                            @foreach ($kks as $kk)
                                <option value="{{ $kk->id }}"
                                    {{ $penduduk->kartu_keluarga_id == $kk->id ? 'selected' : '' }}>
                                    {{ $kk->nomor_kk }} - {{ $kk->kepala_keluarga }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
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
