@extends('layouts.app')

@section('title', 'Profil Desa')
@section('header', 'Pengaturan Profil Desa')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gray-800 p-4 flex justify-between items-center">
            <h2 class="text-white font-bold text-lg">Identitas Desa</h2>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-6 mb-0">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6">
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="col-span-1 text-center">
                        <label class="block text-gray-700 font-bold mb-2">Logo Desa</label>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 mb-4">
                            @if ($profil->logo)
                                <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo Desa"
                                    class="w-32 h-32 mx-auto object-contain">
                            @else
                                <div
                                    class="w-32 h-32 mx-auto bg-gray-200 flex items-center justify-center rounded-full text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Belum ada logo</p>
                            @endif
                        </div>

                        <input type="file" name="logo"
                            class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-2 text-left">Format: JPG, PNG. Maks: 2MB.</p>
                    </div>

                    <div class="col-span-1 md:col-span-2 space-y-4">

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Desa</label>
                            <input type="text" name="nama_desa" value="{{ $profil->nama_desa }}"
                                class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Alamat Kantor Desa</label>
                            <textarea name="alamat" rows="3" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>{{ $profil->alamat }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ $profil->kode_pos }}"
                                    class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">No. Telepon</label>
                                <input type="text" name="telepon" value="{{ $profil->telepon }}"
                                    class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Email Resmi</label>
                            <input type="email" name="email_desa" value="{{ $profil->email_desa }}"
                                class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                        </div>

                    </div>
                </div>

                <div class="mt-8 flex justify-end border-t pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
