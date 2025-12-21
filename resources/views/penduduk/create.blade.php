@extends('layouts.app')

@section('title', 'Tambah Data Penduduk')
@section('header', 'Formulir Data Penduduk (Lengkap)')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-5xl mx-auto mb-10">
        <div class="bg-blue-600 p-4">
            <h2 class="text-xl text-white font-bold"><i class="fas fa-user-plus mr-2"></i>Input Data Warga</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('penduduk.store') }}" method="POST">
                @csrf

                <div class="bg-gray-50 p-4 rounded mb-6 border-l-4 border-blue-500">
                    <h3 class="text-gray-800 font-bold mb-4">A. Identitas Diri & Lokasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nomor KK (Cari No / Nama Kepala)</label>
                            <select name="kartu_keluarga_id" required class="select2 w-full border p-2 rounded bg-white">
                                <option value="">-- Ketik untuk mencari KK --</option>
                                @foreach ($kks as $kk)
                                    <option value="{{ $kk->id }}">
                                        {{ $kk->nomor_kk }} - {{ $kk->kepala_keluarga }}
                                        ({{ $kk->alamat_lengkap ?? 'Alamat -' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-1 flex justify-between items-center">
                                <p class="text-xs text-gray-500">*Ketik Nomor KK atau Nama Kepala Keluarga</p>
                                <a href="{{ route('kk.create') }}" target="_blank"
                                    class="text-xs text-blue-600 font-bold hover:underline">
                                    + Buat KK Baru (Jika belum ada)
                                </a>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">NIK (16 Digit)</label>
                            <input type="number" name="nik" placeholder="Contoh: 3201..."
                                class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="L"
                                        class="form-radio text-blue-600" required>
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="P"
                                        class="form-radio text-pink-600" required>
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full border p-2 rounded" required>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded mb-6 border-l-4 border-yellow-500">
                    <h3 class="text-gray-800 font-bold mb-4">B. Data Sosial, Pendidikan & Keluarga</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Status Hubungan Dalam Keluarga</label>
                            <select name="status_hubungan" class="w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Kepala Keluarga">Kepala Keluarga</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Menantu">Menantu</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Mertua">Mertua</option>
                                <option value="Famili Lain">Famili Lain</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Pendidikan Terakhir</label>
                            <select name="pendidikan" class="w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Pendidikan --</option>
                                <option value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                                <option value="Belum Tamat SD">Belum Tamat SD</option>
                                <option value="SD/Sederajat">SD/Sederajat</option>
                                <option value="SLTP/Sederajat">SLTP/Sederajat (SMP)</option>
                                <option value="SLTA/Sederajat">SLTA/Sederajat (SMA)</option>
                                <option value="Diploma I/II">Diploma I/II</option>
                                <option value="Akademi/Diploma III/S.Muda">Akademi/Diploma III/S.Muda</option>
                                <option value="Diploma IV/Strata I">Diploma IV/Strata I (S1)</option>
                                <option value="Strata II">Strata II (S2)</option>
                                <option value="Strata III">Strata III (S3)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Pekerjaan</label>
                            <select name="pekerjaan" class="select2 w-full border p-2 rounded bg-white" required>
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach ($pekerjaans as $p)
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Status Data</label>
                            <select name="status" class="w-full border p-2 rounded bg-white">
                                <option value="aktif">Aktif (Hidup & Tinggal)</option>
                                <option value="meninggal">Meninggal Dunia</option>
                                <option value="pindah">Pindah Domisili</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded mb-8 border-l-4 border-purple-500">
                    <h3 class="text-gray-800 font-bold mb-4">C. Nama Orang Tua (Sesuai Akta/KK)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="w-full border p-2 rounded"
                                placeholder="Nama Lengkap Ayah" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="w-full border p-2 rounded"
                                placeholder="Nama Lengkap Ibu" required>
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
